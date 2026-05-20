from models.embedding import calculate_similarity
from services.clo_verification_service import build_clo_context_text
from services.verification_service import extract_keywords


def build_teaching_context(input_data: dict) -> str:
    return build_clo_context_text(input_data)


def check_plan_rules(plan: list) -> tuple[dict, list]:
    warnings = []
    scores = []

    if 6 <= len(plan) <= 14:
        count_score = 1.0
    else:
        count_score = 0.6
        warnings.append("Số lượng chương/lab có thể chưa phù hợp.")

    scores.append(count_score)

    mapping_hits = 0

    for item in plan:
        if item.get("mapped_clo"):
            mapping_hits += 1
        else:
            warnings.append(f"Mục {item.get('order')} chưa mapping CLO.")

    mapping_score = mapping_hits / max(len(plan), 1)
    scores.append(mapping_score)

    structure_hits = 0

    for item in plan:
        if item.get("title") and item.get("content"):
            structure_hits += 1
        else:
            warnings.append(f"Mục {item.get('order')} thiếu title hoặc content.")

    structure_score = structure_hits / max(len(plan), 1)
    scores.append(structure_score)

    rule_score = sum(scores) / len(scores)

    return {
        "count_score": round(count_score, 2),
        "mapping_score": round(mapping_score, 2),
        "structure_score": round(structure_score, 2),
        "rule_based_score": round(rule_score, 2),
    }, warnings


def check_clo_coverage(input_data: dict, plan: list) -> tuple[dict, list]:
    warnings = []

    allowed_clos = {
        clo.get("code")
        for clo in input_data.get("course_learning_outcomes", [])
    }

    used_clos = set()

    invalid_clos = set()

    for item in plan:
        mapped = set(item.get("mapped_clo", []))

        used_clos.update(mapped)

        invalid_clos.update(mapped - allowed_clos)

    missing_clos = allowed_clos - used_clos

    if missing_clos:
        warnings.append(
            f"Các CLO chưa được chương/lab nào hỗ trợ: {', '.join(sorted(missing_clos))}"
        )

    if invalid_clos:
        warnings.append(
            f"Phát hiện CLO không tồn tại trong mapping: {', '.join(sorted(invalid_clos))}"
        )

    coverage_score = 1.0
    if allowed_clos:
        coverage_score = len(used_clos & allowed_clos) / len(allowed_clos)

    validity_score = 1.0 if not invalid_clos else 0.5

    return {
        "clo_coverage_score": round(coverage_score, 2),
        "clo_mapping_validity_score": round(validity_score, 2),
        "missing_clos": sorted(list(missing_clos)),
        "invalid_clos": sorted(list(invalid_clos)),
    }, warnings


def check_plan_semantic_similarity(input_data: dict, plan: list) -> tuple[dict, list]:
    warnings = []

    context_text = build_teaching_context(input_data)

    details = []

    for item in plan:
        text = f"""
        {item.get("title", "")}
        {" ".join(item.get("content", []))}
        {" ".join(item.get("teaching_activities", []))}
        {" ".join(item.get("learning_activities", []))}
        """

        score = calculate_similarity(context_text, text)
        score = round(score, 2)

        details.append({
            "order": item.get("order"),
            "title": item.get("title"),
            "similarity_score": score,
        })

        if score < 0.45:
            warnings.append(
                f"Mục {item.get('order')} có độ tương đồng thấp với CO/CLO/topics."
            )

    avg_score = (
        sum(item["similarity_score"] for item in details) / len(details)
        if details else 0.0
    )

    return {
        "semantic_score": round(avg_score, 2),
        "plan_similarity_details": details,
    }, warnings


def check_plan_constraint(input_data: dict, plan: list) -> tuple[dict, list]:
    warnings = []

    context = build_teaching_context(input_data)
    allowed_keywords = extract_keywords(context)

    blacklist = [
        "blockchain",
        "iot",
        "crypto",
        "robotics",
        "deep",
        "machine",
    ]

    detected = set()

    for item in plan:
        text = f"""
        {item.get("title", "")}
        {" ".join(item.get("content", []))}
        """

        keywords = extract_keywords(text)

        for word in keywords - allowed_keywords:
            if word in blacklist:
                detected.add(word)

    if detected:
        warnings.append(
            f"Phát hiện nội dung có thể hallucination: {', '.join(sorted(detected))}"
        )

    return {
        "constraint_score": 1.0 if not detected else 0.5,
        "suspicious_keywords": sorted(list(detected)),
    }, warnings


def verify_teaching_plan(input_data: dict, generated: dict) -> dict:
    warnings = []

    plan = generated.get("teaching_plan", [])

    rule_result, rule_warnings = check_plan_rules(plan)
    coverage_result, coverage_warnings = check_clo_coverage(input_data, plan)
    semantic_result, semantic_warnings = check_plan_semantic_similarity(input_data, plan)
    constraint_result, constraint_warnings = check_plan_constraint(input_data, plan)

    warnings.extend(rule_warnings)
    warnings.extend(coverage_warnings)
    warnings.extend(semantic_warnings)
    warnings.extend(constraint_warnings)

    final_score = round(
        0.25 * rule_result["rule_based_score"] +
        0.30 * coverage_result["clo_coverage_score"] +
        0.25 * semantic_result["semantic_score"] +
        0.10 * coverage_result["clo_mapping_validity_score"] +
        0.10 * constraint_result["constraint_score"],
        2
    )

    return {
        "final_score": final_score,
        "rule_based_score": rule_result["rule_based_score"],
        "count_score": rule_result["count_score"],
        "mapping_score": rule_result["mapping_score"],
        "structure_score": rule_result["structure_score"],
        "clo_coverage_score": coverage_result["clo_coverage_score"],
        "clo_mapping_validity_score": coverage_result["clo_mapping_validity_score"],
        "missing_clos": coverage_result["missing_clos"],
        "invalid_clos": coverage_result["invalid_clos"],
        "semantic_score": semantic_result["semantic_score"],
        "plan_similarity_details": semantic_result["plan_similarity_details"],
        "constraint_score": constraint_result["constraint_score"],
        "suspicious_keywords": constraint_result["suspicious_keywords"],
        "warnings": warnings,
        "status": "good" if final_score >= 0.8 else "review_required",
    }