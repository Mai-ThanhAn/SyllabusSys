<h1>Sửa môn học</h1>

@if($errors->any())
    <ul style="color:red">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="{{ route('courses.update', $course->id) }}">
    @csrf
    @method('PUT')

    <p>
        <label>Mã môn:</label><br>
        <input type="text" name="course_code" value="{{ old('course_code', $course->course_code) }}">
    </p>

    <p>
        <label>Tên môn:</label><br>
        <input type="text" name="course_name" value="{{ old('course_name', $course->course_name) }}">
    </p>

    <p>
        <label>Số tín chỉ:</label><br>
        <input type="number" name="credits" value="{{ old('credits', $course->credits) }}">
    </p>

    <p>
        <label>Chương trình đào tạo:</label><br>
        <select name="program_id">
            @foreach($programs as $program)
                <option value="{{ $program->id }}" @selected(old('program_id', $course->program_id) == $program->id)>
                    {{ $program->name }}
                </option>
            @endforeach
        </select>
    </p>

    <button type="submit">Cập nhật</button>
</form>

<a href="{{ route('courses.index') }}">Quay lại</a>
