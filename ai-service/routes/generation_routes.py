from flask import Blueprint, request, jsonify
from services.co_service import generate_co
from services.clo_service import generate_clo
from services.teaching_plan_service import generate_teaching_plan

generation_bp = Blueprint("generation", __name__)


@generation_bp.route("/generate-co", methods=["POST"])
def generate_course_objectives():
    try:
        data = request.get_json()

        if not data:
            return jsonify({"error": "Request body is required"}), 400

        result = generate_co(data)

        return jsonify(result)

    except Exception as ex:
        return jsonify({
            "error": "Internal Server Error",
            "details": str(ex)
        }), 500


@generation_bp.route("/generate-clo", methods=["POST"])
def generate_course_learning_outcomes():
    try:
        data = request.get_json()

        if not data:
            return jsonify({"error": "Request body is required"}), 400

        result = generate_clo(data)

        return jsonify(result)

    except Exception as ex:
        return jsonify({
            "error": "Internal Server Error",
            "details": str(ex)
        }), 500
    
@generation_bp.route("/generate-teaching-plan", methods=["POST"])
def generate_teaching_plan_route():
    try:
        data = request.get_json()

        if not data:
            return jsonify({"error": "Request body is required"}), 400

        result = generate_teaching_plan(data)

        return jsonify(result)

    except Exception as ex:
        return jsonify({
            "error": "Internal Server Error",
            "details": str(ex)
        }), 500