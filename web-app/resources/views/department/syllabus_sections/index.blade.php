<h1>Quản lý section</h1>

<p>
    Template:
    <strong>{{ $template->template_name }}</strong>
</p>

@if(session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

<p>
    <a href="{{ route('department.syllabus-templates.sections.create', $template->id) }}">
        Thêm section
    </a>
</p>

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>Order</th>
            <th>Title</th>
            <th>Code</th>
            <th>Input Type</th>
            <th>Editable</th>
            <th>AI</th>
            <th>Required</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @forelse($sections as $section)
            <tr>
                <td>{{ $section->display_order }}</td>

                <td>{{ $section->title }}</td>

                <td>{{ $section->section_code }}</td>

                <td>{{ $section->input_type }}</td>

                <td>{{ $section->is_editable ? 'Yes' : 'No' }}</td>

                <td>{{ $section->is_ai_generatable ? 'Yes' : 'No' }}</td>

                <td>{{ $section->is_required ? 'Yes' : 'No' }}</td>

                <td>
                    <a href="{{ route(
                        'department.syllabus-templates.sections.edit',
                        [$template->id, $section->id]
                    ) }}">
                        Edit
                    </a>

                    <form method="POST"
                          action="{{ route(
                            'department.syllabus-templates.sections.destroy',
                            [$template->id, $section->id]
                          ) }}"
                          style="display:inline">
                        @csrf
                        @method('DELETE')

                        <button type="submit">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8">
                    Chưa có section nào.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

<p>
    <a href="{{ route('department.syllabus-templates.index') }}">
        Quay lại template
    </a>
</p>
