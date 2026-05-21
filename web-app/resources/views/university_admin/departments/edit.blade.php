<h1>Sửa viện/khoa</h1>

<form method="POST" action="{{ route('university-admin.departments.update', $department->id) }}">
    @csrf
    @method('PUT')

    <p>
        <label>Mã viện/khoa:</label><br>
        <input type="text" name="department_code" value="{{ old('department_code', $department->department_code) }}">
    </p>

    <p>
        <label>Tên viện/khoa:</label><br>
        <input type="text" name="department_name" value="{{ old('department_name', $department->department_name) }}">
    </p>

    <button type="submit">Cập nhật</button>
</form>

<a href="{{ route('university-admin.departments.index') }}">Quay lại</a>
