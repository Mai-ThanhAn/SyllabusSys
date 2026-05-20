from models.embedding import calculate_similarity
from services.verification_service import extract_keywords


VALID_BLOOM_LEVELS = {
    "Remember",
    "Understand",
    "Apply",
    "Analyze",
    "Evaluate",
    "Create",
}


def build_clo_context_text(input_data: dict) -> str:
    cos = input_data.get("course_objectives", [])
    plos = input_data.get("plos", [])
    pis = input_data.get("pis", [])
    topics = input_data.get("topics", [])

    co_text = "\n".join([
        f"{co.get('code', '')}: {co.get('description', '')}"
        for co in cos
    ])

    plo_text = "\n".join([
        f"{plo.get('code', '')}: {plo.get('description', '')}"
        for plo in plos
    ])

    pi_text = "\n".join([
        f"{pi.get('code', '')}: {pi.get('description', '')}"
        for pi in pis
    ])

    topic_text = "\n".join([str(topic) for topic in topics])

    return f"""
Tên học phần: {input_data.get("course_name", "")}
Mô tả học phần: {input_data.get("course_description", "")}

CO:
{co_text}

PLO:
{plo_text}

PI:
{pi_text}

Topics:
{topic_text}
""".strip()


def check_clo_rules(clos: list) -> tuple[dict, list]:
    warnings = []
    scores = []

    if len(clos) == 4:
        count_score = 1.0
    else:
        count_score = 0.4
        warnings.append("Số lượng CLO không đúng 4 mục.")

    scores.append(count_score)

    expected_codes = ["CLO1", "CLO2", "CLO3", "CLO4"]
    actual_codes = [clo.get("code") for clo in clos]

    if actual_codes == expected_codes:
        format_score = 1.0
    else:
        format_score = 0.5
        warnings.append("Mã CLO chưa đúng định dạng CLO1, CLO2, CLO3, CLO4.")

    scores.append(format_score)

    bloom_hits = 0

    for clo in clos:
        if clo.get("bloom_level") in VALID_BLOOM_LEVELS:
            bloom_hits += 1
        else:
            warnings.append(f"{clo.get('code')} có Bloom level không hợp lệ.")

    bloom_score = bloom_hits / max(len(clos), 1)
    scores.append(bloom_score)

    mapping_hits = 0

    for clo in clos:
        mapped_co = clo.get("mapped_co", [])
        mapped_pi = clo.get("mapped_pi", [])

        if mapped_co and mapped_pi:
            mapping_hits += 1
        else:
            warnings.append(f"{clo.get('code')} thiếu mapped_co hoặc mapped_pi.")

    mapping_score = mapping_hits / max(len(clos), 1)
    scores.append(mapping_score)

    rule_based_score = sum(scores) / len(scores)

    return {
        "count_score": round(count_score, 2),
        "format_score": round(format_score, 2),
        "bloom_score": round(bloom_score, 2),
        "mapping_score": round(mapping_score, 2),
        "rule_based_score": round(rule_based_score, 2),
    }, warnings


def check_clo_semantic_similarity(input_data: dict, clos: list) -> tuple[dict, list]:
    warnings = []
    context_text = build_clo_context_text(input_data)

    details = []

    for clo in clos:
        code = clo.get("code", "CLO?")
        desc = clo.get("description", "")

        score = calculate_similarity(context_text, desc) if desc else 0.0
        score = round(score, 2)

        details.append({
            "code": code,
            "similarity_score": score
        })

        if score < 0.5:
            warnings.append(f"{code} có độ tương đồng thấp với CO/PLO/PI đầu vào.")
        elif score < 0.6:
            warnings.append(f"{code} có độ tương đồng trung bình với CO/PLO/PI đầu vào.")

    avg_score = (
        sum(item["similarity_score"] for item in details) / len(details)
        if details else 0.0
    )

    return {
        "semantic_score": round(avg_score, 2),
        "clo_similarity_details": details,
    }, warnings


def check_clo_mapping_validity(input_data: dict, clos: list) -> tuple[dict, list]:
    warnings = []

    allowed_co_codes = {
        co.get("code")
        for co in input_data.get("course_objectives", [])
    }

    allowed_pi_codes = {
        pi.get("code")
        for pi in input_data.get("pis", [])
    }

    invalid_count = 0

    for clo in clos:
        code = clo.get("code", "CLO?")

        mapped_cos = set(clo.get("mapped_co", []))
        mapped_pis = set(clo.get("mapped_pi", []))

        invalid_cos = mapped_cos - allowed_co_codes
        invalid_pis = mapped_pis - allowed_pi_codes

        if invalid_cos:
            invalid_count += 1
            warnings.append(f"{code} mapping CO không hợp lệ: {', '.join(invalid_cos)}")

        if invalid_pis:
            invalid_count += 1
            warnings.append(f"{code} mapping PI không hợp lệ: {', '.join(invalid_pis)}")

    validity_score = 1.0 if invalid_count == 0 else max(0.4, 1 - invalid_count * 0.2)

    return {
        "mapping_validity_score": round(validity_score, 2)
    }, warnings


def check_clo_constraint_violation(input_data: dict, clos: list) -> tuple[dict, list]:
    warnings = []

    context_text = build_clo_context_text(input_data)
    allowed_keywords = extract_keywords(context_text)

    blacklist = [
        "blockchain",
        "iot",
        "crypto",
        "robotics",
        "deep",
        "machine",
    ]

    detected = []

    for clo in clos:
        keywords = extract_keywords(clo.get("description", ""))
        diff = keywords - allowed_keywords

        for word in diff:
            if word in blacklist:
                detected.append(word)

    detected = list(set(detected))

    if detected:
        warnings.append(
            f"Phát hiện nội dung có thể hallucination: {', '.join(detected)}"
        )

    score = 1.0 if not detected else 0.5

    return {
        "constraint_score": score,
        "suspicious_keywords": detected
    }, warnings


def verify_clo(input_data: dict, generated: dict) -> dict:
    warnings = []

    clos = generated.get("course_learning_outcomes", [])

    rule_result, rule_warnings = check_clo_rules(clos)
    semantic_result, semantic_warnings = check_clo_semantic_similarity(input_data, clos)
    mapping_result, mapping_warnings = check_clo_mapping_validity(input_data, clos)
    constraint_result, constraint_warnings = check_clo_constraint_violation(input_data, clos)

    warnings.extend(rule_warnings)
    warnings.extend(semantic_warnings)
    warnings.extend(mapping_warnings)
    warnings.extend(constraint_warnings)

    final_score = round(
        0.30 * rule_result["rule_based_score"] +
        0.30 * semantic_result["semantic_score"] +
        0.25 * mapping_result["mapping_validity_score"] +
        0.15 * constraint_result["constraint_score"],
        2
    )

    return {
        "final_score": final_score,
        "rule_based_score": rule_result["rule_based_score"],
        "count_score": rule_result["count_score"],
        "format_score": rule_result["format_score"],
        "bloom_score": rule_result["bloom_score"],
        "mapping_score": rule_result["mapping_score"],
        "semantic_score": semantic_result["semantic_score"],
        "clo_similarity_details": semantic_result["clo_similarity_details"],
        "mapping_validity_score": mapping_result["mapping_validity_score"],
        "constraint_score": constraint_result["constraint_score"],
        "suspicious_keywords": constraint_result["suspicious_keywords"],
        "warnings": warnings,
        "status": "good" if final_score >= 0.8 else "review_required",
    }