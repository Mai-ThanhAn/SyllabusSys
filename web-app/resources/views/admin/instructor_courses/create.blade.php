<h1>Phân công giảng viên</h1>

<p>Môn học: {{ $course->course_code }} - {{ $course->course_name }}</p>

@if($errors->any())
    <ul style="color:red">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="{{ route('courses.storeLecturer', $course->id) }}">
    @csrf

    <p>
        <label>Chọn giảng viên:</label><br>
        <select name="user_id">
            <option value="">-- Chọn giảng viên --</option>
            @foreach($lecturers as $lecturer)
                <option value="{{ $lecturer->id }}">
                    {{ $lecturer->full_name }} - {{ $lecturer->email }}
                </option>
            @endforeach
        </select>
    </p>

    <button type="submit">Phân công</button>
</form>

<hr>

<h3>Giảng viên đã được phân công</h3>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>Họ tên</th>
        <th>Email</th>
        <th>Ngày phân công</th>
        <th>Thao tác</th>
    </tr>

    @forelse($course->instructor_courses as $item)
        <tr>
            <td>{{ $item->user->full_name ?? 'N/A' }}</td>
            <td>{{ $item->user->email ?? 'N/A' }}</td>
            <td>{{ $item->created_at }}</td>
            <td>
                <form method="POST" action="{{ route('instructorCourses.destroy', $item->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Hủy</button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="4">Chưa có giảng viên nào.</td>
        </tr>
    @endforelse
</table>

<p>
    <a href="{{ route('courses.index') }}">Quay lại danh sách môn học</a>
</p>
