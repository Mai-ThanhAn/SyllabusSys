<h1>Chọn vai trò đăng ký</h1>

<p>Email Google: {{ $email }}</p>
<p>Họ tên: {{ $fullName }}</p>

@if(session('error'))
    <p style="color:red">{{ session('error') }}</p>
@endif

<ul>
    <li>
        <a href="{{ route('account.registerLecturer') }}">
            Đăng ký tài khoản giảng viên / trưởng viện
        </a>
    </li>
</ul>

<p>
    <a href="{{ route('account.login') }}">Quay lại đăng nhập</a>
</p>
