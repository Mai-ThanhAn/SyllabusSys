<h1>Dashboard Giảng viên</h1>

<p>Xin chào, {{ Auth::user()->full_name }}</p>

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>Môn học</th>
            <th>Chương trình</th>
            <th>Năm học</th>
            <th>Vai trò</th>
            <th>Trạng thái</th>
            <th>Thao tác</th>
        </tr>
    </thead>

    <tbody>
        @forelse($assignments as $assignment)
            @php
                $syllabus = $assignment->syllabus;
                $course = $syllabus?->course;
            @endphp

            <tr>
                <td>{{ $course->course_code ?? '' }} - {{ $course->course_name ?? '' }}</td>
                <td>{{ $course->program->name ?? 'N/A' }}</td>
                <td>{{ $syllabus->academic_year ?? 'N/A' }}</td>
                <td>{{ $assignment->assignment_role }}</td>
                <td>{{ $syllabus->status->status_name ?? 'N/A' }}</td>
                <td>
                    <a href="#">
                        Soạn đề cương
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">Bạn chưa được giao đề cương nào.</td>
            </tr>
        @endforelse
    </tbody>
</table>
