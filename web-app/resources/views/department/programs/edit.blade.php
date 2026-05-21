<h1>Sửa chương trình đào tạo</h1>

@if($errors->any())
    <ul style="color:red">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="{{ route('department.programs.update', $program->id) }}">
    @csrf
    @method('PUT')

    <p>
        <label>Mã CTĐT:</label><br>
        <input type="text" name="program_code" value="{{ old('program_code', $program->program_code) }}">
    </p>

    <p>
        <label>Tên CTĐT:</label><br>
        <input type="text" name="program_name" value="{{ old('program_name', $program->program_name) }}">
    </p>

    <button type="submit">
        Cập nhật
    </button>
</form>

<p>
    <a href="{{ route('department.programs.index') }}">
        Quay lại
    </a>
</p>
