<h1>Sửa khung đề cương</h1>

@if($errors->any())
    <ul style="color:red">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="{{ route('department.syllabus-templates.update', $template->id) }}">
    @csrf
    @method('PUT')

    <p>
        <label>Tên khung:</label><br>
        <input type="text" name="template_name" value="{{ old('template_name', $template->template_name) }}">
    </p>

    <p>
        <label>Mô tả:</label><br>
        <textarea name="description" rows="4">{{ old('description', $template->description) }}</textarea>
    </p>

    <p>
        <label>
            <input type="checkbox" name="is_active" @checked($template->is_active)>
            Đang sử dụng
        </label>
    </p>

    <button type="submit">Cập nhật</button>
</form>

<p>
    <a href="{{ route('department.syllabus-templates.index') }}">Quay lại</a>
</p>
