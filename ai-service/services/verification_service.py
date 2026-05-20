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
]


def verify_co(input_data: dict, generated: dict) -> dict:
    warnings = []
    scores = []

    cos = generated.get("course_objectives", [])

    # Rule 1: phải có đúng 3 CO
    if len(cos) == 3:
        rule_count_score = 1.0
    else:
        rule_count_score = 0.4
        warnings.append("Số lượng CO không đúng 3 mục.")

    scores.append(rule_count_score)

    # Rule 2: format CO1, CO2, CO3
    expected_codes = ["CO1", "CO2", "CO3"]
    actual_codes = [co.get("code") for co in cos]

    if actual_codes == expected_codes:
        format_score = 1.0
    else:
        format_score = 0.5
        warnings.append("Mã CO chưa đúng định dạng CO1, CO2, CO3.")

    scores.append(format_score)

    # Rule 3: kiểm tra động từ học thuật
    verb_hits = 0

    for co in cos:
        desc = co.get("description", "").lower()

        if any(verb in desc for verb in ACADEMIC_VERBS):
            verb_hits += 1
        else:
            warnings.append(f"{co.get('code')} thiếu động từ học thuật rõ ràng.")

    verb_score = verb_hits / max(len(cos), 1)
    scores.append(verb_score)

    # Rule 4: phát hiện câu quá chung
    vague_patterns = [
        "hiểu được kiến thức",
        "nắm được kiến thức",
        "biết về môn học",
    ]

    vague_count = 0

    for co in cos:
        desc = co.get("description", "").lower()

        if any(pattern in desc for pattern in vague_patterns):
            vague_count += 1
            warnings.append(f"{co.get('code')} có nội dung hơi chung chung.")

    specificity_score = 1.0 if vague_count == 0 else 0.6
    scores.append(specificity_score)

    final_score = round(sum(scores) / len(scores), 2)

    return {
        "final_score": final_score,
        "rule_score": round(rule_count_score, 2),
        "format_score": round(format_score, 2),
        "verb_score": round(verb_score, 2),
        "specificity_score": round(specificity_score, 2),
        "warnings": warnings,
        "status": "good" if final_score >= 0.8 else "review_required",
    }