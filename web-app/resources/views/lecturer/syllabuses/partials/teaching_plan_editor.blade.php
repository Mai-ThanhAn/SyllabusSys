
<h3>AI Generate Teaching Plan</h3>

<form method="POST" action="{{ route('lecturer.syllabuses.ai.generateTeachingPlan', $syllabus->id) }}">
    @csrf
    <button type="submit">AI Generate Teaching Plan</button>
</form>

@if (session('ai_result_teaching_plan'))
    @php($aiPlan = session('ai_result_teaching_plan'))

    <div style="border:1px solid #ccc; padding:12px; margin-top:12px;">
        <h3>Kết quả AI Generate Teaching Plan</h3>

        <p>
            Điểm kiểm chứng:
            <strong>{{ $aiPlan['verification']['final_score'] ?? 'N/A' }}</strong>
        </p>

        <p>
            Trạng thái:
            <strong>{{ $aiPlan['verification']['status'] ?? 'N/A' }}</strong>
        </p>

        @foreach ($aiPlan['generated_data'] as $item)
            <div style="margin-bottom:16px; border:1px solid #ddd; padding:10px;">
                <h4>{{ $item['order'] }}. {{ $item['title'] }}</h4>

                <p><strong>Nội dung:</strong></p>
                <ul>
                    @foreach ($item['content'] ?? [] as $content)
                        <li>{{ $content }}</li>
                    @endforeach
                </ul>

                <p><strong>Hoạt động dạy:</strong></p>
                <ul>
                    @foreach ($item['teaching_activities'] ?? [] as $act)
                        <li>{{ $act }}</li>
                    @endforeach
                </ul>

                <p><strong>Hoạt động học:</strong></p>
                <ul>
                    @foreach ($item['learning_activities'] ?? [] as $act)
                        <li>{{ $act }}</li>
                    @endforeach
                </ul>

                <p><strong>Đánh giá:</strong></p>
                <ul>
                    @foreach ($item['assessment_activities'] ?? [] as $act)
                        <li>{{ $act }}</li>
                    @endforeach
                </ul>

                <p>
                    <strong>Mapped CLO:</strong>
                    {{ implode(', ', $item['mapped_clo'] ?? []) }}
                </p>
            </div>
        @endforeach

        @if (!empty($aiPlan['verification']['warnings']))
            <h4>Cảnh báo</h4>
            <ul>
                @foreach ($aiPlan['verification']['warnings'] as $warning)
                    <li>{{ $warning }}</li>
                @endforeach
            </ul>
        @endif

        <form method="POST" action="{{ route('lecturer.syllabuses.ai.acceptTeachingPlan', $syllabus->id) }}">
            @csrf

            @foreach ($aiPlan['generated_data'] as $i => $item)
                <input type="hidden" name="teaching_plan[{{ $i }}][order]" value="{{ $item['order'] }}">
                <input type="hidden" name="teaching_plan[{{ $i }}][title]" value="{{ $item['title'] }}">

                @foreach ($item['content'] ?? [] as $j => $content)
                    <input type="hidden" name="teaching_plan[{{ $i }}][content][{{ $j }}]"
                        value="{{ $content }}">
                @endforeach

                @foreach ($item['teaching_activities'] ?? [] as $j => $act)
                    <input type="hidden"
                        name="teaching_plan[{{ $i }}][teaching_activities][{{ $j }}]"
                        value="{{ $act }}">
                @endforeach

                @foreach ($item['learning_activities'] ?? [] as $j => $act)
                    <input type="hidden"
                        name="teaching_plan[{{ $i }}][learning_activities][{{ $j }}]"
                        value="{{ $act }}">
                @endforeach

                @foreach ($item['assessment_activities'] ?? [] as $j => $act)
                    <input type="hidden"
                        name="teaching_plan[{{ $i }}][assessment_activities][{{ $j }}]"
                        value="{{ $act }}">
                @endforeach

                @foreach ($item['mapped_clo'] ?? [] as $j => $clo)
                    <input type="hidden" name="teaching_plan[{{ $i }}][mapped_clo][{{ $j }}]"
                        value="{{ $clo }}">
                @endforeach
            @endforeach

            <button type="submit">Accept Teaching Plan</button>
        </form>
    </div>
@endif
<hr>

<h3>Kế hoạch giảng dạy đã lưu</h3>

@if ($syllabus->teachingPlanItems->count())

    @foreach ($syllabus->teachingPlanItems->sortBy('item_order') as $item)
        <div style="border:1px solid #ccc; padding:12px; margin-bottom:12px;">
            <h4>{{ $item->item_order }}. {{ $item->title }}</h4>

            <p><strong>Nội dung:</strong></p>
            <ul>
                @foreach ($item->content ?? [] as $content)
                    <li>{{ $content }}</li>
                @endforeach
            </ul>

            <p><strong>Hoạt động dạy:</strong></p>
            <ul>
                @foreach ($item->teaching_activities ?? [] as $act)
                    <li>{{ $act }}</li>
                @endforeach
            </ul>

            <p><strong>Hoạt động học:</strong></p>
            <ul>
                @foreach ($item->learning_activities ?? [] as $act)
                    <li>{{ $act }}</li>
                @endforeach
            </ul>

            <p><strong>Đánh giá:</strong></p>
            <ul>
                @foreach ($item->assessment_activities ?? [] as $act)
                    <li>{{ $act }}</li>
                @endforeach
            </ul>

            <p>
                <strong>CLO liên quan:</strong>
                @foreach ($item->cloMappings as $mapping)
                    {{ $mapping->clo->code ?? '' }}
                @endforeach
            </p>
        </div>
    @endforeach
@else
    <p>Chưa có kế hoạch giảng dạy.</p>
@endif
<hr>
