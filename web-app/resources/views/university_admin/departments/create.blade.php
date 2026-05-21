<h1>Thêm viện / khoa</h1>

@if($errors->any())
    <ul style="color:red">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST"
      action="{{ route('university-admin.departments.store') }}">

    @csrf

    <p>
        <label>Tên viện/khoa:</label><br>

        <input type="text"
               name="department_name"
               value="{{ old('department_name') }}">
    </p>

    <p>
        <label>Trường:</label><br>

        <select name="university_id">

            <option value="">
                -- Chọn trường --
            </option>

            @foreach($universities as $university)

                <option value="{{ $university->id }}">

                    {{ $university->university_name ?? ('University #' . $university->id) }}

                </option>

            @endforeach

        </select>
    </p>

    <button type="submit">
        Lưu
    </button>
</form>

<p>
    <a href="{{ route('university-admin.departments.index') }}">
        Quay lại
    </a>
</p>
