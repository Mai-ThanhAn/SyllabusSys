1. index.blade.php
resources/views/department/courses/index.blade.php
<h1>Quản lý môn học</h1>

@if(session('success'))
    <p style="color: green">
        {{ session('success') }}
    </p>
@endif

<p>
    <a href="{{ route('department.courses.create') }}">
        Thêm môn học
    </a>
</p>

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Mã môn</th>
            <th>Tên môn học</th>
            <th>Số tín chỉ</th>
            <th>CTĐT</th>
            <th>Thao tác</th>
        </tr>
    </thead>

    <tbody>
        @forelse($courses as $course)

            <tr>
                <td>{{ $course->id }}</td>

                <td>{{ $course->course_code }}</td>

                <td>{{ $course->course_name }}</td>

                <td>{{ $course->credits }}</td>

                <td>
                    {{ $course->program->code ?? '' }}
                    -
                    {{ $course->program->name ?? '' }}
                </td>

                <td>

                    <a href="{{ route(
                        'department.courses.edit',
                        $course->id
                    ) }}">
                        Sửa
                    </a>

                    |

                    <form method="POST"
                          action="{{ route(
                            'department.courses.destroy',
                            $course->id
                          ) }}"
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
                <td colspan="6">
                    Chưa có môn học nào.
                </td>
            </tr>

        @endforelse
    </tbody>
</table>

<p>
    <a href="{{ route('department.dashboard') }}">
        Quay lại dashboard
    </a>
</p>
2. create.blade.php
resources/views/department/courses/create.blade.php
<h1>Thêm môn học</h1>

@if($errors->any())
    <ul style="color:red">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST"
      action="{{ route('department.courses.store') }}">

    @csrf

    <p>
        <label>Mã môn học:</label><br>

        <input type="text"
               name="course_code"
               value="{{ old('course_code') }}">
    </p>

    <p>
        <label>Tên môn học:</label><br>

        <input type="text"
               name="course_name"
               value="{{ old('course_name') }}">
    </p>

    <p>
        <label>Số tín chỉ:</label><br>

        <input type="number"
               name="credits"
               min="1"
               value="{{ old('credits', 3) }}">
    </p>

    <p>
        <label>Chương trình đào tạo:</label><br>

        <select name="program_id">

            <option value="">
                -- Chọn CTĐT --
            </option>

            @foreach($programs as $program)

                <option value="{{ $program->id }}">

                    {{ $program->code }}
                    -
                    {{ $program->name }}

                </option>

            @endforeach

        </select>
    </p>

    <button type="submit">
        Lưu
    </button>
</form>

<p>
    <a href="{{ route('department.courses.index') }}">
        Quay lại
    </a>
</p>
