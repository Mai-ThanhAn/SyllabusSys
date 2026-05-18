<h1>Dashboard Giảng viên</h1>

<p>Xin chào, {{ Auth::user()->full_name }}</p>

@if(session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

@if(session('error'))
    <p style="color: red">{{ session('error') }}</p>
@endif

<h2>Danh sách môn được phân công</h2>

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Mã môn</th>
            <th>Tên môn</th>
            <th>Số tín chỉ</th>
            <th>Chương trình</th>
            <th>Đề cương</th>
            <th>Thao tác</th>
        </tr>
    </thead>

    <tbody>
        @forelse($assignedCourses as $assignment)
            @php
                $course = $assignment->course;
                $latestSyllabus = $course?->syllabi?->sortByDesc('created_at')->first();
            @endphp

            <tr>
                <td>{{ $course->id ?? 'N/A' }}</td>
                <td>{{ $course->course_code ?? 'N/A' }}</td>
                <td>{{ $course->course_name ?? 'N/A' }}</td>
                <td>{{ $course->credits ?? 'N/A' }}</td>
                <td>{{ $course->program->name ?? 'N/A' }}</td>

                <td>
                    @if($latestSyllabus)
                        Có đề cương
                    @else
                        Chưa có
                    @endif
                </td>

                <td>
                    @if($latestSyllabus)
                        <a href="#">
                            Xem / chỉnh sửa đề cương
                        </a>
                    @else
                        <a href="#">
                            Tạo đề cương
                        </a>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">
                    Bạn chưa được phân công môn học nào.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
