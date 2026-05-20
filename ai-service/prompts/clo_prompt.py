import json


def build_clo_prompt(data: dict) -> str:
    return f"""
Bạn là chuyên gia thiết kế đề cương học phần theo chuẩn OBE.

Nhiệm vụ:
Sinh Course Learning Outcomes (CLO) dựa trên CO đã được giảng viên chấp nhận.

Dữ liệu đầu vào:
- Tên học phần: {data.get("course_name")}
- Loại học phần: {data.get("course_type")}
- Số tín chỉ: {data.get("credits")}
- Mô tả học phần: {data.get("course_description")}

CO đã chấp nhận:
{json.dumps(data.get("course_objectives", []), ensure_ascii=False)}

PLO mục tiêu:
{json.dumps(data.get("plos", []), ensure_ascii=False)}

PI mục tiêu:
{json.dumps(data.get("pis", []), ensure_ascii=False)}

Chủ đề / nội dung chính:
{json.dumps(data.get("topics", []), ensure_ascii=False)}

Ví dụ phong cách CLO từ đề cương đã duyệt:
{json.dumps(data.get("style_examples", []), ensure_ascii=False)}

Yêu cầu:
1. Sinh đúng 4 CLO: CLO1, CLO2, CLO3, CLO4.
2. CLO phải đo lường được, rõ hành động học tập.
3. CLO phải dựa trên CO đã chấp nhận.
4. CLO phải bám PLO/PI mục tiêu.
5. Không được tự tạo PLO/PI mới.
6. Mỗi CLO phải có mapped_co và mapped_pi.
7. Bloom level chỉ được dùng một trong các giá trị:
   Remember, Understand, Apply, Analyze, Evaluate, Create.

Chỉ trả về JSON hợp lệ theo format:

{{
  "course_learning_outcomes": [
    {{
      "code": "CLO1",
      "description": "...",
      "mapped_co": ["CO1"],
      "mapped_pi": ["PI3.1"],
      "bloom_level": "Understand"
    }}
  ]
}}
"""