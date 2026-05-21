<h1>Quản lý tài khoản và phân quyền</h1>

@if (session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Họ tên</th>
            <th>Email</th>
            <th>Role hiện tại</th>
            <th>Gán role</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->full_name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @foreach ($user->roles as $role)
                        <span>{{ $role->role_name }}</span><br>
                    @endforeach
                </td>
                <td>
                    <form method="POST" action="{{ route('university-admin.users.assignRole', $user->id) }}">
                        @csrf

                        <select name="role_id">
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">
                                    {{ $role->role_name }}
                                </option>
                            @endforeach
                        </select>

                        <button type="submit">Gán role</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<p>
    <a href="{{ route('university-admin.dashboard') }}">Quay lại dashboard</a>
</p>
