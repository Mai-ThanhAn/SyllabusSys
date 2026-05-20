<h1>Dashboard Giảng viên</h1>

<p>Xin chào, {{ Auth::user()->full_name }}</p>

@if(session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

@if(session('error'))
    <p style="color: red">{{ session('error') }}</p>
@endif

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>Môn học</th>
            <th>Chương trình</th>
            <th>Năm học</th>
            <th>Vai trò</th>
            <th>Trạng thái</th>
            <th>Ghi chú duyệt</th>
            <th>Thao tác</th>
        </tr>
    </thead>

    <tbody>
        @forelse($assignments as $assignment)
            @php
                $syllabus = $assignment->syllabus;
                $course = $syllabus?->course;
                $statusName = $syllabus?->status?->status_name ?? 'N/A';

                $latestApproval = $syllabus?->approvals
                    ? $syllabus->approvals->sortByDesc('created_at')->first()
                    : null;
            @endphp

            <tr>
                <td>
                    {{ $course->course_code ?? '' }}
                    -
                    {{ $course->course_name ?? '' }}
                </td>

                <td>
                    {{ $course->program->name ?? 'N/A' }}
                </td>

                <td>
                    {{ $syllabus->academic_year ?? 'N/A' }}
                </td>

                <td>
                    {{ $assignment->assignment_role }}
                </td>

                <td>
                    {{ $statusName }}
                </td>

                <td>
                    {{ $latestApproval?->comment ?? 'Không có' }}
                </td>

                <td>
                    @if($statusName === 'Rejected')
                        <a href="{{ route('lecturer.syllabuses.edit', $syllabus->id) }}">
                            Sửa và gửi lại
                        </a>
                    @elseif($statusName === 'Approved')
                        <span>Đã duyệt</span>
                    @elseif($statusName === 'Submitted')
                        <span>Đang chờ duyệt</span>
                    @else
                        <a href="{{ route('lecturer.syllabuses.edit', $syllabus->id) }}">
                            Soạn đề cương
                        </a>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">
                    Bạn chưa được giao đề cương nào.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
