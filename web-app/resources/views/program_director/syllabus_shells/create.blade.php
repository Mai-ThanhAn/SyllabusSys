<h1>Tạo khung đề cương và phân công giảng viên</h1>

@if(session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

@if($errors->any())
    <ul style="color:red">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="{{ route('program-director.syllabus-shells.store') }}">
    @csrf

    <p>
        <label>Môn học:</label><br>
        <select name="course_id">
            <option value="">-- Chọn môn học --</option>
            @foreach($courses as $course)
                <option value="{{ $course->id }}">
                    {{ $course->course_code }} - {{ $course->course_name }}
                </option>
            @endforeach
        </select>
    </p>

    <p>
        <label>Khung đề cương:</label><br>
        <select name="template_id">
            <option value="">-- Chọn khung --</option>
            @foreach($templates as $template)
                <option value="{{ $template->id }}">
                    {{ $template->template_name }}
                </option>
            @endforeach
        </select>
    </p>

    <p>
        <label>Giảng viên phụ trách:</label><br>
        <select name="assigned_to">
            <option value="">-- Chọn giảng viên --</option>
            @foreach($lecturers as $lecturer)
                <option value="{{ $lecturer->id }}">
                    {{ $lecturer->full_name }} - {{ $lecturer->email }}
                </option>
            @endforeach
        </select>
    </p>

    <p>
        <label>Năm học:</label><br>
        <input type="text" name="academic_year" value="{{ old('academic_year') }}" placeholder="Ví dụ: 2025-2026">
    </p>

    <hr>

    <h3>Chọn PLO mục tiêu</h3>

    @foreach($plos as $plo)
        <p>
            <label>
                <input type="checkbox" name="plo_ids[]" value="{{ $plo->id }}">
                {{ $plo->code }} - {{ $plo->description }}
            </label>
        </p>
    @endforeach

    <hr>

    <h3>Chọn PI mục tiêu</h3>

    @foreach($pis as $pi)
        <p>
            <label>
                <input type="checkbox" name="pi_ids[]" value="{{ $pi->id }}">
                {{ $pi->code }} - {{ $pi->description }}
            </label>
        </p>
    @endforeach

    <hr>

    <p>
        <label>Ghi chú định hướng:</label><br>
        <textarea name="planning_note" rows="4">{{ old('planning_note') }}</textarea>
    </p>

    <p>
        <label>Hạn hoàn thành:</label><br>
        <input type="date" name="due_date" value="{{ old('due_date') }}">
    </p>

    <button type="submit">Tạo và phân công</button>
</form>
