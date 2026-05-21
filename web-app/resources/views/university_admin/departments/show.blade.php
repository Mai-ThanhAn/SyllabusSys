<h1>Bổ nhiệm viện trưởng/khoa trưởng</h1>

<p>
    Viện/khoa:
    <strong>{{ $department->department_name }}</strong>
</p>

<p>
    Hiện tại:
    <strong>{{ $department->head->full_name ?? 'Chưa bổ nhiệm' }}</strong>
</p>

@if(session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

<form method="POST" action="{{ route('university-admin.departments.assignHead', $department->id) }}">
    @csrf

    <p>
        <label>Chọn tài khoản:</label><br>
        <select name="user_id">
            @foreach($users as $user)
                <option value="{{ $user->id }}">
                    {{ $user->full_name }} - {{ $user->email }}
                </option>
            @endforeach
        </select>
    </p>

    <button type="submit">Bổ nhiệm</button>
</form>

<p>
    <a href="{{ route('university-admin.departments.index') }}">Quay lại</a>
</p>
