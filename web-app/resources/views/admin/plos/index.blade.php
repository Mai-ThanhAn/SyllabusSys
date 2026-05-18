<h1>Danh sách PLO</h1>

<p>
    Chương trình:
    <strong>{{ $program->name }}</strong>
</p>

@if (session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

<a href="{{ route('programs.plos.create', $program->id) }}">
    Thêm PLO
</a>

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>Mã PLO</th>
            <th>Mô tả</th>
            <th>Thao tác</th>
        </tr>
    </thead>

    <tbody>
        @forelse($plos as $plo)
            <tr>
                <td>{{ $plo->code }}</td>

                <td>{{ $plo->description }}</td>

                <td>
                    <a href="{{ route('programs.plos.edit', [$program->id, $plo->id]) }}">
                        Sửa
                    </a>

                    <a href="{{ route('programs.plos.pis.index', [$program->id, $plo->id]) }}">
                        Quản lý PI
                    </a>

                    <form method="POST" action="{{ route('programs.plos.destroy', [$program->id, $plo->id]) }}"
                        style="display:inline">
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
                <td colspan="3">
                    Chưa có PLO nào.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
