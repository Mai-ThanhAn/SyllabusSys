@extends('layouts.lecturer')

@section('title', 'Soạn đề cương | Syllabus_System')

@section('content')
    <!-- Header -->
    <header
        class="bg-surface/80 backdrop-blur-xl border-b border-outline-variant/10 fixed top-0 right-0 w-[calc(100%-16rem)] z-30 flex justify-between items-center h-16 px-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('lecturer.dashboard') }}"
                class="text-on-surface-variant hover:text-primary transition-colors flex items-center gap-1 font-label text-xs uppercase tracking-widest">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                Quay lại dashboard
            </a>
            <div class="h-4 w-px bg-outline-variant/20"></div>
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-sm text-primary">description</span>
                <span class="text-xs text-on-surface-variant">Soạn thảo đề cương</span>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <div
                class="flex items-center gap-2 px-3 py-1.5 bg-surface-container-lowest rounded-full border border-outline-variant/10">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="text-[10px] font-label text-on-surface-variant">Auto-save enabled</span>
            </div>
            <form method="POST" action="{{ route('lecturer.syllabuses.submit', $syllabus->id) }}" id="submit-form">
                @csrf
                <button type="submit"
                    class="bg-primary-container text-on-primary-container px-4 py-1.5 rounded-lg font-label text-xs font-bold shadow-extruded hover:brightness-110 transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">send</span>
                    Gửi duyệt
                </button>
            </form>
        </div>
    </header>

    <div class="mt-16 flex flex-1 overflow-hidden">
        <!-- SIDEBAR -->
        <aside class="w-80 bg-surface-container-lowest border-r border-outline-variant/10 flex flex-col overflow-y-auto">
            <!-- Sidebar Header -->
            <div class="p-5 border-b border-outline-variant/10">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-lg">format_list_bulleted</span>
                    <h3 class="font-label text-xs uppercase tracking-widest text-primary">Mục lục đề cương</h3>
                </div>
                <p class="text-[10px] text-on-surface-variant/50 mt-1">Click để điều hướng nhanh</p>
            </div>

            <!-- Navigation Links -->
            <div class="flex-1 overflow-y-auto p-4">
                <nav class="space-y-1">
                    @foreach ($contents as $content)
                        <a href="#section-{{ $content->section->id }}" data-section-id="{{ $content->section->id }}"
                            class="toc-link flex items-center gap-2 px-3 py-2 rounded-lg text-xs text-on-surface-variant hover:bg-surface-container hover:text-primary transition-all group">
                            <span
                                class="w-5 h-5 rounded flex items-center justify-center bg-surface-container-high text-[10px] font-bold text-primary group-hover:bg-primary/20">
                                {{ $content->section->display_order }}
                            </span>
                            <span class="flex-1 truncate">{{ $content->section->title }}</span>
                            @if (in_array(strtoupper(trim($content->section->section_code ?? '')), [
                                    'COURSE_OBJECTIVES',
                                    'COURSE_LEARNING_OUTCOMES',
                                    'TEACHING_PLAN',
                                ]))
                                <span class="text-[8px] text-primary/50 uppercase">AI</span>
                            @endif
                        </a>
                    @endforeach
                </nav>
            </div>

            <!-- Sidebar Footer: Progress -->
            <div class="p-5 border-t border-outline-variant/10 bg-surface-container/20">
                <div class="flex justify-between text-[10px] text-on-surface-variant/60 mb-2">
                    <span>Tiến độ soạn thảo</span>
                    <span id="progress-percent" class="text-primary font-bold">0%</span>
                </div>
                <div class="w-full bg-surface-container-highest rounded-full h-1.5 overflow-hidden">
                    <div id="progress-bar" class="bg-primary h-full rounded-full transition-all duration-500"
                        style="width: 0%"></div>
                </div>
                <div class="mt-3 flex items-center gap-2 text-[10px] text-on-surface-variant/40">
                    <span class="material-symbols-outlined text-xs">info</span>
                    <span>Lưu từng section để cập nhật tiến độ</span>
                </div>
            </div>
        </aside>

        <!-- CONTENT AREA -->
        <div class="flex-1 overflow-y-auto bg-surface">
            <div class="max-w-4xl mx-auto py-10 px-8">
                <!-- Header Info Card -->
                <div
                    class="mb-10 bg-gradient-to-r from-primary-container/5 to-transparent rounded-2xl p-6 border border-outline-variant/10">
                    <div class="flex items-start justify-between">
                        <div>
                            <div class="flex items-center gap-2 mb-3">
                                <span class="material-symbols-outlined text-primary text-lg">school</span>
                                <h2 class="text-2xl font-bold tracking-tight text-on-surface">
                                    {{ $syllabus->course->course_name }}
                                </h2>
                            </div>
                            <div class="flex flex-wrap gap-4 text-sm text-on-surface-variant">
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-xs">fingerprint</span>
                                    <span>{{ $syllabus->course->course_code }}</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-xs">account_balance</span>
                                    <span>{{ $syllabus->course->program->name ?? 'N/A' }}</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-xs">calendar_today</span>
                                    <span>{{ $syllabus->academic_year }}</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-xs">style</span>
                                    <span>{{ $syllabus->template->template_name ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="bg-surface-container-highest/50 px-3 py-1.5 rounded-lg text-center">
                            <div class="text-[10px] text-on-surface-variant/60">Syllabus ID</div>
                            <div class="text-xs font-mono text-primary">#{{ $syllabus->id }}</div>
                        </div>
                    </div>
                </div>

                <!-- Alerts -->
                @if (session('success'))
                    <div
                        class="mb-6 p-4 bg-emerald-500/10 border-l-4 border-emerald-500 rounded-r-xl flex items-center gap-3 animate-in fade-in slide-in-from-top-4 duration-300">
                        <span class="material-symbols-outlined text-emerald-500">check_circle</span>
                        <p class="text-sm text-emerald-200">{{ session('success') }}</p>
                        <button class="ml-auto text-emerald-500/60 hover:text-emerald-300"
                            onclick="this.closest('.mb-6').remove()">
                            <span class="material-symbols-outlined text-sm">close</span>
                        </button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-error-container/15 border-l-4 border-error rounded-r-xl">
                        <div class="flex gap-3">
                            <span class="material-symbols-outlined text-error">error</span>
                            <div class="flex-1">
                                <p class="text-sm text-error font-semibold mb-2">Có lỗi xảy ra:</p>
                                <ul class="text-xs text-error/80 list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Các section đề cương -->
                <div class="space-y-10">
                    @foreach ($contents as $content)
                        @php
                            $section = $content->section;

                            $sectionCode = strtoupper(trim($section->section_code ?? ''));

                            $aiSections = ['COURSE_OBJECTIVES', 'COURSE_LEARNING_OUTCOMES', 'TEACHING_PLAN'];

                            $structuredSections = ['COURSE_INFO', 'COURSE_DESCRIPTION'];

                            $isAISection = in_array($sectionCode, $aiSections);

                            $isStructuredSection = in_array($sectionCode, $structuredSections);
                        @endphp

                        <section id="section-{{ $section->id }}" class="scroll-mt-24"
                            data-section-id="{{ $section->id }}">
                            <!-- Section Header -->
                            <div class="flex items-center justify-between mb-4 pb-2 border-b border-outline-variant/10">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center">
                                        <span class="text-sm font-bold text-primary">{{ $section->display_order }}</span>
                                    </div>
                                    <h3 class="text-lg font-semibold text-on-surface">{{ $section->title }}</h3>
                                </div>
                                @if ($isAISection && $section->is_ai_generatable)
                                    <span
                                        class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-primary/10 text-primary text-[9px] font-semibold">
                                        <span class="material-symbols-outlined text-xs">auto_awesome</span>
                                        AI Enabled
                                    </span>
                                @endif
                            </div>

                            <!-- Section Content -->
                            <div
                                class="bg-surface-container-low/30 rounded-xl border border-outline-variant/10 overflow-hidden">
                                <div class="p-6">
                                    @if ($sectionCode === 'COURSE_INFO')
                                        @php
                                            $info = $content->content_raw['data'] ?? [];
                                        @endphp

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div
                                                class="p-4 rounded-xl bg-surface-container-lowest border border-outline-variant/10">
                                                <p class="text-[10px] uppercase tracking-widest text-on-surface-variant">Tên
                                                    học phần</p>
                                                <p class="text-sm font-semibold text-on-surface">
                                                    {{ $info['course_name'] ?? '—' }}</p>
                                            </div>

                                            <div
                                                class="p-4 rounded-xl bg-surface-container-lowest border border-outline-variant/10">
                                                <p class="text-[10px] uppercase tracking-widest text-on-surface-variant">Tên
                                                    tiếng Anh</p>
                                                <p class="text-sm font-semibold text-on-surface">
                                                    {{ $info['english_name'] ?? '—' }}</p>
                                            </div>

                                            <div
                                                class="p-4 rounded-xl bg-surface-container-lowest border border-outline-variant/10">
                                                <p class="text-[10px] uppercase tracking-widest text-on-surface-variant">Mã
                                                    học phần</p>
                                                <p class="text-sm font-semibold text-primary">
                                                    {{ $info['course_code'] ?? '—' }}</p>
                                            </div>

                                            <div
                                                class="p-4 rounded-xl bg-surface-container-lowest border border-outline-variant/10">
                                                <p class="text-[10px] uppercase tracking-widest text-on-surface-variant">
                                                    E-learning</p>
                                                <p class="text-sm font-semibold text-on-surface">
                                                    {{ $info['e_learning'] ?? '—' }}</p>
                                            </div>

                                            <div
                                                class="p-4 rounded-xl bg-surface-container-lowest border border-outline-variant/10">
                                                <p class="text-[10px] uppercase tracking-widest text-on-surface-variant">Số
                                                    tín chỉ</p>
                                                <p class="text-sm font-semibold text-on-surface">
                                                    {{ $info['credits'] ?? '—' }}</p>
                                            </div>

                                            <div
                                                class="p-4 rounded-xl bg-surface-container-lowest border border-outline-variant/10">
                                                <p class="text-[10px] uppercase tracking-widest text-on-surface-variant">Lý
                                                    thuyết / Thực hành</p>
                                                <p class="text-sm font-semibold text-on-surface">
                                                    {{ $info['theory_hours'] ?? 0 }} / {{ $info['practice_hours'] ?? 0 }}
                                                    tiết
                                                </p>
                                            </div>

                                            <div
                                                class="p-4 rounded-xl bg-surface-container-lowest border border-outline-variant/10">
                                                <p class="text-[10px] uppercase tracking-widest text-on-surface-variant">Tự
                                                    học</p>
                                                <p class="text-sm font-semibold text-on-surface">
                                                    {{ $info['self_study_hours'] ?? '—' }} tiết</p>
                                            </div>

                                            <div
                                                class="p-4 rounded-xl bg-surface-container-lowest border border-outline-variant/10">
                                                <p class="text-[10px] uppercase tracking-widest text-on-surface-variant">
                                                    Song hành</p>
                                                <p class="text-sm font-semibold text-on-surface">
                                                    {{ $info['parallel_course'] ?? 'Không' }}</p>
                                            </div>

                                            <div
                                                class="md:col-span-2 p-4 rounded-xl bg-surface-container-lowest border border-outline-variant/10">
                                                <p class="text-[10px] uppercase tracking-widest text-on-surface-variant">
                                                    Học phần tiên quyết</p>
                                                <p class="text-sm text-on-surface">{{ $info['prerequisite'] ?? 'Không' }}
                                                </p>
                                            </div>

                                            <div
                                                class="md:col-span-2 p-4 rounded-xl bg-surface-container-lowest border border-outline-variant/10">
                                                <p class="text-[10px] uppercase tracking-widest text-on-surface-variant">
                                                    Học phần học trước</p>
                                                <p class="text-sm text-on-surface">
                                                    {{ $info['previous_course'] ?? 'Không' }}</p>
                                            </div>
                                        </div>
                                    @elseif ($sectionCode === 'COURSE_DESCRIPTION')
                                        @php
                                            $desc =
                                                $content->content_raw['data']['description'] ??
                                                strip_tags($content->content_html ?? '');
                                        @endphp

                                        <div
                                            class="p-5 rounded-xl bg-surface-container-lowest border border-outline-variant/10">
                                            <p class="text-sm text-on-surface/90 leading-7">
                                                {{ $desc ?: 'Chưa có mô tả học phần.' }}
                                            </p>
                                        </div>
                                    @elseif ($sectionCode === 'COURSE_OBJECTIVES')
                                        @include('lecturer.syllabuses.partials.co_editor', [
                                            'syllabus' => $syllabus,
                                        ])
                                    @elseif($sectionCode === 'COURSE_LEARNING_OUTCOMES')
                                        @include('lecturer.syllabuses.partials.clo_editor', [
                                            'syllabus' => $syllabus,
                                        ])
                                    @elseif($sectionCode === 'TEACHING_PLAN')
                                        @include('lecturer.syllabuses.partials.teaching_plan_editor', [
                                            'syllabus' => $syllabus,
                                        ])
                                    @else
                                        <form method="POST"
                                            action="{{ route('lecturer.syllabuses.update', $syllabus->id) }}"
                                            class="space-y-4">
                                            @csrf
                                            @method('PUT')
                                            <textarea class="ckeditor" name="contents[{{ $content->id }}]" rows="10">{{ old('contents.' . $content->id, $content->content_html) }}</textarea>
                                            <div class="flex justify-end pt-2">
                                                <button type="submit"
                                                    class="px-5 py-2 rounded-lg bg-surface-container-highest hover:bg-primary-container text-on-surface hover:text-on-primary-container transition-all duration-200 font-label text-xs font-medium flex items-center gap-2">
                                                    <span class="material-symbols-outlined text-sm">save</span>
                                                    Lưu mục này
                                                </button>
                                            </div>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </section>
                    @endforeach
                </div>

                <!-- Footer Spacer -->
                <div class="h-8"></div>
            </div>
        </div>
    </div>

    <!-- Bottom Floating Action Bar -->
    <div class="fixed bottom-6 right-8 z-40">
        <button type="submit" form="submit-form"
            class="bg-gradient-to-r from-primary to-primary-container text-white px-6 py-3 rounded-xl font-label text-sm font-bold shadow-2xl hover:scale-105 active:scale-95 transition-all flex items-center gap-3">
            <span class="material-symbols-outlined text-base">send</span>
            Gửi duyệt đề cương
        </button>
    </div>

    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // ==================== CKEDITOR ====================
        document.querySelectorAll('.ckeditor').forEach(function(textarea) {
            ClassicEditor
                .create(textarea, {
                    toolbar: {
                        items: [
                            'heading', '|',
                            'bold', 'italic', 'underline', '|',
                            'bulletedList', 'numberedList', '|',
                            'insertTable', '|',
                            'blockQuote', 'link', '|',
                            'undo', 'redo'
                        ],
                        shouldNotGroupWhenFull: true
                    },
                    table: {
                        contentToolbar: [
                            'tableColumn',
                            'tableRow',
                            'mergeTableCells',
                            'tableProperties',
                            'tableCellProperties'
                        ]
                    },
                    heading: {
                        options: [
                            { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                            { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                            { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                            { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' }
                        ]
                    }
                })
                .then(editor => {
                    // Auto-save indicator
                    editor.model.document.on('change:data', () => {
                        const saveBtn = editor.sourceElement.closest('form')?.querySelector('button[type="submit"]');
                        if (saveBtn) {
                            saveBtn.classList.add('animate-pulse');
                            setTimeout(() => saveBtn.classList.remove('animate-pulse'), 500);
                        }
                    });
                })
                .catch(error => console.error(error));
        });

        // ==================== MỤC LỤC ====================
        const tocLinks = document.querySelectorAll('.toc-link');
        const sections = document.querySelectorAll('[data-section-id]');

        function updateActiveLink() {
            let current = '';
            const viewportMid = window.scrollY + 150;

            sections.forEach(section => {
                const rect = section.getBoundingClientRect();
                const sectionTop = rect.top + window.scrollY;
                const sectionBottom = sectionTop + rect.height;

                if (viewportMid >= sectionTop && viewportMid < sectionBottom) {
                    current = section.getAttribute('data-section-id');
                }
            });

            tocLinks.forEach(link => {
                const linkSectionId = link.getAttribute('data-section-id');
                if (linkSectionId === current) {
                    link.classList.add('bg-primary/15', 'text-primary', 'border-l-2', 'border-primary');
                    link.classList.remove('text-on-surface-variant');
                } else {
                    link.classList.remove('bg-primary/15', 'text-primary', 'border-l-2', 'border-primary');
                    link.classList.add('text-on-surface-variant');
                }
            });
        }

        tocLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    targetElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    setTimeout(updateActiveLink, 300);
                }
            });
        });

        window.addEventListener('scroll', updateActiveLink);
        updateActiveLink();

        // ==================== PROGRESS TRACKING ====================
        function updateProgress() {
            const allSections = document.querySelectorAll('[data-section-id]');
            let completedCount = 0;

            allSections.forEach(section => {
                const form = section.querySelector('form');
                const textarea = section.querySelector('textarea.ckeditor');

                if (form && textarea && textarea.value.trim().length > 100) {
                    completedCount++;
                } else if (!form) {
                    const hasContent = section.querySelector('.co-item, .clo-item, .plan-item') ||
                        (section.querySelectorAll('input, textarea').length > 0);
                    if (hasContent) completedCount++;
                }
            });

            const percent = allSections.length > 0 ? Math.round((completedCount / allSections.length) * 100) : 0;
            const progressBar = document.getElementById('progress-bar');
            const progressPercent = document.getElementById('progress-percent');

            if (progressBar && progressPercent) {
                progressBar.style.width = percent + '%';
                progressPercent.textContent = percent + '%';
            }
        }

        setTimeout(updateProgress, 500);
    });
</script>

    <style>
        .scroll-mt-24 {
            scroll-margin-top: 90px;
        }
        .ck-editor__editable {
            min-height: 250px;
            background-color: #1c1b1d !important;
            color: #e5e1e3 !important;
            border-color: rgba(69, 70, 82, 0.2) !important;
        }

        .ck.ck-toolbar {
            background-color: #2a2a2b !important;
            border-color: rgba(69, 70, 82, 0.2) !important;
        }

        .ck.ck-button,
        .ck.ck-button.ck-on {
            color: #e5e1e3 !important;
            background: transparent !important;
        }

        .ck.ck-button:hover {
            background: #353436 !important;
        }

        .ck.ck-dropdown__panel {
            background-color: #2a2a2b !important;
            border-color: rgba(69, 70, 82, 0.2) !important;
        }

        .ck.ck-list__item {
            color: #e5e1e3 !important;
        }

        .ck.ck-list__item:hover {
            background-color: #353436 !important;
        }

        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-in {
            animation: fade-in 0.3s ease-out;
        }
    </style>
@endsection
