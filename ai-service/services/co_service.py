from models.gemini import generate_text
from prompts.co_prompt import build_co_prompt
from utils.json_parser import parse_json_response
from services.verification_service import verify_co


def generate_co(data: dict) -> dict:
    prompt = build_co_prompt(data)

    raw_text = generate_text(prompt)

    generated = parse_json_response(raw_text)

    verification = verify_co(data, generated)

    return {
        "generation_type": "CO",
        "generated_data": generated.get("course_objectives", []),
        "verification": verification,
        "raw_model_output": raw_text,
    }