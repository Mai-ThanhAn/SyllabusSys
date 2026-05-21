<h1>University Admin Dashboard</h1>

<ul>
    <li>
        <a href="{{ route('university-admin.users.index') }}">
            Quản lý tài khoản và phân quyền
        </a>
    </li>

    <li>
        <a href="{{ route('university-admin.departments.index') }}">
            Quản lý viện / khoa
        </a>
    </li>
</ul>

<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Đăng xuất</button>
</form>
