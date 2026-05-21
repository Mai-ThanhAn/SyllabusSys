<h1>Đăng nhập test</h1>

@if(session('error'))
    <p style="color:red">{{ session('error') }}</p>
@endif

<form method="POST" action="{{ route('login.post') }}">
    @csrf

    <p>
        <label>Email:</label><br>
        <input type="email" name="email">
    </p>

    <p>
        <label>Mật khẩu:</label><br>
        <input type="password" name="password">
    </p>

    <button type="submit">Đăng nhập</button>
</form>
