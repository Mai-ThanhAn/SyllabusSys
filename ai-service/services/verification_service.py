from models.embedding import calculate_similarity
import re

ACADEMIC_VERBS = [
    "trình bày",
    "phân tích",
    "vận dụng",
    "thiết kế",
    "xây dựng",
    "hình thành",
    "nhận thức",
    "tuân thủ",
    "đánh giá",
    "thể hiện",
]

STOP_WORDS = {
    "và", "các", "trong", "cho", "về",
    "được", "theo", "của", "những",
    "một", "các", "quá", "trình"
}


def extract_keywords(text: str) -> set:
    words = re.findall(r'\b[\w#.+-]+\b', text.lower())

    return {
        word
        for word in words
        if len(word) > 2 and word not in STOP_WORDS
    }

def build_context_text(input_data: dict) -> str:
    plos = input_data.get("plos", [])
    pis = input_data.get("pis", [])

    plo_text = "\n".join([
        f"{plo.get('code', '')}: {plo.get('description', '')}"
        for plo in plos
    ])

    pi_text = "\n".join([
        f"{pi.get('code', '')}: {pi.get('description', '')}"
        for pi in pis
    ])

    return f"""
Tên học phần: {input_data.get("course_name", "")}
Loại học phần: {input_data.get("course_type", "")}
Số tín chỉ: {input_data.get("credits", "")}
Mô tả học phần: {input_data.get("course_description", "")}

PLO mục tiêu:
{plo_text}

PI mục tiêu:
{pi_text}
""".strip()


def check_rule_based(cos: list) -> tuple[dict, list]:
    warnings = []
    scores = []

    if len(cos) == 3:
        rule_count_score = 1.0
    else:
        rule_count_score = 0.4
        warnings.append("Số lượng CO không đúng 3 mục.")

    scores.append(rule_count_score)

    expected_codes = ["CO1", "CO2", "CO3"]
    actual_codes = [co.get("code") for co in cos]

    if actual_codes == expected_codes:
        format_score = 1.0
    else:
        format_score = 0.5
        warnings.append("Mã CO chưa đúng định dạng CO1, CO2, CO3.")

    scores.append(format_score)

    verb_hits = 0

    for co in cos:
        desc = co.get("description", "").lower()

        if any(verb in desc for verb in ACADEMIC_VERBS):
            verb_hits += 1
        else:
            warnings.append(f"{co.get('code')} thiếu động từ học thuật rõ ràng.")

    verb_score = verb_hits / max(len(cos), 1)
    scores.append(verb_score)

    vague_patterns = [
        "hiểu được kiến thức",
        "nắm được kiến thức",
        "biết về môn học",
        "có kiến thức về môn học",
    ]

    vague_count = 0

    for co in cos:
        desc = co.get("description", "").lower()

        if any(pattern in desc for pattern in vague_patterns):
            vague_count += 1
            warnings.append(f"{co.get('code')} có nội dung hơi chung chung.")

    specificity_score = 1.0 if vague_count == 0 else 0.6
    scores.append(specificity_score)

    rule_score = sum(scores) / len(scores)

    return {
        "rule_score": round(rule_count_score, 2),
        "format_score": round(format_score, 2),
        "verb_score": round(verb_score, 2),
        "specificity_score": round(specificity_score, 2),
        "rule_based_score": round(rule_score, 2),
    }, warnings


def check_semantic_similarity(input_data: dict, cos: list) -> tuple[dict, list]:
    warnings = []
    context_text = build_context_text(input_data)

    co_scores = []

    for co in cos:
        code = co.get("code", "CO?")
        desc = co.get("description", "")

        if not desc.strip():
            score = 0.0
        else:
            score = calculate_similarity(context_text, desc)

        score = round(score, 2)

        co_scores.append({
            "code": code,
            "similarity_score": score
        })

        if score < 0.5:
            warnings.append(
                f"{code} có độ tương đồng thấp với ngữ cảnh đầu vào, cần kiểm tra hallucination."
            )
        elif score < 0.6:
            warnings.append(
                f"{code} có độ tương đồng trung bình với ngữ cảnh, nên giảng viên xem lại."
            )

    if co_scores:
        avg_similarity = sum(item["similarity_score"] for item in co_scores) / len(co_scores)
    else:
        avg_similarity = 0.0

    return {
        "semantic_score": round(avg_similarity, 2),
        "co_similarity_details": co_scores,
    }, warnings

