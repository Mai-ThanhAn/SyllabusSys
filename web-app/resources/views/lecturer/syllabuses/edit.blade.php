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
<form method="POST" action="{{ route('lecturer.syllabuses.update', $syllabus->id) }}">
    @csrf
    @method('PUT')

    @foreach ($contents as $content)
        @php
            $section = $content->section;
        @endphp

        <div style="border:1px solid #ccc; padding:12px; margin-bottom:16px;">
            <h3>
                {{ $section->display_order }}.
                {{ $section->title }}
            </h3>

            @switch($section->section_code)
                @case('CO')
                    @include('lecturer.syllabuses.partials.co_editor', ['syllabus' => $syllabus])
                @break

                @case('CLO')
                    @include('lecturer.syllabuses.partials.clo_editor', ['syllabus' => $syllabus])
                @break

                @case('TEACHING_PLAN')
                    @include('lecturer.syllabuses.partials.teaching_plan_editor', [
                        'syllabus' => $syllabus,
                    ])
                @break

                @default
                    @if ($section->is_editable)
                        <textarea class="ckeditor" name="contents[{{ $content->id }}]" rows="8" style="width:100%;">{{ old('contents.' . $content->id, $content->content_html) }}</textarea>
                    @else
                        <div>
                            {!! $content->content_html !!}
                        </div>
                    @endif
            @endswitch
        </div>
    @endforeach

    <button type="submit">Lưu nháp nội dung đề cương</button>
</form>

<form method="POST" action="{{ route('lecturer.syllabuses.submit', $syllabus->id) }}">
    @csrf
    <button type="submit">
        Gửi duyệt đề cương
    </button>
</form>
<p>
    <a href="{{ route('lecturer.dashboard') }}">Quay lại dashboard</a>
</p>

<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.ckeditor').forEach(function (textarea) {
            ClassicEditor
                .create(textarea)
                .catch(error => console.error(error));
        });
    });
</script>
