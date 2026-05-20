<h1>Danh sách đề cương chờ duyệt</h1>

@if(session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Môn học</th>
            <th>Chương trình</th>
            <th>Version</th>
            <th>Người gửi</th>
            <th>Ngày gửi</th>
            <th>Thao tác</th>
        </tr>
    </thead>

    <tbody>
        @forelse($approvals as $approval)
            <tr>
                <td>{{ $approval->id }}</td>
                <td>
                    {{ $approval->version->syllabus->course->course_code ?? '' }}
                    -
                    {{ $approval->version->syllabus->course->course_name ?? '' }}
                </td>
                <td>{{ $approval->version->syllabus->course->program->name ?? 'N/A' }}</td>
                <td>v{{ $approval->version->version_number }}</td>
                <td>{{ $approval->version->creator->full_name ?? 'N/A' }}</td>
                <td>{{ $approval->created_at }}</td>
                <td>
                    <a href="{{ route('program-director.syllabus-approvals.show', $approval->id) }}">
                        Xem chi tiết
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">Không có đề cương nào chờ duyệt.</td>
            </tr>
        @endforelse
    </tbody>
</table>
