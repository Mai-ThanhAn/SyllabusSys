<h1>Sửa PI</h1>

<p>Chương trình: <strong>{{ $program->name }}</strong></p>
<p>PLO: <strong>{{ $plo->code }}</strong></p>

@if($errors->any())
    <ul style="color:red">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="{{ route('programs.plos.pis.update', [$program->id, $plo->id, $pi->id]) }}">
    @csrf
    @method('PUT')

    <p>
        <label>Mã PI:</label><br>
        <input type="text" name="code" value="{{ old('code', $pi->code) }}">
    </p>

    <p>
        <label>Mô tả:</label><br>
        <textarea name="description" rows="5">{{ old('description', $pi->description) }}</textarea>
    </p>

    <button type="submit">Cập nhật</button>
</form>

<p>
    <a href="{{ route('programs.plos.pis.index', [$program->id, $plo->id]) }}">
        Quay lại
    </a>
</p>
