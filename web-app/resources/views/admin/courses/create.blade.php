<h1>Thêm môn học</h1>

@if($errors->any())
    <ul style="color:red">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="{{ route('courses.store') }}">
    @csrf

    <p>
        <label>Mã môn:</label><br>
        <input type="text" name="course_code" value="{{ old('course_code') }}">
    </p>

    <p>
        <label>Tên môn:</label><br>
        <input type="text" name="course_name" value="{{ old('course_name') }}">
    </p>

    <p>
        <label>Số tín chỉ:</label><br>
        <input type="number" name="credits" value="{{ old('credits') }}">
    </p>

    <p>
        <label>Chương trình đào tạo:</label><br>
        <select name="program_id">
            <option value="">-- Chọn chương trình --</option>
            @foreach($programs as $program)
                <option value="{{ $program->id }}">
                    {{ $program->name }}
                </option>
            @endforeach
        </select>
    </p>

    <button type="submit">Lưu</button>
</form>

<a href="{{ route('courses.index') }}">Quay lại</a>
