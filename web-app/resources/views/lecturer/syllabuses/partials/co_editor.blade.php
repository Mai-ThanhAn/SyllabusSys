<h3>AI Generate CO</h3>

<form method="POST" action="{{ route('lecturer.syllabuses.ai.generateCO', $syllabus->id) }}">
    @csrf
    <button type="submit">AI Generate CO</button>
</form>

@if (session('ai_result'))
    @php($ai = session('ai_result'))

    <div style="border:1px solid #ccc; padding:12px; margin-top:12px;">
        <h3>Kết quả AI Generate CO</h3>

        <p>Điểm kiểm chứng: <strong>{{ $ai['verification']['final_score'] ?? 'N/A' }}</strong></p>

        @foreach ($ai['generated_data'] as $co)
            <p><strong>{{ $co['code'] }}</strong>: {{ $co['description'] }}</p>
        @endforeach

        <form method="POST" action="{{ route('lecturer.syllabuses.ai.acceptCO', $syllabus->id) }}">
            @csrf

            @foreach ($ai['generated_data'] as $index => $co)
                <input type="hidden" name="course_objectives[{{ $index }}][code]" value="{{ $co['code'] }}">
                <input type="hidden" name="course_objectives[{{ $index }}][description]"
                    value="{{ $co['description'] }}">
            @endforeach

            <button type="submit">Accept CO</button>
        </form>
    </div>
@endif

<hr>

<h3>Course Objectives (CO)</h3>

@if ($syllabus->courseObjectives->count())
    <form method="POST" action="{{ route('lecturer.syllabuses.updateCO', $syllabus->id) }}">
        @csrf
        @method('PUT')

        @foreach ($syllabus->courseObjectives as $co)
            <div style="margin-bottom: 16px; border:1px solid #ccc; padding:12px;">
                <label>
                    <strong>{{ $co->code }}</strong>
                </label>

                <br><br>

                <textarea name="course_objectives[{{ $co->id }}][description]" rows="4" style="width:100%;">{{ old('course_objectives.' . $co->id . '.description', $co->description) }}</textarea>
            </div>
        @endforeach

        <button type="submit">
            Lưu CO
        </button>
    </form>
@else
    <p>Chưa có CO nào được chấp nhận.</p>

@endif
