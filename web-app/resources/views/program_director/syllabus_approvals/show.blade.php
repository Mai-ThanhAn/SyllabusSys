<h1>Chi tiết đề cương gửi duyệt</h1>

@php
    $version = $approval->version;
    $syllabus = $version->syllabus;
    $course = $syllabus->course;
@endphp

<p>
    <strong>Môn học:</strong>
    {{ $course->course_code ?? '' }} - {{ $course->course_name ?? '' }}
</p>

<p>
    <strong>Chương trình:</strong>
    {{ $course->program->name ?? 'N/A' }}
</p>

<p>
    <strong>Version:</strong>
    v{{ $version->version_number }}
</p>

<p>
    <strong>Người gửi:</strong>
    {{ $version->creator->full_name ?? 'N/A' }}
</p>

<hr>

<h3>Course Objectives (CO)</h3>

@forelse($version->courseObjectives as $co)
    <p>
        <strong>{{ $co->code }}</strong>:
        {{ $co->description }}
    </p>
@empty
    <p>Không có CO.</p>
@endforelse

<hr>

<h3>Course Learning Outcomes (CLO)</h3>

@forelse($version->courseLearningOutcomes as $clo)
    <p>
        <strong>{{ $clo->code }}</strong>:
        {{ $clo->description }}
        <br>
        Bloom: {{ $clo->bloom_level }}
    </p>
@empty
    <p>Không có CLO.</p>
@endforelse

<hr>

<h3>Kế hoạch giảng dạy</h3>

@forelse($version->teachingPlanItems->sortBy('item_order') as $item)
    <div style="border:1px solid #ccc; padding:12px; margin-bottom:12px;">
        <h4>{{ $item->item_order }}. {{ $item->title }}</h4>

        <p><strong>Nội dung:</strong></p>
        <ul>
            @foreach(($item->content ?? []) as $content)
                <li>{{ $content }}</li>
            @endforeach
        </ul>

        <p><strong>Hoạt động dạy:</strong></p>
        <ul>
            @foreach(($item->teaching_activities ?? []) as $act)
                <li>{{ $act }}</li>
            @endforeach
        </ul>

        <p><strong>Hoạt động học:</strong></p>
        <ul>
            @foreach(($item->learning_activities ?? []) as $act)
                <li>{{ $act }}</li>
            @endforeach
        </ul>

        <p><strong>Đánh giá:</strong></p>
        <ul>
            @foreach(($item->assessment_activities ?? []) as $act)
                <li>{{ $act }}</li>
            @endforeach
        </ul>

        <p>
            <strong>CLO liên quan:</strong>
            @foreach($item->cloMappings as $mapping)
                {{ $mapping->clo_code }}
            @endforeach
        </p>
    </div>
@empty
    <p>Không có kế hoạch giảng dạy.</p>
@endforelse

<hr>

<h3>Nội dung các mục đề cương</h3>

@forelse($version->contents->sortBy(fn($c) => $c->section->display_order ?? 999) as $content)
    <div style="border:1px solid #ddd; padding:12px; margin-bottom:12px;">
        <h4>
            {{ $content->section->display_order ?? '' }}.
            {{ $content->section->title ?? '' }}
        </h4>

        <div>
            {!! $content->content_html !!}
        </div>
    </div>
@empty
    <p>Không có nội dung section.</p>
@endforelse

<hr>

<h3>Duyệt đề cương</h3>

<form method="POST" action="{{ route('program-director.syllabus-approvals.approve', $approval->id) }}" style="display:inline">
    @csrf
    <button type="submit">Duyệt</button>
</form>

<form method="POST" action="{{ route('program-director.syllabus-approvals.reject', $approval->id) }}">
    @csrf

    <p>
        <label>Lý do từ chối:</label><br>
        <textarea name="comment" rows="4" style="width:100%;"></textarea>
    </p>

    <button type="submit">Từ chối</button>
</form>

<p>
    <a href="{{ route('program-director.syllabus-approvals.index') }}">
        Quay lại danh sách
    </a>
</p>
