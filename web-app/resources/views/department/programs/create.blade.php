<h1>Thêm chương trình đào tạo</h1>

@if($errors->any())
    <ul style="color:red">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="{{ route('department.programs.store') }}">
    @csrf

    <p>
        <label>Mã CTĐT:</label><br>
        <input type="text" name="code" value="{{ old('code') }}">
    </p>

    <p>
        <label>Tên CTĐT:</label><br>
        <input type="text" name="name" value="{{ old('name') }}">
    </p>

    <button type="submit">
        Lưu
    </button>
</form>

<p>
    <a href="{{ route('department.programs.index') }}">
        Quay lại
    </a>
</p>
