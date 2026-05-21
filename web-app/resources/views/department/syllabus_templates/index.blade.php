<h1>Quản lý khung đề cương</h1>

@if(session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

<a href="{{ route('department.syllabus-templates.create') }}">
    Thêm khung đề cương
</a>

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên khung</th>
            <th>Mô tả</th>
            <th>Trạng thái</th>
            <th>Thao tác</th>
        </tr>
    </thead>

    <tbody>
        @forelse($templates as $template)
            <tr>
                <td>{{ $template->id }}</td>
                <td>{{ $template->template_name }}</td>
                <td>{{ $template->description }}</td>
                <td>{{ $template->is_active ? 'Đang dùng' : 'Tắt' }}</td>
                <td>
                    <a href="{{ route('department.syllabus-templates.edit', $template->id) }}">
                        Sửa
                    </a>

                    <a href="{{ route('department.syllabus-templates.sections.index', $template->id) }}">
                        Quản lý section
                    </a>

                    <form method="POST"
                          action="{{ route('department.syllabus-templates.destroy', $template->id) }}"
                          style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Xóa</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">Chưa có khung đề cương nào.</td>
            </tr>
        @endforelse
    </tbody>
</table>
