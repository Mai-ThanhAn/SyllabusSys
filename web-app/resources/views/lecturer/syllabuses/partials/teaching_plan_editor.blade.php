@extends('layouts.lecturer')

@section('title', 'Kế hoạch Giảng dạy | Syllabus Lab')

@section('content')
<!-- Main Content Canvas -->
<main class="ml-64 pt-24 pb-12 px-8 relative z-10">
    <!-- Header Section -->
    <section class="mb-10">
        <div class="flex items-baseline justify-between">
            <div>
                <span class="font-label text-[10px] uppercase tracking-[0.2em] text-primary-container font-bold mb-2 block">Management System v4.0</span>
                <h1 class="text-4xl font-display font-bold tracking-tight text-on-surface">Kế hoạch Giảng dạy</h1>
                <p class="text-on-surface/60 mt-2 max-w-2xl font-light">
                    Cấu trúc chi tiết các buổi học, hoạt động đào tạo và phương pháp đánh giá định kỳ cho học phần
                    <span class="text-primary-fixed">{{ $syllabus->course->course_name ?? 'Course' }}</span>.
                </p>
            </div>
            <div class="flex flex-col items-end gap-2">
                <div class="flex items-center gap-2 bg-surface-container-low px-3 py-1.5 rounded-full border border-outline-variant/10">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 ambient-glow"></span>
                    <span class="font-label text-[10px] font-medium tracking-wider text-emerald-400">STATUS: OPTIMAL SEQUENCE</span>
                </div>
                <div class="text-[10px] font-label text-on-surface/40">LAST SYNCHRONIZED: 12 MINS AGO</div>
            </div>
        </div>
    </section>

    <!-- AI Orchestration Console (Workbench) -->
    <section class="mb-12 relative">
        <div class="absolute -inset-1 bg-gradient-to-r from-primary-container/20 via-transparent to-primary-container/20 rounded-2xl blur-xl opacity-30"></div>
        <div class="relative glass-panel rounded-2xl border border-outline-variant/20 overflow-hidden shadow-2xl">
            <!-- Console Header -->
            <div class="p-6 border-b border-outline-variant/10 flex items-center justify-between bg-surface-container/30">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-primary-container/20 rounded-xl">
                        <span class="material-symbols-outlined text-primary-container" style="font-variation-settings: 'FILL' 1;">auto_awesome</span>
                    </div>
                    <div>
                        <h3 class="font-label text-sm font-bold tracking-wide">AI SYNTHESIS WORKBENCH</h3>
                        <p class="text-xs text-on-surface/50">Phát sinh kế hoạch tự động dựa trên Đề cương chi tiết (CLOs)</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('lecturer.syllabuses.ai.generateTeachingPlan', $syllabus->id) }}">
                    @csrf
                    <button type="submit" class="bg-primary-container text-white px-6 py-2.5 rounded-xl text-sm font-bold flex items-center gap-3 hover:scale-[1.02] active:scale-[0.98] transition-all shadow-[0_0_20px_rgba(94,106,210,0.4)]">
                        Initialize AI Plan Generation
                        <span class="material-symbols-outlined text-lg">electric_bolt</span>
                    </button>
                </form>
            </div>

            <!-- Active AI Result Panel -->
            @if (session('ai_result_teaching_plan'))
                @php($aiPlan = session('ai_result_teaching_plan'))
                <div class="p-8">
                    <div class="grid grid-cols-12 gap-8">
                        <!-- Technical Summary (Left Column) -->
                        <div class="col-span-12 lg:col-span-3 space-y-6">
                            <div class="bg-surface-container-lowest neumorphic-inset p-5 rounded-2xl border border-outline-variant/5">
                                <div class="flex justify-between items-center mb-4">
                                    <span class="font-label text-[10px] text-on-surface/40 font-bold uppercase tracking-widest">Verification Score</span>
                                    <span class="material-symbols-outlined text-primary text-sm">verified_user</span>
                                </div>
                                <div class="flex items-baseline gap-1">
                                    <span class="text-5xl font-display font-bold text-primary">{{ $aiPlan['verification']['final_score'] ?? 'N/A' }}</span>
                                    <span class="text-on-surface/40 text-sm font-medium">/100</span>
                                </div>
                                <div class="mt-4 h-1 w-full bg-surface-container-high rounded-full overflow-hidden">
                                    <div class="h-full bg-primary-container w-[{{ $aiPlan['verification']['final_score'] ?? 0 }}%] shadow-[0_0_8px_rgba(94,106,210,0.8)]"></div>
                                </div>
                                <div class="mt-4">
                                    <span class="text-xs font-label text-emerald-400 uppercase tracking-wider">{{ $aiPlan['verification']['status'] ?? 'Optimal Alignment' }}</span>
                                </div>
                            </div>
                            <div class="bg-surface-container-lowest/50 p-5 rounded-2xl border-l-2 border-primary-container">
                                <h4 class="font-label text-[10px] font-bold text-on-surface/50 uppercase tracking-widest mb-3">Model Logic Logs</h4>
                                <ul class="space-y-3">
                                    <li class="flex gap-2 text-[11px] leading-relaxed">
                                        <span class="text-primary font-bold">»</span>
                                        <span>Mapped {{ count($aiPlan['generated_data'] ?? []) }} weeks to learning blocks.</span>
                                    </li>
                                    <li class="flex gap-2 text-[11px] leading-relaxed">
                                        <span class="text-primary font-bold">»</span>
                                        <span>Injected Assessment Checkpoints based on CLOs.</span>
                                    </li>
                                    <li class="flex gap-2 text-[11px] leading-relaxed">
                                        <span class="text-primary font-bold">»</span>
                                        <span>Optimized Lab:Lecture ratio to 40:60.</span>
                                    </li>
                                </ul>
                            </div>

                            @if (!empty($aiPlan['verification']['warnings']))
                            <div class="bg-error-container/10 p-4 rounded-xl border border-error-container/20 flex gap-3">
                                <span class="material-symbols-outlined text-error text-lg shrink-0">warning</span>
                                <div class="space-y-1">
                                    @foreach ($aiPlan['verification']['warnings'] as $warning)
                                    <p class="text-[11px] text-on-error-container/80 leading-snug italic">• {{ $warning }}</p>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Preview Grid (Right Column) -->
                        <div class="col-span-12 lg:col-span-9 space-y-4">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="font-label text-xs font-bold text-on-surface/40 uppercase tracking-widest">Proposed Sequence Preview (First 2 Weeks)</h4>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach (array_slice($aiPlan['generated_data'] ?? [], 0, 2) as $item)
                                <div class="bg-surface-container-high/40 p-5 rounded-2xl border border-outline-variant/10 relative group hover:border-primary-container/40 transition-all">
                                    <div class="absolute top-4 right-4 font-label text-xl font-black text-on-surface/5 italic">W{{ str_pad($item['order'], 2, '0', STR_PAD_LEFT) }}</div>
                                    <h5 class="font-label text-sm font-bold text-primary mb-2">{{ $item['title'] }}</h5>
                                    <div class="space-y-4">
                                        <div class="flex flex-wrap gap-1.5">
                                            @foreach($item['mapped_clo'] ?? [] as $clo)
                                            <span class="bg-secondary-container/30 text-on-secondary-container px-2 py-0.5 rounded text-[10px] font-bold font-label">{{ $clo }}</span>
                                            @endforeach
                                        </div>
                                        <p class="text-[11px] text-on-surface/60 line-clamp-2">
                                            @foreach($item['content'] ?? [] as $content)
                                                {{ $content }}
                                            @endforeach
                                        </p>
                                        <div class="flex items-center gap-4 text-[10px] text-on-surface/40 font-medium">
                                            @foreach($item['teaching_activities'] ?? [] as $act)
                                            <div class="flex items-center gap-1"><span class="material-symbols-outlined text-xs">school</span> {{ $act }}</div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <div class="pt-6 mt-6 border-t border-outline-variant/10 flex justify-end gap-3">
                                <form method="POST" action="{{ route('lecturer.syllabuses.ai.acceptTeachingPlan', $syllabus->id) }}">
                                    @csrf
                                    @foreach ($aiPlan['generated_data'] as $i => $item)
                                        <input type="hidden" name="teaching_plan[{{ $i }}][order]" value="{{ $item['order'] }}">
                                        <input type="hidden" name="teaching_plan[{{ $i }}][title]" value="{{ $item['title'] }}">
                                        @foreach ($item['content'] ?? [] as $j => $content)
                                            <input type="hidden" name="teaching_plan[{{ $i }}][content][{{ $j }}]" value="{{ $content }}">
                                        @endforeach
                                        @foreach ($item['teaching_activities'] ?? [] as $j => $act)
                                            <input type="hidden" name="teaching_plan[{{ $i }}][teaching_activities][{{ $j }}]" value="{{ $act }}">
                                        @endforeach
                                        @foreach ($item['learning_activities'] ?? [] as $j => $act)
                                            <input type="hidden" name="teaching_plan[{{ $i }}][learning_activities][{{ $j }}]" value="{{ $act }}">
                                        @endforeach
                                        @foreach ($item['assessment_activities'] ?? [] as $j => $act)
                                            <input type="hidden" name="teaching_plan[{{ $i }}][assessment_activities][{{ $j }}]" value="{{ $act }}">
                                        @endforeach
                                        @foreach ($item['mapped_clo'] ?? [] as $j => $clo)
                                            <input type="hidden" name="teaching_plan[{{ $i }}][mapped_clo][{{ $j }}]" value="{{ $clo }}">
                                        @endforeach
                                    @endforeach
                                    <button type="submit" class="px-8 py-2 bg-white text-surface-container-lowest rounded-xl text-xs font-bold hover:bg-on-surface transition-all">Accept Plan &amp; Commit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- Saved Teaching Plan List (Table/Grid) -->
    <section>
        <div class="flex items-center justify-between mb-8">
            <h2 class="font-label text-lg font-bold tracking-tight text-on-surface/80">Kế hoạch đã lưu trữ</h2>
            <div class="flex items-center gap-3">
                <button class="p-2 bg-surface-container rounded-lg border border-outline-variant/10 hover:border-primary-container transition-all">
                    <span class="material-symbols-outlined text-sm">filter_list</span>
                </button>
                <button class="p-2 bg-surface-container rounded-lg border border-outline-variant/10 hover:border-primary-container transition-all">
                    <span class="material-symbols-outlined text-sm">download</span>
                </button>
            </div>
        </div>

        @if ($syllabus->teachingPlanItems->count())
            <div class="space-y-4">
                <!-- Table Header Mockup -->
                <div class="grid grid-cols-12 px-6 py-3 text-[10px] font-label font-bold text-on-surface/30 uppercase tracking-[0.15em]">
                    <div class="col-span-1">Tuần</div>
                    <div class="col-span-4">Chủ đề &amp; Nội dung</div>
                    <div class="col-span-4">Hoạt động (Dạy/Học/ĐG)</div>
                    <div class="col-span-2">Chuẩn đầu ra (CLOs)</div>
                    <div class="col-span-1 text-right">Tác vụ</div>
                </div>

                @foreach ($syllabus->teachingPlanItems->sortBy('item_order') as $item)
                <div class="grid grid-cols-12 items-center px-6 py-5 bg-surface-container/20 rounded-2xl border border-outline-variant/5 hover:bg-surface-container/40 transition-all group">
                    <div class="col-span-1">
                        <div class="w-10 h-10 rounded-full bg-surface-container-low flex items-center justify-center font-label font-bold text-primary group-hover:scale-110 transition-transform">
                            {{ str_pad($item->item_order, 2, '0', STR_PAD_LEFT) }}
                        </div>
                    </div>
                    <div class="col-span-4 pr-6">
                        <h4 class="font-semibold text-sm mb-1">{{ $item->title }}</h4>
                        <p class="text-[11px] text-on-surface/50 line-clamp-1">
                            @foreach($item->content ?? [] as $content)
                                {{ $content }}
                            @endforeach
                        </p>
                    </div>
                    <div class="col-span-4">
                        <div class="flex flex-wrap items-center gap-6">
                            @foreach($item->teaching_activities ?? [] as $act)
                            <div class="flex items-center gap-2" title="Giảng dạy">
                                <span class="material-symbols-outlined text-primary-container text-lg">school</span>
                                <span class="text-[11px] font-medium text-on-surface/70">{{ $act }}</span>
                            </div>
                            @endforeach
                            @foreach($item->learning_activities ?? [] as $act)
                            <div class="flex items-center gap-2" title="Học tập">
                                <span class="material-symbols-outlined text-secondary text-lg">groups</span>
                                <span class="text-[11px] font-medium text-on-surface/70">{{ $act }}</span>
                            </div>
                            @endforeach
                            @foreach($item->assessment_activities ?? [] as $act)
                            <div class="flex items-center gap-2" title="Đánh giá">
                                <span class="material-symbols-outlined text-tertiary text-lg">fact_check</span>
                                <span class="text-[11px] font-medium text-on-surface/70">{{ $act }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-span-2">
                        <div class="flex flex-wrap gap-2">
                            @foreach($item->cloMappings as $mapping)
                            <span class="px-2 py-0.5 bg-primary-container/10 text-primary-container text-[10px] font-bold rounded border border-primary-container/20">
                                {{ $mapping->clo->code ?? '' }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-span-1 text-right">
                        <button class="p-2 text-on-surface/20 hover:text-on-surface transition-all">
                            <span class="material-symbols-outlined">more_vert</span>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="py-24 flex flex-col items-center justify-center glass-panel rounded-2xl border-dashed border-outline-variant/30">
                <div class="w-16 h-16 bg-surface-container-highest rounded-full flex items-center justify-center mb-6">
                    <span class="material-symbols-outlined text-3xl text-primary/50">calendar_month</span>
                </div>
                <h3 class="text-xl font-bold mb-2">Chưa có kế hoạch giảng dạy</h3>
                <p class="text-on-surface-variant/70 text-sm max-w-xs text-center mb-8">Sử dụng AI Synthesis Workbench để tạo kế hoạch tự động dựa trên CLOs.</p>
                <form method="POST" action="{{ route('lecturer.syllabuses.ai.generateTeachingPlan', $syllabus->id) }}">
                    @csrf
                    <button type="submit" class="bg-primary-container/20 text-primary border border-primary/30 px-6 py-2 rounded-lg text-xs font-bold hover:bg-primary-container/40 transition-all">
                        Initiate AI Generation
                    </button>
                </form>
            </div>
        @endif
    </section>
</main>

<style>
    .glass-panel {
        backdrop-filter: blur(12px);
        background: rgba(32, 31, 33, 0.6);
    }
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<script>
    document.querySelectorAll('.glass-panel, .bg-surface-container').forEach(card => {
        card.addEventListener('mousemove', e => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            card.style.setProperty('--mouse-x', `${x}px`);
            card.style.setProperty('--mouse-y', `${y}px`);
        });
    });
</script>
@endsection
