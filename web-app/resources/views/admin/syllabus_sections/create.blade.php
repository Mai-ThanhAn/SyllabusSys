<h1>Thêm mục đề cương</h1>

<p>
    Khung:
    <strong>{{ $template->template_name }}</strong>
</p>

@if($errors->any())
    <ul style="color:red">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form
    method="POST"
    action="{{ route('syllabus-templates.sections.store', $template->id) }}"
>
    @csrf

    <p>
        <label>Mã mục:</label><br>
        <input type="text" name="section_code" value="{{ old('section_code') }}">
    </p>

    <p>
        <label>Tiêu đề:</label><br>
        <input type="text" name="title" value="{{ old('title') }}">
    </p>

    <p>
        <label>Thứ tự hiển thị:</label><br>
        <input type="number" name="display_order" value="{{ old('display_order', 1) }}">
    </p>

    <p>
        <label>
            <input type="checkbox" name="is_required" checked>
            Là mục bắt buộc
        </label>
    </p>

    <p>
        <label>
            <input type="checkbox" name="is_ai_generatable">
            Cho phép AI generate
        </label>
    </p>

    <button type="submit">
        Lưu
    </button>
</form>

<p>
    <a href="{{ route('syllabus-templates.sections.index', $template->id) }}">
        Quay lại
    </a>
</p>
