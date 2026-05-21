<h1>Quản lý viện / khoa</h1>

@if(session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

<p>
    <a href="{{ route('university-admin.departments.create') }}">
        Thêm viện/khoa
    </a>
</p>

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Mã</th>
            <th>Tên viện/khoa</th>
            <th>Viện trưởng/khoa trưởng</th>
            <th>Thao tác</th>
        </tr>
    </thead>

    <tbody>
        @foreach($departments as $department)
            <tr>
                <td>{{ $department->id }}</td>
                <td>{{ $department->department_code }}</td>
                <td>{{ $department->department_name }}</td>
                <td>{{ $department->head->full_name ?? 'Chưa bổ nhiệm' }}</td>
                <td>
                    <a href="{{ route('university-admin.departments.edit', $department->id) }}">
                        Sửa
                    </a>

                    <a href="{{ route('university-admin.departments.show', $department->id) }}">
                        Bổ nhiệm trưởng khoa
                    </a>

                    <form method="POST" action="{{ route('university-admin.departments.destroy', $department->id) }}" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Xóa</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<p>
    <a href="{{ route('university-admin.dashboard') }}">Quay lại dashboard</a>
</p>
