import os
import json
import logging
import numpy as np
import torch
from flask import Flask, request, jsonify
from dotenv import load_dotenv
import google.generativeai as genai
from transformers import AutoModel, AutoTokenizer, AutoModelForSequenceClassification
from sklearn.metrics.pairwise import cosine_similarity

# -------------------------------------------------------------------
# Khởi tạo ứng dụng và cấu hình logging
# -------------------------------------------------------------------
load_dotenv()
app = Flask(__name__)
logging.basicConfig(level=logging.INFO, format='%(asctime)s - %(levelname)s - %(message)s')

# -------------------------------------------------------------------
# Cấu hình thiết bị và model
# -------------------------------------------------------------------
device = torch.device('cpu')
logging.info("Đang tải PhoBERT và NLI model (base)...")

# 1. Gemini API
genai.configure(api_key=os.getenv("GEMINI_API_KEY"))
gemini_model = genai.GenerativeModel('gemini-2.5-flash')

# 2. PhoBERT (cho Cosine Similarity)
tokenizer_phobert = AutoTokenizer.from_pretrained("vinai/phobert-base")
phobert = AutoModel.from_pretrained("vinai/phobert-base", use_safetensors=True).to(device)

# 3. NLI Model - sử dụng bản base để nhẹ hơn
tokenizer_nli = AutoTokenizer.from_pretrained("MoritzLaurer/mDeBERTa-v3-base-mnli-xnli")
nli_model = AutoModelForSequenceClassification.from_pretrained("MoritzLaurer/mDeBERTa-v3-base-mnli-xnli").to(device)

logging.info("Tất cả model đã sẵn sàng!")

# -------------------------------------------------------------------
# Các hàm tiện ích
# -------------------------------------------------------------------
def get_phobert_embedding(text: str) -> np.ndarray:
    """Trả về vector nhúng PhoBERT của văn bản đầu vào."""
    if not text or not isinstance(text, str):
        return np.zeros((1, 768))
    inputs = tokenizer_phobert(
        text,
        return_tensors="pt",
        padding=True,
        truncation=True,
        max_length=256
    ).to(device)
    with torch.no_grad():
        outputs = phobert(**inputs)
    return outputs.last_hidden_state[:, 0, :].cpu().numpy()

def calculate_cosine(text1: str, text2: str) -> float:
    """Tính độ tương đồng cosine giữa hai văn bản."""
    if not text1 or not text2:
        return 0.0
    emb1 = get_phobert_embedding(text1)
    emb2 = get_phobert_embedding(text2)
    return float(cosine_similarity(emb1, emb2)[0][0])

def check_nli(premise: str, hypothesis: str) -> str:
    """
    Kiểm tra mối quan hệ logic giữa premise và hypothesis.
    Trả về: 'entailment', 'neutral', hoặc 'contradiction'.
    """
    inputs = tokenizer_nli(
        premise,
        hypothesis,
        return_tensors="pt",
        truncation=True,
        max_length=512
    ).to(device)
    with torch.no_grad():
        outputs = nli_model(**inputs)
    pred = torch.softmax(outputs.logits, dim=1).argmax().item()
    label_map = {0: "contradiction", 1: "neutral", 2: "entailment"}
    return label_map[pred]

def safe_parse_json(text: str):
    """Dọn dẹp và parse JSON từ phản hồi Gemini."""
    try:
        cleaned = text.replace('```json', '').replace('```', '').strip()
        return json.loads(cleaned)
    except json.JSONDecodeError as e:
        logging.error(f"Lỗi parse JSON: {e}")
        return None

def get_nli_decision_with_cosine(cos_val: float, premise: str, hypothesis: str) -> str:
    """
    Chiến lược lazy NLI:
    - Nếu cosine > 0.7: coi là entailment.
    - Nếu cosine < 0.4: coi là contradiction.
    - Nếu 0.4 <= cosine <= 0.7: gọi NLI model để quyết định.
    """
    if cos_val > 0.7:
        return "entailment"
    elif cos_val < 0.4:
        return "contradiction"
    else:
        return check_nli(premise, hypothesis)

