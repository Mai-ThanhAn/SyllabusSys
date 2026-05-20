import json


def build_smart_diff_prompt(data: dict) -> str:
    return f"""
Bạn là chuyên gia kiểm định đề cương học phần.

Nhiệm vụ:
Tóm tắt các thay đổi giữa hai phiên bản đề cương dựa trên diff đã được hệ thống trích xuất.

Dữ liệu diff:
{json.dumps(data, ensure_ascii=False)}

Yêu cầu:
1. Không bịa thêm thay đổi ngoài diff.
2. Tóm tắt ngắn gọn, dễ hiểu cho người duyệt.
3. Nêu rõ thay đổi quan trọng ở CO, CLO, kế hoạch giảng dạy, nội dung section nếu có.
4. Nếu thay đổi có thể ảnh hưởng đến mapping CLO/PLO/PI thì ghi vào risk_notes.

Chỉ trả về JSON:

{{
  "summary": "...",
  "important_changes": [
    "..."
  ],
  "risk_notes": [
    "..."
  ]
}}
"""