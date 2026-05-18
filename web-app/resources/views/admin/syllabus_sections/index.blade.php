<h1>Danh sách mục đề cương</h1>

<p>
    Khung đề cương:
    <strong>{{ $template->template_name }}</strong>
</p>

@if(session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

<a href="{{ route('syllabus-templates.sections.create', $template->id) }}">
    Thêm mục đề cương
</a>

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>STT</th>
            <th>Mã mục</th>
            <th>Tiêu đề</th>
            <th>Bắt buộc</th>
            <th>AI Generate</th>
            <th>Thao tác</th>
        </tr>
    </thead>

    <tbody>
        @forelse($sections as $section)
            <tr>
                <td>{{ $section->display_order }}</td>

                <td>{{ $section->section_code }}</td>

                <td>{{ $section->title }}</td>

                <td>
                    {{ $section->is_required ? 'Có' : 'Không' }}
                </td>

                <td>
                    {{ $section->is_ai_generatable ? 'Có' : 'Không' }}
                </td>

                <td>
                    <a href="{{ route('syllabus-templates.sections.edit', [$template->id, $section->id]) }}">
                        Sửa
                    </a>

                    <form
                        method="POST"
                        action="{{ route('syllabus-templates.sections.destroy', [$template->id, $section->id]) }}"
                        style="display:inline"
                    >
                        @csrf
                        @method('DELETE')

                        <button type="submit">
                            Xóa
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">
                    Chưa có mục đề cương nào.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

<p>
    <a href="{{ route('syllabus-templates.index') }}">
        Quay lại danh sách khung đề cương
    </a>
</p>
