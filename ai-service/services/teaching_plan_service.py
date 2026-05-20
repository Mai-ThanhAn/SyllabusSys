from models.gemini import generate_text
from prompts.teaching_plan_prompt import build_teaching_plan_prompt
from utils.json_parser import parse_json_response
from services.teaching_plan_verification_service import verify_teaching_plan


def generate_teaching_plan(data: dict) -> dict:
    prompt = build_teaching_plan_prompt(data)

    raw_text = generate_text(prompt)

    generated = parse_json_response(raw_text)

    verification = verify_teaching_plan(data, generated)

    return {
        "generation_type": "TEACHING_PLAN",
        "generated_data": generated.get("teaching_plan", []),
        "verification": verification,
        "raw_model_output": raw_text,
    }