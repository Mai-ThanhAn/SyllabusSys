<h1>Danh sách PI</h1>

<p>Chương trình: <strong>{{ $program->name }}</strong></p>
<p>PLO: <strong>{{ $plo->code }} - {{ $plo->description }}</strong></p>

@if(session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

<a href="{{ route('programs.plos.pis.create', [$program->id, $plo->id]) }}">
    Thêm PI
</a>

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>Mã PI</th>
            <th>Mô tả</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @forelse($pis as $pi)
            <tr>
                <td>{{ $pi->code }}</td>
                <td>{{ $pi->description }}</td>
                <td>
                    <a href="{{ route('programs.plos.pis.edit', [$program->id, $plo->id, $pi->id]) }}">
                        Sửa
                    </a>

                    <form method="POST" action="{{ route('programs.plos.pis.destroy', [$program->id, $plo->id, $pi->id]) }}" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Xóa</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3">Chưa có PI nào.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<p>
    <a href="{{ route('programs.plos.index', $program->id) }}">
        Quay lại PLO
    </a>
</p>
