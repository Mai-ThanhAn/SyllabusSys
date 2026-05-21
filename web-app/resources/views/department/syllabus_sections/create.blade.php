<h1>Thêm section</h1>

<p>
    Template:
    <strong>{{ $template->template_name }}</strong>
</p>

@if($errors->any())
    <ul style="color:red">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST"
      action="{{ route(
        'department.syllabus-templates.sections.store',
        $template->id
      ) }}">

    @csrf

    <p>
        <label>Title:</label><br>
        <input type="text" name="title" value="{{ old('title') }}">
    </p>

    <p>
        <label>Section Code:</label><br>
        <input type="text" name="section_code" value="{{ old('section_code') }}">
    </p>

    <p>
        <label>Display Order:</label><br>
        <input type="number" name="display_order" value="{{ old('display_order', 1) }}">
    </p>

    <p>
        <label>Input Type:</label><br>

        <select name="input_type">
            <option value="rich_text">rich_text</option>
            <option value="structured_co">structured_co</option>
            <option value="structured_clo">structured_clo</option>
            <option value="structured_teaching_plan">structured_teaching_plan</option>
        </select>
    </p>

    <p>
        <label>
            <input type="checkbox" name="is_required" checked>
            Required
        </label>
    </p>

    <p>
        <label>
            <input type="checkbox" name="is_editable" checked>
            Editable
        </label>
    </p>

    <p>
        <label>
            <input type="checkbox" name="is_ai_generatable">
            AI Generatable
        </label>
    </p>

    <button type="submit">
        Save
    </button>
</form>

<p>
    <a href="{{ route(
        'department.syllabus-templates.sections.index',
        $template->id
    ) }}">
        Quay lại
    </a>
</p>
