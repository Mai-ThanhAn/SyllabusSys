<h1>Sửa PLO</h1>

<p>
    Chương trình:
    <strong>{{ $program->name }}</strong>
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
    action="{{ route('programs.plos.update', [$program->id, $plo->id]) }}"
>
    @csrf
    @method('PUT')

    <p>
        <label>Mã PLO:</label><br>
        <input
            type="text"
            name="code"
            value="{{ old('code', $plo->code) }}"
        >
    </p>

    <p>
        <label>Mô tả:</label><br>
        <textarea
            name="description"
            rows="5"
        >{{ old('description', $plo->description) }}</textarea>
    </p>

    <button type="submit">
        Cập nhật
    </button>
</form>

<p>
    <a href="{{ route('programs.plos.index', $program->id) }}">
        Quay lại
    </a>
</p>
