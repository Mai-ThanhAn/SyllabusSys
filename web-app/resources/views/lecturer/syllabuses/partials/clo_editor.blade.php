<h3>AI Generate CLO</h3>

<form method="POST" action="{{ route('lecturer.syllabuses.ai.generateCLO', $syllabus->id) }}">
    @csrf
    <button type="submit">AI Generate CLO</button>
</form>

@if (session('ai_result_clo'))
    @php($aiClo = session('ai_result_clo'))

    <div style="border:1px solid #ccc; padding:12px; margin-top:12px;">
        <h3>Kết quả AI Generate CLO</h3>

        <p>
            Điểm kiểm chứng:
            <strong>{{ $aiClo['verification']['final_score'] ?? 'N/A' }}</strong>
        </p>

        <p>
            Trạng thái:
            <strong>{{ $aiClo['verification']['status'] ?? 'N/A' }}</strong>
        </p>

        @foreach ($aiClo['generated_data'] as $clo)
            <div style="margin-bottom:12px;">
                <p>
                    <strong>{{ $clo['code'] }}</strong>:
                    {{ $clo['description'] }}
                </p>

                <p>
                    Bloom: {{ $clo['bloom_level'] ?? 'N/A' }}
                </p>

                <p>
                    CO mapping:
                    {{ implode(', ', $clo['mapped_co'] ?? []) }}
                </p>

                <p>
                    PI mapping:
                    {{ implode(', ', $clo['mapped_pi'] ?? []) }}
                </p>
            </div>
        @endforeach

        @if (!empty($aiClo['verification']['warnings']))
            <h4>Cảnh báo</h4>
            <ul>
                @foreach ($aiClo['verification']['warnings'] as $warning)
                    <li>{{ $warning }}</li>
                @endforeach
            </ul>
        @endif

        <form method="POST" action="{{ route('lecturer.syllabuses.ai.acceptCLO', $syllabus->id) }}">
            @csrf

            @foreach ($aiClo['generated_data'] as $index => $clo)
                <input type="hidden" name="course_learning_outcomes[{{ $index }}][code]"
                    value="{{ $clo['code'] }}">
                <input type="hidden" name="course_learning_outcomes[{{ $index }}][description]"
                    value="{{ $clo['description'] }}">
                <input type="hidden" name="course_learning_outcomes[{{ $index }}][bloom_level]"
                    value="{{ $clo['bloom_level'] ?? '' }}">
            @endforeach

            <button type="submit">Accept CLO</button>
        </form>
    </div>
@endif

<hr>

<h3>Course Learning Outcomes (CLO)</h3>

@if ($syllabus->courseLearningOutcomes->count())

    <form method="POST" action="{{ route('lecturer.syllabuses.updateCLO', $syllabus->id) }}">
        @csrf
        @method('PUT')

        @foreach ($syllabus->courseLearningOutcomes as $clo)
            <div style="margin-bottom:16px; border:1px solid #ccc; padding:12px;">
                <label>
                    <strong>{{ $clo->code }}</strong>
                </label>

                <br><br>

                <textarea name="course_learning_outcomes[{{ $clo->id }}][description]" rows="4" style="width:100%;">{{ old('course_learning_outcomes.' . $clo->id . '.description', $clo->description) }}</textarea>

                <p>
                    <label>Bloom Level:</label><br>
                    <input type="text" name="course_learning_outcomes[{{ $clo->id }}][bloom_level]"
                        value="{{ old('course_learning_outcomes.' . $clo->id . '.bloom_level', $clo->bloom_level) }}">
                </p>
            </div>
        @endforeach

        <button type="submit">Lưu CLO</button>
    </form>
@else
    <p>Chưa có CLO nào được chấp nhận.</p>
@endif

<hr>
