from transformers import AutoTokenizer, AutoModel
import torch
from sklearn.metrics.pairwise import cosine_similarity

device = torch.device("cpu")

tokenizer = AutoTokenizer.from_pretrained("vinai/phobert-base")

model = AutoModel.from_pretrained(
    "vinai/phobert-base",
    use_safetensors=True
).to(device)


def get_embedding(text: str):
    inputs = tokenizer(
        text,
        return_tensors="pt",
        truncation=True,
        padding=True,
        max_length=256
    ).to(device)

    with torch.no_grad():
        outputs = model(**inputs)

    return outputs.last_hidden_state[:, 0, :].cpu().numpy()


def calculate_similarity(text1: str, text2: str):
    emb1 = get_embedding(text1)
    emb2 = get_embedding(text2)

    return float(cosine_similarity(emb1, emb2)[0][0])