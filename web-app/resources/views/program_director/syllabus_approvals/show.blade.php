@extends('layouts.app')

@section('title', 'Chi tiết đề cương gửi duyệt | Syllabus Lab')

@section('content')
<!-- MAIN WORKBENCH -->
<main class="flex-1 overflow-y-auto relative p-6 pb-32">
    <!-- Breadcrumbs & Title -->
    <div class="mb-8">
        <nav class="flex items-center gap-2 text-[10px] font-label uppercase tracking-widest text-on-surface-variant mb-2">
            <a class="hover:text-primary transition-colors" href="{{ route('program-director.dashboard') }}">Orchestrator</a>
            <span class="material-symbols-outlined text-[10px]">chevron_right</span>
            <a class="hover:text-primary transition-colors" href="{{ route('program-director.syllabus-approvals.index') }}">Approvals</a>
            <span class="material-symbols-outlined text-[10px]">chevron_right</span>
            <span class="text-on-surface">Detail</span>
        </nav>
        <h2 class="text-3xl font-display font-bold tracking-tight text-on-surface">Chi tiết đề cương gửi duyệt</h2>
    </div>

    @php
        $version = $approval->version;
        $syllabus = $version->syllabus;
        $course = $syllabus->course;
    @endphp

    <div class="grid grid-cols-12 gap-6 items-start">
        <!-- Left: Meta Info & Content (8 cols) -->
        <div class="col-span-12 lg:col-span-8 space-y-6">
            <!-- Meta Info Card -->
            <section class="bg-surface-container-low rounded-xl p-6 border border-outline-variant/10 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 blur-3xl rounded-full"></div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 relative z-10">
                    <div>
                        <p class="text-[10px] font-label uppercase tracking-widest text-on-surface-variant mb-1">Môn học</p>
                        <p class="text-sm font-semibold text-on-surface leading-tight tracking-tight">{{ $course->course_code ?? '' }} - {{ $course->course_name ?? '' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-label uppercase tracking-widest text-on-surface-variant mb-1">Chương trình</p>
                        <p class="text-sm font-semibold text-on-surface leading-tight tracking-tight">{{ $course->program->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-label uppercase tracking-widest text-on-surface-variant mb-1">Version</p>
                        <p class="text-sm font-semibold text-primary leading-tight tracking-tight">v{{ $version->version_number }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-label uppercase tracking-widest text-on-surface-variant mb-1">Người gửi</p>
                        <p class="text-sm font-semibold text-on-surface leading-tight tracking-tight">{{ $version->creator->full_name ?? 'N/A' }}</p>
                    </div>
                </div>
            </section>

            <!-- Syllabus Tabs/Sections Navigation -->
            <div class="flex gap-4 border-b border-outline-variant/10 overflow-x-auto py-2">
                <button class="px-4 py-2 text-xs font-label uppercase tracking-widest text-primary border-b-2 border-primary whitespace-nowrap">Objectives (CO)</button>
                <button class="px-4 py-2 text-xs font-label uppercase tracking-widest text-on-surface-variant hover:text-on-surface transition-colors whitespace-nowrap">Learning Outcomes (CLO)</button>
                <button class="px-4 py-2 text-xs font-label uppercase tracking-widest text-on-surface-variant hover:text-on-surface transition-colors whitespace-nowrap">Teaching Plan</button>
                <button class="px-4 py-2 text-xs font-label uppercase tracking-widest text-on-surface-variant hover:text-on-surface transition-colors whitespace-nowrap">Full Content</button>
            </div>

            <!-- Course Objectives -->
            <section class="space-y-4">
                <h3 class="text-sm font-label uppercase tracking-[0.15em] text-on-surface-variant flex items-center gap-2">
                    <span class="w-1.5 h-1.5 bg-primary rounded-full"></span>
                    Course Objectives (CO)
                </h3>
                <div class="space-y-3">
                    @forelse($version->courseObjectives as $co)
                    <div class="bg-surface-container-lowest p-4 rounded-xl border-l-2 border-primary/40 flex gap-4 group hover:bg-surface-container-low transition-colors">
                        <span class="text-primary font-label font-bold text-xs shrink-0 mt-0.5">{{ $co->code }}</span>
                        <p class="text-sm text-on-surface/90 leading-relaxed tracking-tight">{{ $co->description }}</p>
                    </div>
                    @empty
                    <div class="bg-surface-container-lowest p-4 rounded-xl text-center text-on-surface-variant/60">
                        Không có CO.
                    </div>
                    @endforelse
                </div>
            </section>

            <!-- Course Learning Outcomes -->
            <section class="space-y-4">
                <h3 class="text-sm font-label uppercase tracking-[0.15em] text-on-surface-variant flex items-center gap-2">
                    <span class="w-1.5 h-1.5 bg-primary rounded-full"></span>
                    Course Learning Outcomes (CLO)
                </h3>
                <div class="grid gap-3">
                    @forelse($version->courseLearningOutcomes as $clo)
                    <div class="bg-surface-container p-4 rounded-xl flex items-start justify-between gap-6 group hover:translate-x-1 transition-transform border border-transparent hover:border-outline-variant/20">
                        <div class="flex gap-4">
                            <span class="text-secondary font-label font-bold text-xs shrink-0 mt-0.5">{{ $clo->code }}</span>
                            <p class="text-sm text-on-surface/90 leading-relaxed tracking-tight">{{ $clo->description }}</p>
                        </div>
                        <span class="px-2 py-0.5 bg-secondary-container/40 text-[10px] font-label uppercase text-on-secondary-container rounded-md shrink-0 border border-secondary-container/50">
                            Level: {{ $clo->bloom_level }}
                        </span>
                    </div>
                    @empty
                    <div class="bg-surface-container p-4 rounded-xl text-center text-on-surface-variant/60">
                        Không có CLO.
                    </div>
                    @endforelse
                </div>
            </section>

            <!-- Teaching Plan Table -->
            <section class="space-y-4">
                <h3 class="text-sm font-label uppercase tracking-[0.15em] text-on-surface-variant flex items-center gap-2">
                    <span class="w-1.5 h-1.5 bg-primary rounded-full"></span>
                    Teaching Plan
                </h3>
                <div class="overflow-x-auto bg-surface-container-lowest rounded-xl border border-outline-variant/10">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container border-b border-outline-variant/10">
                                <th class="p-4 text-[10px] font-label uppercase tracking-widest text-on-surface-variant">Week</th>
                                <th class="p-4 text-[10px] font-label uppercase tracking-widest text-on-surface-variant">Module &amp; Title</th>
                                <th class="p-4 text-[10px] font-label uppercase tracking-widest text-on-surface-variant">Activities &amp; CLO</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant/5">
                            @forelse($version->teachingPlanItems->sortBy('item_order') as $item)
                            <tr class="hover:bg-surface-container-low transition-colors">
                                <td class="p-4 align-top">
                                    <span class="font-label text-sm text-on-surface-variant">{{ str_pad($item->item_order, 2, '0', STR_PAD_LEFT) }}</span>
                                </td>
                                <td class="p-4 align-top max-w-[300px]">
                                    <p class="text-sm font-bold text-on-surface mb-1">{{ $item->title }}</p>
                                    <p class="text-xs text-on-surface-variant leading-relaxed">
                                        @foreach(($item->content ?? []) as $content)
                                            {{ $content }}
                                        @endforeach
                                    </p>
                                </td>
                                <td class="p-4 align-top">
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach(($item->teaching_activities ?? []) as $act)
                                        <span class="px-2 py-0.5 bg-surface-container-highest text-[10px] rounded-sm text-on-surface">{{ $act }}</span>
                                        @endforeach
                                        @foreach(($item->learning_activities ?? []) as $act)
                                        <span class="px-2 py-0.5 bg-surface-container-highest text-[10px] rounded-sm text-on-surface">{{ $act }}</span>
                                        @endforeach
                                        @foreach(($item->assessment_activities ?? []) as $act)
                                        <span class="px-2 py-0.5 bg-surface-container-highest text-[10px] rounded-sm text-on-surface">{{ $act }}</span>
                                        @endforeach
                                        @foreach($item->cloMappings as $mapping)
                                        <span class="px-2 py-0.5 bg-primary-container/20 text-[10px] rounded-sm text-primary font-bold">{{ $mapping->clo_code }}</span>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="p-4 text-center text-on-surface-variant/60">
                                    Không có kế hoạch giảng dạy.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Full Content Sections -->
            <section class="space-y-4">
                <h3 class="text-sm font-label uppercase tracking-[0.15em] text-on-surface-variant flex items-center gap-2">
                    <span class="w-1.5 h-1.5 bg-primary rounded-full"></span>
                    Nội dung các mục đề cương
                </h3>
                <div class="space-y-4">
                    @forelse($version->contents->sortBy(fn($c) => $c->section->display_order ?? 999) as $content)
                    <div class="bg-surface-container p-4 rounded-xl border border-outline-variant/10">
                        <h4 class="text-sm font-bold text-on-surface mb-3">
                            {{ $content->section->display_order ?? '' }}. {{ $content->section->title ?? '' }}
                        </h4>
                        <div class="text-sm text-on-surface/80 leading-relaxed prose prose-invert max-w-none">
                            {!! $content->content_html !!}
                        </div>
                    </div>
                    @empty
                    <div class="bg-surface-container p-4 rounded-xl text-center text-on-surface-variant/60">
                        Không có nội dung section.
                    </div>
                    @endforelse
                </div>
            </section>
        </div>

        <!-- Right: AI Intelligence Panel (4 cols) -->
        <aside class="col-span-12 lg:col-span-4 sticky top-6 space-y-6">
            @if(!empty($version->ai_change_summary))
            <div class="bg-surface-container-highest/30 backdrop-blur-md rounded-2xl border border-primary/20 p-6 relative overflow-hidden">
                <div class="absolute -top-20 -right-20 w-40 h-40 bg-primary/20 blur-[60px] animate-pulse"></div>
                <div class="absolute inset-0 border-l-4 border-primary"></div>
                <div class="flex items-center gap-3 mb-6">
                    <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">auto_awesome</span>
                    <h3 class="font-label text-label-md uppercase tracking-[0.2em] font-black text-primary">AI Intelligence Summary</h3>
                </div>
                <div class="space-y-6 relative z-10">
                    <!-- AI Summary Text -->
                    <div class="bg-surface-container-lowest/50 p-4 rounded-xl shadow-inset-deep">
                        <p class="text-xs text-on-surface leading-relaxed italic">
                            "{{ $version->ai_change_summary['summary'] ?? 'Không có tóm tắt' }}"
                        </p>
                    </div>

                    <!-- Important Changes -->
                    @if(!empty($version->ai_change_summary['important_changes']))
                    <div class="space-y-3">
                        <p class="text-[10px] font-label uppercase tracking-widest text-on-surface-variant">Significant Revisions</p>
                        <ul class="space-y-2">
                            @foreach($version->ai_change_summary['important_changes'] as $change)
                            <li class="flex gap-2 items-start">
                                <span class="material-symbols-outlined text-xs text-primary mt-1">check_circle</span>
                                <span class="text-xs text-on-surface/80 leading-tight">{{ $change }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <!-- Risk Notes -->
                    @if(!empty($version->ai_change_summary['risk_notes']))
                    <div class="bg-tertiary-container/10 border border-tertiary/20 p-4 rounded-xl">
                        <p class="text-[10px] font-label uppercase tracking-widest text-tertiary-fixed-dim mb-2 flex items-center gap-2">
                            <span class="material-symbols-outlined text-xs">warning</span> Risk Notes
                        </p>
                        @foreach($version->ai_change_summary['risk_notes'] as $risk)
                        <p class="text-xs text-tertiary/90 leading-relaxed mt-2">{{ $risk }}</p>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Faculty Attachment Info -->
            <div class="bg-surface-container-low border border-outline-variant/10 rounded-xl p-4">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-full overflow-hidden shrink-0 bg-primary/20 flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary text-2xl">person</span>
                    </div>
                    <div>
                        <p class="text-[10px] font-label uppercase tracking-widest text-on-surface-variant">Course Lead</p>
                        <p class="text-sm font-bold text-on-surface">{{ $version->creator->full_name ?? 'N/A' }}</p>
                    </div>
                </div>
                <button class="w-full py-2 bg-surface-container-highest/50 hover:bg-surface-container-highest text-xs font-label uppercase tracking-widest text-on-surface transition-all rounded-lg border border-outline-variant/20">
                    Chat with Lead
                </button>
            </div>
        </aside>
    </div>
</main>

<!-- STICKY ACTION BAR -->
<footer class="fixed bottom-0 right-0 left-0 md:left-72 bg-surface-container-low/95 backdrop-blur-xl border-t border-outline-variant/10 px-8 py-6 z-[60] flex flex-col gap-4">
    <form method="POST" action="{{ route('program-director.syllabus-approvals.reject', $approval->id) }}" class="flex flex-col md:flex-row gap-6 items-end md:items-center justify-between max-w-7xl mx-auto w-full">
        @csrf
        <div class="flex-1 w-full max-w-2xl group">
            <label class="block text-[10px] font-label uppercase tracking-[0.2em] text-on-surface-variant mb-2 px-1">Lý do từ chối (Optional for rejection)</label>
            <textarea name="comment" class="w-full bg-surface-container-lowest border border-outline-variant/20 rounded-xl px-4 py-3 text-sm focus:ring-1 focus:ring-primary shadow-inset-soft transition-all h-12 focus:h-24 resize-none" placeholder="Ghi chú phản hồi cho giảng viên..."></textarea>
        </div>
        <div class="flex items-center gap-4 shrink-0">
            <a href="{{ route('program-director.syllabus-approvals.index') }}" class="text-xs font-label uppercase tracking-widest text-on-surface-variant hover:text-on-surface transition-colors px-4">
                Quay lại danh sách
            </a>
            <button type="submit" class="px-8 py-3 bg-surface-container-highest text-on-surface hover:bg-surface-variant/40 transition-all rounded-xl text-xs font-label uppercase tracking-widest font-bold border border-outline-variant/20">
                Từ chối
            </button>
        </div>
    </form>

    <form method="POST" action="{{ route('program-director.syllabus-approvals.approve', $approval->id) }}" class="flex justify-end">
        @csrf
        <button type="submit" class="px-10 py-3 bg-primary text-on-primary hover:bg-primary-container transition-all rounded-xl text-xs font-label uppercase tracking-widest font-black shadow-extruded active:translate-y-[2px] active:shadow-none">
            Duyệt
        </button>
    </form>
</footer>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Interaction Feedback
        const buttons = document.querySelectorAll('button');
        buttons.forEach(btn => {
            btn.addEventListener('mousedown', () => {
                btn.classList.add('scale-[0.98]');
            });
            btn.addEventListener('mouseup', () => {
                btn.classList.remove('scale-[0.98]');
            });
            btn.addEventListener('mouseleave', () => {
                btn.classList.remove('scale-[0.98]');
            });
        });
    });
</script>
@endsection
