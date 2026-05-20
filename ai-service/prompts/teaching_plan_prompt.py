import json


def build_teaching_plan_prompt(data: dict) -> str:
    return f"""
Bạn là chuyên gia thiết kế đề cương học phần theo chuẩn OBE.

Nhiệm vụ:
Sinh kế hoạch và nội dung giảng dạy chi tiết dựa trên CLO đã được chấp nhận.

Dữ liệu đầu vào:
- Tên học phần: {data.get("course_name")}
- Loại học phần: {data.get("course_type")}
- Số tín chỉ: {data.get("credits")}
- Số tiết lý thuyết: {data.get("theory_hours")}
- Số tiết thực hành: {data.get("practice_hours")}
- Mô tả học phần: {data.get("course_description")}

CO đã chấp nhận:
{json.dumps(data.get("course_objectives", []), ensure_ascii=False)}

CLO đã chấp nhận:
{json.dumps(data.get("course_learning_outcomes", []), ensure_ascii=False)}

Chủ đề chính:
{json.dumps(data.get("topics", []), ensure_ascii=False)}

Ví dụ phong cách kế hoạch giảng dạy:
{json.dumps(data.get("style_examples", []), ensure_ascii=False)}

Yêu cầu:
1. Nếu là môn lý thuyết, chia theo Chương.
2. Nếu là môn thực hành, chia theo Bài thực hành/Lab.
3. Mỗi chương/lab phải có mapped_clo.
4. Không được tạo CLO mới ngoài danh sách đã cung cấp.
5. Nội dung phải bám vào topics, CO và CLO.
6. Trả về từ 8 đến 12 mục nếu không có yêu cầu khác.

Chỉ trả về JSON hợp lệ:

{{
  "teaching_plan": [
    {{
      "order": 1,
      "title": "Chương 1: ...",
      "content": ["...", "..."],
      "teaching_activities": ["..."],
      "learning_activities": ["..."],
      "assessment_activities": ["..."],
      "mapped_clo": ["CLO1"]
    }}
  ]
}}
"""