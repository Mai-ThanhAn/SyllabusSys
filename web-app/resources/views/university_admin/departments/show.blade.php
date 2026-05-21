<h1>Bổ nhiệm trưởng khoa</h1>

@if(session('success'))
    <p style="color: green">
        {{ session('success') }}
    </p>
@endif

<p>
    Viện/khoa:
    <strong>
        {{ $department->department_name }}
    </strong>
</p>

<p>
    Trường:
    <strong>
        {{ $department->university->university_name ?? 'N/A' }}
    </strong>
</p>

<p>
    Trưởng khoa hiện tại:
    <strong>
        {{ $department->head->full_name ?? 'Chưa bổ nhiệm' }}
    </strong>
</p>

<hr>

<form method="POST"
      action="{{ route(
        'university-admin.departments.assignHead',
        $department->id
      ) }}">

    @csrf

    <p>
        <label>Chọn tài khoản:</label><br>

        <select name="user_id">

            @foreach($users as $user)

                <option value="{{ $user->id }}">

                    {{ $user->full_name }}
                    -
                    {{ $user->email }}

                </option>

            @endforeach

        </select>
    </p>

    <button type="submit">
        Bổ nhiệm trưởng khoa
    </button>
</form>

<p>
    <a href="{{ route('university-admin.departments.index') }}">
        Quay lại
    </a>
</p>
