<h1>Bổ nhiệm giám đốc CTĐT</h1>

@if(session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

<p>
    Chương trình:
    <strong>
        {{ $program->program_code }} - {{ $program->program_name }}
    </strong>
</p>

<p>
    Giám đốc CTĐT hiện tại:
    <strong>
        {{ $program->director->full_name ?? 'Chưa bổ nhiệm' }}
    </strong>
</p>

<hr>

<form method="POST" action="{{ route('department.programs.assignDirector', $program->id) }}">
    @csrf

    <p>
        <label>Chọn tài khoản trong viện/khoa:</label><br>

        <select name="user_id">
            @foreach($users as $user)
                <option value="{{ $user->id }}">
                    {{ $user->full_name }} - {{ $user->email }}
                </option>
            @endforeach
        </select>
    </p>

    <button type="submit">
        Bổ nhiệm giám đốc CTĐT
    </button>
</form>

<p>
    <a href="{{ route('department.programs.index') }}">
        Quay lại
    </a>
</p>
