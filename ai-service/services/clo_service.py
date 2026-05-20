from models.gemini import generate_text
from prompts.clo_prompt import build_clo_prompt
from utils.json_parser import parse_json_response
from services.clo_verification_service import verify_clo


def generate_clo(data: dict) -> dict:
    prompt = build_clo_prompt(data)

    raw_text = generate_text(prompt)

    generated = parse_json_response(raw_text)

    verification = verify_clo(data, generated)

    return {
        "generation_type": "CLO",
        "generated_data": generated.get("course_learning_outcomes", []),
        "verification": verification,
        "raw_model_output": raw_text,
    }