# -------------------------------------------------------------------
# Hàm xử lý bước 1: Sinh và kiểm tra CLEO
# -------------------------------------------------------------------
def process_cleo_generation(course_name: str, clos: list):
    """Trả về dict verified_cleos và danh sách valid_cleo_texts."""
    prompt_cleo = f"""
Bạn là chuyên gia thiết kế chương trình đào tạo đại học.
Môn học: {course_name}
Danh sách Chuẩn Đầu Ra Môn Học (CLO): {json.dumps(clos, ensure_ascii=False)}

Nhiệm vụ: Từ mỗi CLO, hãy bóc tách thành 2 đến 3 các Kết Quả Trải Nghiệm Học Tập (CLEO) cụ thể hơn.
Mỗi CLEO phải là một câu miêu tả hành động mà sinh viên THỰC SỰ LÀM được sau khi học.

Yêu cầu: Chỉ trả về JSON thuần túy, không giải thích.
Cấu trúc JSON:
{{
    "cleo_mapping": [
        {{
            "clo_original": "Nội dung CLO gốc",
            "cleos_derived": ["CLEO 1.1", "CLEO 1.2"]
        }}
    ]
}}
"""
    response_cleo = gemini_model.generate_content(prompt_cleo)
    cleo_data = safe_parse_json(response_cleo.text)
    if not cleo_data or 'cleo_mapping' not in cleo_data:
        raise ValueError("Gemini không trả về cấu trúc CLEO hợp lệ")

    verified_cleos = []
    for item in cleo_data['cleo_mapping']:
        parent_clo = item['clo_original']
        for cleo_text in item['cleos_derived']:
            cos_score = calculate_cosine(parent_clo, cleo_text)
            nli_status = get_nli_decision_with_cosine(cos_score, parent_clo, cleo_text)

            is_valid = (cos_score > 0.5) and (nli_status != "contradiction")
            warning = ""
            if not is_valid:
                if cos_score <= 0.5:
                    warning = "⚠️ Độ tương đồng thấp, có thể không liên quan đến CLO."
                elif nli_status == "contradiction":
                    warning = "❌ CLEO mâu thuẫn với CLO gốc."

            verified_cleos.append({
                "cleo_text": cleo_text,
                "parent_clo": parent_clo,
                "cosine_score": round(cos_score, 3),
                "nli_status": nli_status,
                "is_valid": is_valid,
                "warning": warning
            })

    valid_cleo_texts = [c['cleo_text'] for c in verified_cleos if c['is_valid']]
    if not valid_cleo_texts:
        raise ValueError("Tất cả CLEO được tạo đều không đạt yêu cầu kiểm tra.")

    logging.info(f"Đã tạo {len(verified_cleos)} CLEO, trong đó {len(valid_cleo_texts)} hợp lệ.")
    return verified_cleos, valid_cleo_texts

# -------------------------------------------------------------------
# Hàm xử lý bước 2: Đề xuất chương dựa trên CLEO hợp lệ
# -------------------------------------------------------------------
def process_chapter_generation(course_name: str, valid_cleo_texts: list):
    # --- BƯỚC 1: SINH NỘI DUNG CHƯƠNG ---
    prompt_chapters = f"""
Bạn là chuyên gia xây dựng đề cương chi tiết.
Môn học: {course_name}
Danh sách các CLEO đã được xác thực: {json.dumps(valid_cleo_texts, ensure_ascii=False)}

Nhiệm vụ:
1. Đề xuất cấu trúc chương học (khoảng 3-5 chương).
2. Phân phối (map) các CLEO vào từng chương.
3. Đưa ra nội dung chi tiết (content) của chương.

Yêu cầu: Chỉ trả về JSON thuần túy.
Cấu trúc JSON:
{{
    "chapters_suggested": [
        {{ "title": "Tên Chương", "content": "Nội dung...", "mapped_cleos": ["CLEO A"] }}
    ]
}}
"""
    response_chapters = gemini_model.generate_content(prompt_chapters)
    chapters_data = safe_parse_json(response_chapters.text)
    
    if not chapters_data or 'chapters_suggested' not in chapters_data:
        raise ValueError("Gemini không trả về cấu trúc chương hợp lệ")

    raw_chapters = chapters_data['chapters_suggested']
    
    # --- BƯỚC 2: TÍNH TOÁN COSINE & NLI (CHẠY THUẦN CPU - KHÔNG TỐN QUOTA) ---
    intermediate_chapters = []
    for chapter in raw_chapters:
        title = chapter.get('title', '')
        content = chapter.get('content', '')
        mapped_cleos = chapter.get('mapped_cleos', [])
        full_text = f"{title}. {content}"

        cos_scores = [calculate_cosine(cleo, full_text) for cleo in mapped_cleos]
        nli_stats = [get_nli_decision_with_cosine(c, cleo, full_text) for c, cleo in zip(cos_scores, mapped_cleos)]
        
        avg_cosine = round(float(np.mean(cos_scores)), 3) if cos_scores else 0.0
        
        intermediate_chapters.append({
            "title": title,
            "content": content,
            "mapped_cleos": mapped_cleos,
            "avg_cosine": avg_cosine,
            "nli_statuses": nli_stats,
            "has_contradiction": "contradiction" in nli_stats
        })

    # --- BƯỚC 3: BATCHING LLM-AS-A-JUDGE (GOM 1 LẦN GỌI DUY NHẤT) ---
    # Chuẩn bị dữ liệu cho Judge
    judge_input = []
    for i, ch in enumerate(intermediate_chapters):
        judge_input.append({
            "id": i,
            "title": ch['title'],
            "content": ch['content'],
            "target_cleos": ch['mapped_cleos']
        })

    judge_prompt = f"""
Bạn là chuyên gia thẩm định học thuật. Hãy đánh giá độ phù hợp của các chương sau đối với mục tiêu CLEO.
Dữ liệu: {json.dumps(judge_input, ensure_ascii=False)}

Yêu cầu: Với mỗi chương, hãy đưa ra 1 câu nhận xét ngắn gọn. 
Nếu ổn, ghi "Nội dung phù hợp". Nếu không, chỉ ra lỗi sai.
Trả về JSON theo định dạng: {{"feedbacks": ["nhận xét 1", "nhận xét 2", ...]}}
"""
    # GỌI GEMINI LẦN 2 (TIẾT KIỆM: CHỈ 1 REQUEST CHO TẤT CẢ CHƯƠNG)
    judge_response = gemini_model.generate_content(judge_prompt)
    judge_data = safe_parse_json(judge_response.text)
    all_feedbacks = judge_data.get('feedbacks', ["Không có phản hồi"] * len(intermediate_chapters))

    # --- BƯỚC 4: TỔNG HỢP KẾT QUẢ ---
    final_chapters = []
    for i, ch in enumerate(intermediate_chapters):
        feedback = all_feedbacks[i] if i < len(all_feedbacks) else "Nội dung phù hợp"
        
        is_trustworthy = (
            ch['avg_cosine'] > 0.6 and 
            not ch['has_contradiction'] and 
            "không phù hợp" not in feedback.lower()
        )

        final_chapters.append({
            "title": ch['title'],
            "content": ch['content'],
            "mapped_cleos": ch['mapped_cleos'],
            "verification": {
                "avg_cosine_score": ch['avg_cosine'],
                "nli_statuses": ch['nli_statuses'],
                "has_contradiction": ch['has_contradiction'],
                "judge_feedback": feedback,
                "is_trustworthy": is_trustworthy
            }
        })

    logging.info(f"Đã tạo {len(final_chapters)} chương (Batching Judge OK).")
    return final_chapters

