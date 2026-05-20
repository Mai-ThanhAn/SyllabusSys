from flask import Flask
from routes.generation_routes import generation_bp

app = Flask(__name__)
app.register_blueprint(generation_bp, url_prefix="/api/ai")

if __name__ == "__main__":
    app.run(port=5000, debug=True)