def check_style_similarity(input_data: dict, cos: list) -> tuple[dict, list]:
    warnings = []

    style_examples = input_data.get("style_examples", [])

    if not style_examples:
        return {
            "style_score": 0.7
        }, warnings

    style_text = "\n".join(style_examples)

    scores = []

    for co in cos:
        score = calculate_similarity(
            style_text,
            co.get("description", "")
        )

        scores.append(score)

    avg_score = sum(scores) / max(len(scores), 1)

    if avg_score < 0.6:
        warnings.append(
            "Văn phong CO chưa giống các đề cương mẫu."
        )

    return {
        "style_score": round(avg_score, 2)
    }, warnings

def check_constraint_violation(input_data: dict, cos: list) -> tuple[dict, list]:
    warnings = []

    context_text = build_context_text(input_data)

    allowed_keywords = extract_keywords(context_text)

    hallucination_count = 0

    suspicious_words = []

    for co in cos:

        co_keywords = extract_keywords(
            co.get("description", "")
        )

        diff = co_keywords - allowed_keywords

        filtered_diff = {
            word
            for word in diff
            if len(word) > 4
        }

        suspicious_words.extend(filtered_diff)

    suspicious_words = list(set(suspicious_words))

    blacklist = [
        "blockchain",
        "iot",
        "machine",
        "deep",
        "crypto",
        "robotics",
    ]

    detected = []

    for word in suspicious_words:
        if word in blacklist:
            hallucination_count += 1
            detected.append(word)

    if detected:
        warnings.append(
            f"Phát hiện nội dung có thể hallucination: {', '.join(detected)}"
        )

    constraint_score = (
        1.0
        if hallucination_count == 0
        else max(0.4, 1 - hallucination_count * 0.2)
    )

    return {
        "constraint_score": round(constraint_score, 2),
        "suspicious_keywords": detected
    }, warnings

def check_coverage(cos: list) -> tuple[dict, list]:
    warnings = []

    knowledge = False
    skill = False
    attitude = False

    knowledge_keywords = [
        "trình bày",
        "phân tích",
        "giải thích",
    ]

    skill_keywords = [
        "vận dụng",
        "thiết kế",
        "xây dựng",
        "phát triển",
    ]

    attitude_keywords = [
        "tuân thủ",
        "đạo đức",
        "bảo mật",
        "thái độ",
        "trách nhiệm",
    ]

    for co in cos:
        desc = co.get("description", "").lower()

        if any(k in desc for k in knowledge_keywords):
            knowledge = True

        if any(k in desc for k in skill_keywords):
            skill = True

        if any(k in desc for k in attitude_keywords):
            attitude = True

    score = sum([
        knowledge,
        skill,
        attitude
    ]) / 3

    if not knowledge:
        warnings.append(
            "Thiếu CO nhóm kiến thức."
        )

    if not skill:
        warnings.append(
            "Thiếu CO nhóm kỹ năng."
        )

    if not attitude:
        warnings.append(
            "Thiếu CO nhóm thái độ/đạo đức."
        )

    return {
        "coverage_score": round(score, 2)
    }, warnings

def verify_co(input_data: dict, generated: dict) -> dict:
    warnings = []

    cos = generated.get("course_objectives", [])

    rule_result, rule_warnings = check_rule_based(cos)
    semantic_result, semantic_warnings = check_semantic_similarity(input_data, cos)
    style_result, style_warnings = check_style_similarity(
    input_data,
    cos
    )

    constraint_result, constraint_warnings = check_constraint_violation(
        input_data,
        cos
    )

    coverage_result, coverage_warnings = check_coverage(
        cos
    )
    
    warnings.extend(rule_warnings)
    warnings.extend(semantic_warnings)
    warnings.extend(style_warnings)
    warnings.extend(constraint_warnings)
    warnings.extend(coverage_warnings)

    rule_based_score = rule_result["rule_based_score"]
    semantic_score = semantic_result["semantic_score"]

    final_score = round(
    (
        0.25 * rule_based_score +
        0.25 * semantic_score +
        0.20 * style_result["style_score"] +
        0.15 * constraint_result["constraint_score"] +
        0.15 * coverage_result["coverage_score"]
    ),
    2
)

    return {
        "final_score": final_score,

        "rule_score": rule_result["rule_score"],
        "format_score": rule_result["format_score"],
        "verb_score": rule_result["verb_score"],
        "specificity_score": rule_result["specificity_score"],
        "rule_based_score": rule_based_score,
        "style_score": style_result["style_score"],
        "constraint_score": constraint_result["constraint_score"],
        "suspicious_keywords": constraint_result["suspicious_keywords"],
        "coverage_score": coverage_result["coverage_score"],

        "semantic_score": semantic_score,
        "co_similarity_details": semantic_result["co_similarity_details"],

        "warnings": warnings,
        "status": "good" if final_score >= 0.8 else "review_required",
    }