# -------------------------------------------------------------------
# Route chính - hỗ trợ stage
# -------------------------------------------------------------------
@app.route('/generate-syllabus', methods=['POST'])
def generate_syllabus():
    try:
        data = request.get_json()
        if not data:
            return jsonify({"error": "Invalid JSON payload"}), 400

        course_name = data.get('course_name', 'Môn học')
        clos = data.get('clos', [])
        stage = data.get('stage', 'full')  # 'cleo_only', 'chapters_only', hoặc 'full'
        valid_cleos_input = data.get('valid_cleos', [])  # Dùng khi stage='chapters_only'

        if not clos:
            return jsonify({"error": "Thiếu danh sách CLO đầu vào"}), 400

        # -----------------------------------------------------------------
        # Xử lý theo stage
        # -----------------------------------------------------------------
        verified_cleos = None
        valid_cleo_texts = None

        if stage in ['cleo_only', 'full']:
            verified_cleos, valid_cleo_texts = process_cleo_generation(course_name, clos)

        if stage == 'cleo_only':
            return jsonify({
                "status": "success",
                "section_1_cleo_analysis": {
                    "title": "1. Phân tích Chuẩn đầu ra (CLO → CLEO)",
                    "items": verified_cleos,
                    "summary": f"Tổng số CLEO hợp lệ: {len(valid_cleo_texts)} / {len(verified_cleos)}"
                }
            })

        if stage == 'chapters_only':
            if not valid_cleos_input:
                return jsonify({"error": "Thiếu danh sách CLEO hợp lệ để sinh chương"}), 400
            valid_cleo_texts = valid_cleos_input

        # Giai đoạn sinh chương (dùng chung cho 'chapters_only' và 'full')
        final_chapters = process_chapter_generation(course_name, valid_cleo_texts)

        response_data = {
            "status": "success",
            "section_2_chapters_proposal": {
                "title": "2. Đề xuất Chương trình & Đối soát",
                "items": final_chapters,
                "note": "Dữ liệu đã được kiểm tra bằng Cosine + NLI (có điều kiện) + LLM-as-a-Judge"
            }
        }

        if stage == 'full':
            response_data["section_1_cleo_analysis"] = {
                "title": "1. Phân tích Chuẩn đầu ra (CLO → CLEO)",
                "items": verified_cleos,
                "summary": f"Tổng số CLEO hợp lệ: {len(valid_cleo_texts)} / {len(verified_cleos)}"
            }

        return jsonify(response_data)

    except Exception as e:
        logging.exception("Lỗi không mong muốn trong quá trình xử lý")
        return jsonify({"error": "Lỗi hệ thống", "details": str(e)}), 500

# -------------------------------------------------------------------
# Khởi động server
# -------------------------------------------------------------------
if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)