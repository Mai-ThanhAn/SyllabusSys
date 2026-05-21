<h1>Danh sách môn học</h1>

@if (session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

<a href="{{ route('courses.create') }}">Thêm môn học</a>

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Mã môn</th>
            <th>Tên môn</th>
            <th>Số tín chỉ</th>
            <th>Chương trình</th>
            <th>Thao tác</th>
        </tr>
    </thead>

    <tbody>
        @forelse($courses as $course)
            <tr>
                <td>{{ $course->id }}</td>
                <td>{{ $course->course_code }}</td>
                <td>{{ $course->course_name }}</td>
                <td>{{ $course->credits }}</td>
                <td>{{ $course->program->name ?? 'N/A' }}</td>
                <td>
                    <a href="{{ route('courses.edit', $course->id) }}">Sửa</a>

                    <a href="{{ route('courses.assignLecturer', $course->id) }}">
                        Phân công
                    </a>

                    <form method="POST" action="{{ route('courses.destroy', $course->id) }}" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Xóa</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">Chưa có môn học nào.</td>
            </tr>
        @endforelse
    </tbody>
</table>
