@extends('lecturer.app')

@section('title', 'Soạn đề cương | Syllabus Lab')

@section('content')
<!-- Main Content Area -->
<main class="ml-64 flex flex-col h-screen">
    <!-- TopAppBar (Shared Component) -->
    <header class="bg-[#131315]/80 backdrop-blur-xl border-b border-[#454652]/10 fixed top-0 right-0 w-[calc(100%-16rem)] z-30 flex justify-between items-center h-16 px-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('lecturer.dashboard') }}" class="text-on-surface-variant hover:text-primary transition-colors flex items-center gap-1 font-label text-xs uppercase tracking-widest">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                Quay lại dashboard
            </a>
            <div class="h-4 w-px bg-outline-variant/30"></div>
            <div class="flex items-center gap-4">
                <a class="text-[#e5e1e3]/70 hover:text-[#e5e1e3] font-['Inter'] text-[0.875rem] tracking-[-0.01em]" href="#">Drafts</a>
                <a class="text-[#e5e1e3]/70 hover:text-[#e5e1e3] font-['Inter'] text-[0.875rem] tracking-[-0.01em]" href="#">Revision History</a>
                <a class="text-[#e5e1e3]/70 hover:text-[#e5e1e3] font-['Inter'] text-[0.875rem] tracking-[-0.01em]" href="#">Peer Review</a>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <button class="bg-surface-container-highest text-on-surface px-4 py-1.5 rounded-lg font-label text-xs font-bold hover:bg-surface-bright transition-all border border-outline-variant/20 flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">biotech</span>
                Run AI Audit
            </button>
            <form method="POST" action="{{ route('lecturer.syllabuses.submit', $syllabus->id) }}" class="inline" id="submit-form">
                @csrf
                <button type="submit" class="bg-primary-container text-on-primary-container px-4 py-1.5 rounded-lg font-label text-xs font-bold shadow-extruded hover:brightness-110 transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">send</span>
                    Gửi duyệt đề cương
                </button>
            </form>
            <div class="h-8 w-8 rounded-full bg-primary-container flex items-center justify-center overflow-hidden border border-primary/30">
                <img alt="Academic Lead" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuApzP8rfoTC5Gn4jZLyI-ofzT5XZJaEr-FRAGmrg7ZEjeo8hLlDWgVop_rW043zZY0OHve-4WIZG16hsNMWUu85YiPWU5kn5kf7W2OHV3N5PPHBrgVcwVDFzlhQ_lSeRdcLBfdtcEWaS-p_bt2BIB_W2zu8C12WL2EDuTzOSO8tDfoFfyfMzpYjJluHRGCVAXYUrQVvXhGiy-YhqQyBNgFkQ-mzBcYiuu8Zmc241juwfB8s476Hu8TQbbjH6ExtH8XgW0xC9hIjJQaQ"/>
            </div>
        </div>
    </header>

    <!-- Editor Workspace -->
    <div class="mt-16 flex flex-1 overflow-hidden">
        <!-- Target Alignment Sidebar (Left-ish Inside) -->
        <aside class="w-80 bg-surface-container-lowest border-r border-outline-variant/10 p-6 overflow-y-auto flex flex-col gap-6">
            <div>
                <h3 class="font-label text-[10px] uppercase tracking-widest text-primary mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">target</span> Mục tiêu chuẩn đầu ra
                </h3>
                <div class="space-y-6">
                    <!-- PLO Section -->
                    <section>
                        <label class="font-label text-xs font-semibold text-on-surface-variant block mb-3">PLO mục tiêu</label>
                        <div class="space-y-2">
                            @forelse($syllabus->ploTargets as $target)
                            <div class="bg-surface-container p-3 rounded-lg border-l-2 border-primary-container group hover:bg-surface-container-high transition-colors">
                                <div class="flex justify-between items-start mb-1">
                                    <span class="text-[10px] font-label font-bold text-primary-fixed">{{ $target->programLearningOutcome->code ?? 'N/A' }}</span>
                                    <span class="material-symbols-outlined text-xs text-on-surface-variant opacity-0 group-hover:opacity-100 transition-opacity">info</span>
                                </div>
                                <p class="text-[11px] leading-relaxed text-on-surface/80">{{ $target->programLearningOutcome->description ?? 'Chưa có mô tả' }}</p>
                            </div>
                            @empty
                            <div class="bg-surface-container p-3 rounded-lg border-l-2 border-outline-variant/20">
                                <p class="text-[11px] leading-relaxed text-on-surface/50">Chưa có PLO mục tiêu.</p>
                            </div>
                            @endforelse
                        </div>
                    </section>

                    <!-- PI Section -->
                    <section>
                        <label class="font-label text-xs font-semibold text-on-surface-variant block mb-3">PI mục tiêu</label>
                        <div class="space-y-2">
                            @forelse($syllabus->piTargets as $target)
                            <div class="bg-surface-container p-3 rounded-lg border-l-2 border-tertiary group hover:bg-surface-container-high transition-colors">
                                <div class="flex justify-between items-start mb-1">
                                    <span class="text-[10px] font-label font-bold text-tertiary">{{ $target->performanceIndicator->code ?? 'N/A' }}</span>
                                </div>
                                <p class="text-[11px] leading-relaxed text-on-surface/80">{{ $target->performanceIndicator->description ?? 'Chưa có mô tả' }}</p>
                            </div>
                            @empty
                            <div class="bg-surface-container p-3 rounded-lg border-l-2 border-outline-variant/20">
                                <p class="text-[11px] leading-relaxed text-on-surface/50">Chưa có PI mục tiêu.</p>
                            </div>
                            @endforelse
                        </div>
                    </section>
                </div>
            </div>

            <!-- Orchestration Log (Bottom of side panel) -->
            <div class="mt-auto pt-6 border-t border-outline-variant/10">
                <div class="bg-[#0e0e0f] rounded-lg p-3 font-label text-[9px] text-[#5E6AD2] border border-[#5E6AD2]/20 shadow-inset-deep">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span>
                        <span class="uppercase font-bold">SYSTEM SYNC ACTIVE</span>
                    </div>
                    <div class="space-y-0.5 opacity-70">
                        <div>&gt; Updating CLO mapping nodes...</div>
                        <div>&gt; Auto-saving to master branch...</div>
                        <div>&gt; 0 errors | 2 notifications</div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Editor Canvas -->
        <div class="flex-1 overflow-y-auto bg-surface p-12">
            <div class="max-w-4xl mx-auto">
                <!-- Header Section -->
                <header class="mb-12">
                    <div class="flex items-end justify-between mb-2">
                        <h2 class="text-4xl font-bold tracking-tight font-display text-transparent bg-clip-text bg-gradient-to-r from-on-surface to-on-surface-variant">
                            Soạn đề cương
                        </h2>
                        <div class="flex gap-2">
                            <span class="bg-surface-container-highest px-3 py-1 rounded text-[10px] font-label font-bold text-primary-fixed border border-primary-container/20 tracking-tighter">VER 2.4.0-BETA</span>
                            <span class="bg-surface-container-high px-3 py-1 rounded text-[10px] font-label font-bold text-on-surface-variant border border-outline-variant/10 tracking-tighter">SYLLABUS_ID: {{ $syllabus->id }}</span>
                        </div>
                    </div>

                    <!-- Metadata Grid -->
                    <div class="grid grid-cols-4 gap-4 py-6 border-y border-outline-variant/10">
                        <div class="space-y-1">
                            <span class="text-[10px] font-label uppercase text-on-surface-variant/60 tracking-widest">Môn học</span>
                            <p class="text-sm font-semibold font-display text-on-surface">{{ $syllabus->course->course_code }} - {{ $syllabus->course->course_name }}</p>
                        </div>
                        <div class="space-y-1">
                            <span class="text-[10px] font-label uppercase text-on-surface-variant/60 tracking-widest">Chương trình</span>
                            <p class="text-sm font-semibold font-display text-on-surface">{{ $syllabus->course->program->name ?? 'N/A' }}</p>
                        </div>
                        <div class="space-y-1">
                            <span class="text-[10px] font-label uppercase text-on-surface-variant/60 tracking-widest">Khung</span>
                            <p class="text-sm font-semibold font-display text-on-surface">{{ $syllabus->template->template_name ?? 'N/A' }}</p>
                        </div>
                        <div class="space-y-1">
                            <span class="text-[10px] font-label uppercase text-on-surface-variant/60 tracking-widest">Năm học</span>
                            <p class="text-sm font-semibold font-display text-on-surface">{{ $syllabus->academic_year }}</p>
                        </div>
                    </div>
                </header>

                <!-- Session Alerts -->
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

                <!-- Main Form -->
                <form method="POST" action="{{ route('lecturer.syllabuses.update', $syllabus->id) }}" id="syllabus-form">
                    @csrf
                    @method('PUT')

                    <!-- Content Sections (Modular Editor) -->
                    <div class="space-y-12">
                        @foreach ($contents as $content)
                            @php
                                $section = $content->section;
                            @endphp

                            <section class="relative group">
                                <div class="absolute -left-8 top-1 opacity-0 group-hover:opacity-100 transition-opacity text-primary">
                                    <span class="material-symbols-outlined">drag_indicator</span>
                                </div>
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="font-label text-sm font-bold tracking-widest uppercase flex items-center gap-2">
                                        <span class="w-2 h-2 bg-primary rounded-full"></span>
                                        {{ $section->display_order }}. {{ $section->title }}
                                    </h3>
                                    @if($section->section_code === 'CLO')
                                    <button type="button" class="text-xs text-primary-fixed hover:underline font-label">Refresh Mapping</button>
                                    @endif
                                </div>

                                <div class="bg-surface-container-low rounded-xl p-8 border border-outline-variant/10 shadow-sm">
                                    @switch($section->section_code)
                                        @case('CO')
                                            @include('lecturer.syllabuses.partials.co_editor', ['syllabus' => $syllabus])
                                        @break

                                        @case('CLO')
                                            @include('lecturer.syllabuses.partials.clo_editor', ['syllabus' => $syllabus])
                                        @break

                                        @case('TEACHING_PLAN')
                                            @include('lecturer.syllabuses.partials.teaching_plan_editor', ['syllabus' => $syllabus])
                                        @break

                                        @default
                                            @if ($section->is_editable)
                                                <textarea class="ckeditor" name="contents[{{ $content->id }}]" rows="8" style="width:100%;">{{ old('contents.' . $content->id, $content->content_html) }}</textarea>
                                            @else
                                                <div class="prose prose-invert max-w-none text-on-surface/90 leading-relaxed">
                                                    {!! $content->content_html !!}
                                                </div>
                                            @endif
                                    @endswitch
                                </div>
                            </section>
                        @endforeach
                    </div>
                </form>
            </div>
        </div>

        <!-- Footer Action Bar (Contextual) -->
        <footer class="fixed bottom-0 right-0 w-[calc(100%-16rem)] h-20 bg-surface-container-lowest/90 backdrop-blur-md border-t border-outline-variant/20 px-12 flex items-center justify-between z-30">
            <div class="flex items-center gap-4">
                <span class="text-[10px] font-label text-on-surface-variant uppercase tracking-widest">Last synced 2m ago</span>
                <div class="h-4 w-px bg-outline-variant/30"></div>
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-green-500 shadow-[0_0_8px_rgba(34,197,94,0.5)]"></div>
                    <span class="text-[10px] font-label text-on-surface-variant">Production Master Online</span>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <button type="submit" form="syllabus-form" class="px-6 py-2.5 rounded-lg font-label text-sm font-bold text-on-surface-variant hover:bg-surface-container-high transition-all">
                    Lưu nháp nội dung đề cương
                </button>
                <button type="submit" form="submit-form" class="bg-primary-container text-on-primary-container px-8 py-2.5 rounded-lg font-label text-sm font-bold shadow-extruded hover:brightness-110 transition-all flex items-center gap-3">
                    Gửi duyệt đề cương
                    <span class="material-symbols-outlined text-base">send</span>
                </button>
            </div>
        </footer>
    </div>
</main>

<!-- Visual Polish: Ambient Light Blobs -->
<div class="fixed top-[-10%] right-[-5%] w-[400px] h-[400px] bg-primary-container opacity-[0.03] blur-[120px] pointer-events-none z-0"></div>
<div class="fixed bottom-[-10%] left-[20%] w-[300px] h-[300px] bg-secondary-container opacity-[0.03] blur-[100px] pointer-events-none z-0"></div>

<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
    // Initialize CKEditor for all textareas with .ckeditor class
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.ckeditor').forEach(function (textarea) {
            ClassicEditor
                .create(textarea, {
                    toolbar: ['heading', 'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote', 'link', 'undo', 'redo']
                })
                .catch(error => console.error(error));
        });
    });

    // Micro-interaction for spotlight effect on cards
    document.querySelectorAll('section > div.bg-surface-container-low').forEach(card => {
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            card.style.background = `radial-gradient(400px circle at ${x}px ${y}px, rgba(94, 106, 210, 0.05), transparent), #1c1b1d`;
        });
        card.addEventListener('mouseleave', () => {
            card.style.background = '#1c1b1d';
        });
    });
</script>
@endsection
