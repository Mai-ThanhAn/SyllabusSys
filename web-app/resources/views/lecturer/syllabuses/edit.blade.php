@extends('layouts.department')

@section('title', 'Soạn đề cương | Syllabus Lab')

@section('content')
<main class="ml-64 flex flex-col h-screen">
    <header class="bg-[#131315]/80 backdrop-blur-xl border-b border-[#454652]/10 fixed top-0 right-0 w-[calc(100%-16rem)] z-30 flex justify-between items-center h-16 px-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('lecturer.dashboard') }}" class="text-on-surface-variant hover:text-primary transition-colors flex items-center gap-1 font-label text-xs uppercase tracking-widest">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                Quay lại dashboard
            </a>
        </div>

        <form method="POST" action="{{ route('lecturer.syllabuses.submit', $syllabus->id) }}" id="submit-form">
            @csrf
            <button type="submit" class="bg-primary-container text-on-primary-container px-4 py-1.5 rounded-lg font-label text-xs font-bold shadow-extruded hover:brightness-110 transition-all flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">send</span>
                Gửi duyệt đề cương
            </button>
        </form>
    </header>

    <div class="mt-16 flex flex-1 overflow-hidden">
        <aside class="w-80 bg-surface-container-lowest border-r border-outline-variant/10 p-6 overflow-y-auto flex flex-col gap-6">
            <div>
                <h3 class="font-label text-[10px] uppercase tracking-widest text-primary mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">target</span>
                    Mục tiêu chuẩn đầu ra
                </h3>

                <section class="mb-6">
                    <label class="font-label text-xs font-semibold text-on-surface-variant block mb-3">
                        PLO mục tiêu
                    </label>

                    <div class="space-y-2">
                        @forelse($syllabus->ploTargets as $target)
                            <div class="bg-surface-container p-3 rounded-lg border-l-2 border-primary-container">
                                <span class="text-[10px] font-label font-bold text-primary-fixed">
                                    {{ $target->programLearningOutcome->code ?? 'N/A' }}
                                </span>

                                <p class="text-[11px] leading-relaxed text-on-surface/80 mt-1">
                                    {{ $target->programLearningOutcome->description ?? 'Chưa có mô tả' }}
                                </p>
                            </div>
                        @empty
                            <div class="bg-surface-container p-3 rounded-lg border-l-2 border-outline-variant/20">
                                <p class="text-[11px] leading-relaxed text-on-surface/50">
                                    Chưa có PLO mục tiêu.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </section>

                <section>
                    <label class="font-label text-xs font-semibold text-on-surface-variant block mb-3">
                        PI mục tiêu
                    </label>

                    <div class="space-y-2">
                        @forelse($syllabus->piTargets as $target)
                            <div class="bg-surface-container p-3 rounded-lg border-l-2 border-tertiary">
                                <span class="text-[10px] font-label font-bold text-tertiary">
                                    {{ $target->performanceIndicator->code ?? 'N/A' }}
                                </span>

                                <p class="text-[11px] leading-relaxed text-on-surface/80 mt-1">
                                    {{ $target->performanceIndicator->description ?? 'Chưa có mô tả' }}
                                </p>
                            </div>
                        @empty
                            <div class="bg-surface-container p-3 rounded-lg border-l-2 border-outline-variant/20">
                                <p class="text-[11px] leading-relaxed text-on-surface/50">
                                    Chưa có PI mục tiêu.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </section>
            </div>
        </aside>

        <div class="flex-1 overflow-y-auto bg-surface p-12 pb-28">
            <div class="max-w-4xl mx-auto">
                <header class="mb-12">
                    <div class="flex items-end justify-between mb-2">
                        <h2 class="text-4xl font-bold tracking-tight font-display text-transparent bg-clip-text bg-gradient-to-r from-on-surface to-on-surface-variant">
                            Soạn đề cương
                        </h2>

                        <div class="flex gap-2">
                            <span class="bg-surface-container-highest px-3 py-1 rounded text-[10px] font-label font-bold text-primary-fixed border border-primary-container/20">
                                VER 2.4.0-BETA
                            </span>

                            <span class="bg-surface-container-high px-3 py-1 rounded text-[10px] font-label font-bold text-on-surface-variant border border-outline-variant/10">
                                SYLLABUS_ID: {{ $syllabus->id }}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-4 gap-4 py-6 border-y border-outline-variant/10">
                        <div class="space-y-1">
                            <span class="text-[10px] font-label uppercase text-on-surface-variant/60 tracking-widest">
                                Môn học
                            </span>
                            <p class="text-sm font-semibold font-display text-on-surface">
                                {{ $syllabus->course->course_code }} - {{ $syllabus->course->course_name }}
                            </p>
                        </div>

                        <div class="space-y-1">
                            <span class="text-[10px] font-label uppercase text-on-surface-variant/60 tracking-widest">
                                Chương trình
                            </span>
                            <p class="text-sm font-semibold font-display text-on-surface">
                                {{ $syllabus->course->program->name ?? 'N/A' }}
                            </p>
                        </div>

                        <div class="space-y-1">
                            <span class="text-[10px] font-label uppercase text-on-surface-variant/60 tracking-widest">
                                Khung
                            </span>
                            <p class="text-sm font-semibold font-display text-on-surface">
                                {{ $syllabus->template->template_name ?? 'N/A' }}
                            </p>
                        </div>

                        <div class="space-y-1">
                            <span class="text-[10px] font-label uppercase text-on-surface-variant/60 tracking-widest">
                                Năm học
                            </span>
                            <p class="text-sm font-semibold font-display text-on-surface">
                                {{ $syllabus->academic_year }}
                            </p>
                        </div>
                    </div>
                </header>

                @if(session('success'))
                    <div class="mb-6 p-4 bg-emerald-500/10 border-l-4 border-emerald-500 rounded-r-xl flex items-center gap-3">
                        <span class="material-symbols-outlined text-emerald-500">check_circle</span>
                        <p class="text-sm text-emerald-200">{{ session('success') }}</p>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 p-4 bg-error-container/20 border-l-4 border-error rounded-r-xl">
                        <div class="flex gap-3">
                            <span class="material-symbols-outlined text-error">error</span>
                            <div>
                                <p class="text-sm text-error font-semibold mb-2">Có lỗi xảy ra:</p>
                                <ul class="text-xs text-error/80 list-disc list-inside space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Structured AI editors: render cố định, không phụ thuộc section_code --}}
                syntax error, unexpected token "endforeach", expecting "elseif" or "else" or "endif"

                {{-- Template normal sections --}}
                <div class="space-y-12">
                    @foreach ($contents as $content)
                        @php
                            $section = $content->section;

                            $sectionCode = strtoupper(trim($section->section_code ?? ''));
                            $inputType = strtolower(trim($section->input_type ?? ''));

                            $isStructuredSection =
                                in_array($sectionCode, ['CO', 'CLO', 'TEACHING_PLAN'])
                                || in_array($inputType, [
                                    'structured_co',
                                    'structured_clo',
                                    'structured_teaching_plan'
                                ]);
                        @endphp

                        @if($isStructuredSection)
                            @continue
                        @endif

                        <section class="relative group">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="font-label text-sm font-bold tracking-widest uppercase flex items-center gap-2">
                                    <span class="w-2 h-2 bg-primary rounded-full"></span>
                                    {{ $section->display_order }}. {{ $section->title }}
                                </h3>
                            </div>

                            <div class="bg-surface-container-low rounded-xl p-8 border border-outline-variant/10 shadow-sm">
                                @if ($section->is_editable)
                                    <form method="POST" action="{{ route('lecturer.syllabuses.update', $syllabus->id) }}">
                                        @csrf
                                        @method('PUT')

                                        <textarea
                                            class="ckeditor"
                                            name="contents[{{ $content->id }}]"
                                            rows="8"
                                            style="width:100%;"
                                        >{{ old('contents.' . $content->id, $content->content_html) }}</textarea>

                                        <div class="mt-4 flex justify-end">
                                            <button type="submit" class="px-5 py-2 rounded-lg bg-primary-container text-on-primary-container font-label text-xs font-bold shadow-extruded hover:brightness-110 transition-all">
                                                Lưu mục này
                                            </button>
                                        </div>
                                    </form>
                                @else
                                    <div class="prose prose-invert max-w-none text-on-surface/90 leading-relaxed">
                                        {!! $content->content_html !!}
                                    </div>
                                @endif
                            </div>
                        </section>
                    @endforeach
                </div>
            </div>
        </div>

        <footer class="fixed bottom-0 right-0 w-[calc(100%-16rem)] h-20 bg-surface-container-lowest/90 backdrop-blur-md border-t border-outline-variant/20 px-12 flex items-center justify-between z-30">
            <div class="flex items-center gap-4">
                <span class="text-[10px] font-label text-on-surface-variant uppercase tracking-widest">
                    CO/CLO/Teaching Plan dùng AI. Các mục khác lưu từng section.
                </span>
            </div>

            <button type="submit" form="submit-form" class="bg-primary-container text-on-primary-container px-8 py-2.5 rounded-lg font-label text-sm font-bold shadow-extruded hover:brightness-110 transition-all flex items-center gap-3">
                Gửi duyệt đề cương
                <span class="material-symbols-outlined text-base">send</span>
            </button>
        </footer>
    </div>
</main>

<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.ckeditor').forEach(function (textarea) {
            ClassicEditor
                .create(textarea, {
                    toolbar: [
                        'heading',
                        'bold',
                        'italic',
                        'bulletedList',
                        'numberedList',
                        'blockQuote',
                        'link',
                        'undo',
                        'redo'
                    ]
                })
                .catch(error => console.error(error));
        });
    });
</script>
@endsection
