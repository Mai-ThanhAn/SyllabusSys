<h1>Soạn đề cương</h1>

<p>
    Môn học:
    <strong>{{ $syllabus->course->course_code }} - {{ $syllabus->course->course_name }}</strong>
</p>

<p>
    Chương trình:
    <strong>{{ $syllabus->course->program->name ?? 'N/A' }}</strong>
</p>

<p>
    Khung:
    <strong>{{ $syllabus->template->template_name ?? 'N/A' }}</strong>
</p>

<p>
    Năm học:
    <strong>{{ $syllabus->academic_year }}</strong>
</p>

<hr>

<h3>PLO mục tiêu</h3>
<ul>
    @forelse($syllabus->ploTargets as $target)
        <li>
            {{ $target->programLearningOutcome->code ?? '' }}
            -
            {{ $target->programLearningOutcome->description ?? '' }}
        </li>
    @empty
        <li>Chưa có PLO mục tiêu.</li>
    @endforelse
</ul>

<h3>PI mục tiêu</h3>
<ul>
    @forelse($syllabus->piTargets as $target)
        <li>
            {{ $target->performanceIndicator->code ?? '' }}
            -
            {{ $target->performanceIndicator->description ?? '' }}
        </li>
    @empty
        <li>Chưa có PI mục tiêu.</li>
    @endforelse
</ul>

<hr>

@if (session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

@if ($errors->any())
    <ul style="color:red">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<hr>

<h3>AI hỗ trợ soạn đề cương</h3>

<form method="POST" action="{{ route('lecturer.syllabuses.ai.generateCO', $syllabus->id) }}">
    @csrf
    <button type="submit">AI Generate CO</button>
</form>

@if (session('ai_result'))
    @php($ai = session('ai_result'))

    <div style="border:1px solid #ccc; padding:12px; margin-top:12px;">
        <h3>Kết quả AI Generate CO</h3>

        <p>
            Điểm kiểm chứng:
            <strong>{{ $ai['verification']['final_score'] ?? 'N/A' }}</strong>
        </p>

        <p>
            Trạng thái:
            <strong>{{ $ai['verification']['status'] ?? 'N/A' }}</strong>
        </p>

        @foreach ($ai['generated_data'] as $co)
            <p>
                <strong>{{ $co['code'] }}</strong>:
                {{ $co['description'] }}
            </p>
        @endforeach

        @if (!empty($ai['verification']['warnings']))
            <h4>Cảnh báo</h4>
            <ul>
                @foreach ($ai['verification']['warnings'] as $warning)
                    <li>{{ $warning }}</li>
                @endforeach
            </ul>
        @endif

        <form method="POST" action="{{ route('lecturer.syllabuses.ai.acceptCO', $syllabus->id) }}">
            @csrf

            @foreach ($ai['generated_data'] as $index => $co)
                <input type="hidden" name="course_objectives[{{ $index }}][code]" value="{{ $co['code'] }}">
                <input type="hidden" name="course_objectives[{{ $index }}][description]"
                    value="{{ $co['description'] }}">
            @endforeach

            <button type="submit">
                Chấp nhận CO
            </button>
        </form>
    </div>
@endif

<hr>

<form method="POST" action="{{ route('lecturer.syllabuses.update', $syllabus->id) }}">
    @csrf
    @method('PUT')

    @foreach ($contents as $content)
        <div style="margin-bottom: 24px;">
            <h3>
                {{ $content->section->display_order }}.
                {{ $content->section->title }}
            </h3>

            <p>
                Mã mục: {{ $content->section->section_code }}
                |
                AI Generate:
                {{ $content->section->is_ai_generatable ? 'Có' : 'Không' }}
            </p>

            <textarea name="contents[{{ $content->id }}]" rows="8" style="width: 100%;">{{ old('contents.' . $content->id, $content->content_html) }}</textarea>
        </div>

        <hr>
    @endforeach

    <button type="submit">
        Lưu nháp
    </button>
</form>

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

<hr>
<hr>

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

<hr>

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

<h3>Kế hoạch giảng dạy đã lưu</h3>

@if ($syllabus->teachingPlanItems->count())

    <form method="POST" action="{{ route('lecturer.syllabuses.updateTeachingPlan', $syllabus->id) }}">
        @csrf
        @method('PUT')

        @foreach ($syllabus->teachingPlanItems->sortBy('item_order') as $item)
            <div style="border:1px solid #ccc; padding:12px; margin-bottom:16px;">
                <h4>Mục {{ $item->item_order }}</h4>

                <p>
                    <label>Tiêu đề:</label><br>
                    <input type="text" name="teaching_plan[{{ $item->id }}][title]"
                        value="{{ old('teaching_plan.' . $item->id . '.title', $item->title) }}" style="width:100%;">
                </p>

                <p><strong>Nội dung:</strong></p>
                @foreach ($item->content ?? [] as $i => $content)
                    <textarea name="teaching_plan[{{ $item->id }}][content][{{ $i }}]" rows="3"
                        style="width:100%; margin-bottom:6px;">{{ $content }}</textarea>
                @endforeach

                <p><strong>Hoạt động dạy:</strong></p>
                @foreach ($item->teaching_activities ?? [] as $i => $act)
                    <textarea name="teaching_plan[{{ $item->id }}][teaching_activities][{{ $i }}]" rows="3"
                        style="width:100%; margin-bottom:6px;">{{ $act }}</textarea>
                @endforeach

                <p><strong>Hoạt động học:</strong></p>
                @foreach ($item->learning_activities ?? [] as $i => $act)
                    <textarea name="teaching_plan[{{ $item->id }}][learning_activities][{{ $i }}]" rows="3"
                        style="width:100%; margin-bottom:6px;">{{ $act }}</textarea>
                @endforeach

                <p><strong>Hoạt động đánh giá:</strong></p>
                @foreach ($item->assessment_activities ?? [] as $i => $act)
                    <textarea name="teaching_plan[{{ $item->id }}][assessment_activities][{{ $i }}]" rows="3"
                        style="width:100%; margin-bottom:6px;">{{ $act }}</textarea>
                @endforeach

                <p>
                    <strong>CLO liên quan:</strong><br>

                    @php
                        $selectedCloIds = $item->cloMappings->pluck('clo_id')->toArray();
                    @endphp

                    @foreach ($syllabus->courseLearningOutcomes as $clo)
                        <label style="display:block;">
                            <input type="checkbox" name="teaching_plan[{{ $item->id }}][mapped_clo_ids][]"
                                value="{{ $clo->id }}" @checked(in_array($clo->id, $selectedCloIds))>
                            {{ $clo->code }} - {{ $clo->description }}
                        </label>
                    @endforeach
                </p>
            </div>
        @endforeach

        <button type="submit">Lưu kế hoạch giảng dạy</button>
    </form>
@else
    <p>Chưa có kế hoạch giảng dạy.</p>
@endif
<hr>

<form method="POST" action="{{ route('lecturer.syllabuses.submit', $syllabus->id) }}">
    @csrf
    <button type="submit">
        Gửi duyệt đề cương
    </button>
</form>
<p>
    <a href="{{ route('lecturer.dashboard') }}">Quay lại dashboard</a>
</p>
