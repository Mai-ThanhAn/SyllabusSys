<h1>Thêm viện/khoa</h1>

<form method="POST" action="{{ route('university-admin.departments.store') }}">
    @csrf

    <p>
        <label>Mã viện/khoa:</label><br>
        <input type="text" name="department_code" value="{{ old('department_code') }}">
    </p>

    <p>
        <label>Tên viện/khoa:</label><br>
        <input type="text" name="department_name" value="{{ old('department_name') }}">
    </p>

    <button type="submit">Lưu</button>
</form>

<a href="{{ route('university-admin.departments.index') }}">Quay lại</a>
