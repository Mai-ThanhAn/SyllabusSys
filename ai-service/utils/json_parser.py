import json
import re


def parse_json_response(text: str):
    clean = text.replace("```json", "").replace("```", "").strip()

    match = re.search(r"\{.*\}", clean, re.DOTALL)
    if match:
        clean = match.group(0)

    return json.loads(clean)