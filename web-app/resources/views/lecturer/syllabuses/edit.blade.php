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

@if(session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

@if($errors->any())
    <ul style="color:red">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="{{ route('lecturer.syllabuses.update', $syllabus->id) }}">
    @csrf
    @method('PUT')

    @foreach($contents as $content)
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

            <textarea
                name="contents[{{ $content->id }}]"
                rows="8"
                style="width: 100%;"
            >{{ old('contents.' . $content->id, $content->content_html) }}</textarea>
        </div>

        <hr>
    @endforeach

    <button type="submit">
        Lưu nháp
    </button>
</form>

<p>
    <a href="{{ route('lecturer.dashboard') }}">Quay lại dashboard</a>
</p>
