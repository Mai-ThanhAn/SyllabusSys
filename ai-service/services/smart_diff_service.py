from models.gemini import generate_text
from prompts.smart_diff_prompt import build_smart_diff_prompt
from utils.json_parser import parse_json_response


def generate_smart_diff(data: dict) -> dict:
    prompt = build_smart_diff_prompt(data)

    raw_text = generate_text(prompt)

    generated = parse_json_response(raw_text)

    return {
        "generation_type": "SMART_DIFF",
        "summary": generated.get("summary", ""),
        "important_changes": generated.get("important_changes", []),
        "risk_notes": generated.get("risk_notes", []),
        "raw_model_output": raw_text,
    }