<h1>Danh sách tài khoản chờ duyệt</h1>

@if(session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

@if(session('error'))
    <p style="color: red">{{ session('error') }}</p>
@endif

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Họ tên</th>
            <th>Email</th>
            <th>Vai trò đăng ký</th>
            <th>Ghi chú</th>
            <th>Ngày gửi</th>
            <th>Thao tác</th>
        </tr>
    </thead>

    <tbody>
        @forelse($requests as $request)
            <tr>
                <td>{{ $request->id }}</td>
                <td>{{ $request->user->full_name ?? 'N/A' }}</td>
                <td>{{ $request->user->email ?? 'N/A' }}</td>
                <td>{{ $request->requested_role }}</td>
                <td>{{ $request->note }}</td>
                <td>{{ $request->created_at }}</td>
                <td>
                    <form method="POST" action="{{ route('approval.approve', $request->id) }}" style="display:inline">
                        @csrf
                        <button type="submit">Duyệt</button>
                    </form>

                    <form method="POST" action="{{ route('approval.reject', $request->id) }}" style="display:inline">
                        @csrf
                        <input type="text" name="reason" placeholder="Lý do từ chối">
                        <button type="submit">Từ chối</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">Không có tài khoản nào chờ duyệt.</td>
            </tr>
        @endforelse
    </tbody>
</table>
