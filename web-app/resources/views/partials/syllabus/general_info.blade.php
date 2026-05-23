<div class="syllabus-general-info">
    <p><strong>- Tên học phần:</strong> {{ $data['course_name'] ?? '' }}</p>
    <p><strong>- Tên tiếng Anh:</strong> {{ $data['english_name'] ?? '' }}</p>
    <p><strong>- Mã học phần:</strong> {{ $data['course_code'] ?? '' }}</p>
    <p><strong>- E-learning:</strong> {{ $data['e_learning'] ?? '' }}</p>

    <p><strong>- Số tín chỉ:</strong> {{ $data['credits'] ?? '' }}</p>
    <p><strong>+ Số tiết lý thuyết:</strong> {{ $data['theory_hours'] ?? '' }}</p>
    <p><strong>+ Số tiết thực hành:</strong> {{ $data['practice_hours'] ?? '' }}</p>
    <p><strong>- Tự học:</strong> {{ $data['self_study_hours'] ?? '' }} tiết</p>

    <p><strong>- Học phần tiên quyết:</strong> {{ $data['prerequisite'] ?? 'Không' }}</p>
    <p><strong>- Học phần học trước:</strong> {{ $data['previous_course'] ?? 'Không' }}</p>
    <p><strong>- Học phần song hành:</strong> {{ $data['parallel_course'] ?? 'Không' }}</p>
</div>
