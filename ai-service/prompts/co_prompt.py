import json


def build_co_prompt(data: dict) -> str:
    return f"""
Bạn là chuyên gia thiết kế đề cương học phần theo chuẩn OBE.

Nhiệm vụ:
Sinh Course Objectives (CO) cho học phần.

Dữ liệu đầu vào:
- Tên học phần: {data.get("course_name")}
- Loại học phần: {data.get("course_type")}
- Số tín chỉ: {data.get("credits")}
- Mô tả học phần: {data.get("course_description")}
- PLO mục tiêu: {json.dumps(data.get("plos", []), ensure_ascii=False)}
- PI mục tiêu: {json.dumps(data.get("pis", []), ensure_ascii=False)}
- Ví dụ phong cách CO từ đề cương đã duyệt:
{json.dumps(data.get("style_examples", []), ensure_ascii=False)}

Yêu cầu:
1. Sinh đúng 3 CO: CO1, CO2, CO3.
2. CO phải có văn phong học thuật, rõ ràng, không quá dài.
3. Không được tự tạo PLO/PI mới.
4. CO phải bám vào tên học phần, mô tả học phần, PLO và PI mục tiêu.
5. CO nên thể hiện các mức: kiến thức, kỹ năng vận dụng, thái độ/đạo đức nếu phù hợp.

Chỉ trả về JSON hợp lệ theo format:

{{
  "course_objectives": [
    {{
      "code": "CO1",
      "description": "..."
    }},
    {{
      "code": "CO2",
      "description": "..."
    }},
    {{
      "code": "CO3",
      "description": "..."
    }}
  ]
}}
"""