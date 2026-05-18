<h1>Thêm PI</h1>

<p>Chương trình: <strong>{{ $program->name }}</strong></p>
<p>PLO: <strong>{{ $plo->code }}</strong></p>

@if($errors->any())
    <ul style="color:red">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="{{ route('programs.plos.pis.store', [$program->id, $plo->id]) }}">
    @csrf

    <p>
        <label>Mã PI:</label><br>
        <input type="text" name="code" value="{{ old('code') }}" placeholder="Ví dụ: PI3.1">
    </p>

    <p>
        <label>Mô tả:</label><br>
        <textarea name="description" rows="5">{{ old('description') }}</textarea>
    </p>

    <button type="submit">Lưu</button>
</form>

<p>
    <a href="{{ route('programs.plos.pis.index', [$program->id, $plo->id]) }}">
        Quay lại
    </a>
</p>
