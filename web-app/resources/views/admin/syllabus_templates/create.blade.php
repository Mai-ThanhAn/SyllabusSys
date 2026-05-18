<h1>Thêm khung đề cương</h1>

@if($errors->any())
    <ul style="color:red">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="{{ route('syllabus-templates.store') }}">
    @csrf

    <p>
        <label>Tên khung:</label><br>
        <input type="text" name="template_name" value="{{ old('template_name') }}">
    </p>

    <p>
        <label>Mô tả:</label><br>
        <textarea name="description">{{ old('description') }}</textarea>
    </p>

    <p>
        <label>
            <input type="checkbox" name="is_active" checked>
            Đang sử dụng
        </label>
    </p>

    <button type="submit">Lưu</button>
</form>

<a href="{{ route('syllabus-templates.index') }}">Quay lại</a>
