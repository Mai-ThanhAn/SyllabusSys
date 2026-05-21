@extends('layouts.lecturer')

@section('title', 'AI Objective Synthesis | Syllabus Lab')

@section('content')
<!-- Main Content Canvas -->
<main class="ml-64 pt-16 h-screen flex flex-col bg-background">
    <!-- Ambient Decorative Glow -->
    <div class="fixed top-1/4 right-1/4 w-[400px] h-[400px] bg-primary-container/5 blur-[120px] rounded-full pointer-events-none"></div>
    <div class="fixed bottom-1/4 left-1/4 w-[300px] h-[300px] bg-secondary-container/5 blur-[100px] rounded-full pointer-events-none"></div>

    <div class="flex-1 p-8 flex flex-col gap-8 max-w-7xl mx-auto w-full overflow-y-auto custom-scrollbar">

        <!-- AI ORCHESTRATION CONSOLE -->
        <section class="flex flex-col gap-4">
            <div class="flex items-end justify-between">
                <div>
                    <span class="font-label text-[10px] text-primary uppercase tracking-[0.2em]">Neural Engine</span>
                    <h2 class="text-2xl font-bold tracking-tight text-on-background">AI Objective Synthesis</h2>
                </div>

                <form method="POST" action="{{ route('lecturer.syllabuses.ai.generateCO', $syllabus->id) }}">
                    @csrf
                    <button class="bg-primary-container text-on-primary-container px-6 py-3 rounded-lg flex items-center gap-2 font-semibold text-sm" type="submit">
                        <span class="material-symbols-outlined text-lg" style="font-variation-settings: 'FILL' 1;">bolt</span>
                        Initialize AI CO Generation
                    </button>
                </form>
            </div>

            <!-- AI Result State -->
            @if (session('ai_result'))
                @php($ai = session('ai_result'))

                <div class="glass-panel rounded-xl p-6 relative overflow-hidden">
                    <div class="flex flex-col md:flex-row gap-8">
                        <!-- AI Performance Metric -->
                        <div class="w-full md:w-48 flex flex-col items-center justify-center p-4 bg-surface-container-lowest/50 rounded-xl border border-outline-variant/10">
                            <span class="font-label text-[9px] text-on-surface-variant uppercase mb-4">Verification Score</span>
                            <div class="relative flex items-center justify-center">
                                <svg class="w-24 h-24 transform -rotate-90">
                                    <circle class="text-surface-container-high" cx="48" cy="48" fill="transparent" r="40" stroke="currentColor" stroke-width="6"></circle>
                                    <circle class="text-primary-container drop-shadow-[0_0_8px_rgba(94,106,210,0.6)]"
                                            cx="48" cy="48" fill="transparent" r="40" stroke="currentColor"
                                            stroke-dasharray="251.2"
                                            stroke-dashoffset="{{ 251.2 - (251.2 * ($ai['verification']['final_score'] ?? 85) / 100) }}"
                                            stroke-width="6"></circle>
                                </svg>
                                <span class="absolute text-xl font-bold font-label">{{ $ai['verification']['final_score'] ?? 85 }}<span class="text-xs text-on-surface-variant">/100</span></span>
                            </div>
                            <p class="text-[10px] text-primary mt-4 font-medium tracking-wide">
                                @if(($ai['verification']['final_score'] ?? 85) >= 80)
                                    HIGH PRECISION
                                @elseif(($ai['verification']['final_score'] ?? 85) >= 60)
                                    MEDIUM PRECISION
                                @else
                                    LOW PRECISION
                                @endif
                            </p>
                        </div>

                        <!-- Generated Objectives List -->
                        <div class="flex-1 grid grid-cols-1 lg:grid-cols-2 gap-4">
                            @foreach ($ai['generated_data'] as $co)
                            <div class="bg-surface-container-lowest/30 p-4 rounded-lg border border-outline-variant/5">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="font-label text-xs font-bold text-primary">{{ $co['code'] }}</span>
                                    <span class="material-symbols-outlined text-xs text-on-surface-variant">auto_awesome</span>
                                </div>
                                <p class="text-sm leading-relaxed text-on-surface-variant/90 italic">
                                    "{{ $co['description'] }}"
                                </p>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-6 pt-6 border-t border-outline-variant/10 flex justify-end gap-3">
                        <form method="POST" action="{{ route('lecturer.syllabuses.ai.acceptCO', $syllabus->id) }}">
                            @csrf
                            @foreach ($ai['generated_data'] as $index => $co)
                                <input type="hidden" name="course_objectives[{{ $index }}][code]" value="{{ $co['code'] }}">
                                <input type="hidden" name="course_objectives[{{ $index }}][description]" value="{{ $co['description'] }}">
                            @endforeach
                            <button type="submit" class="bg-surface-container-highest hover:bg-surface-container text-on-surface px-5 py-2 rounded-lg text-xs font-semibold border border-outline-variant/20 transition-all">
                                Accept Synthesis
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </section>

        <!-- OBJECTIVE REPOSITORY -->
        <section class="flex flex-col gap-4 mb-12">
            <div class="flex items-center gap-3">
                <h2 class="text-2xl font-bold tracking-tight text-on-background">Course Objectives (CO)</h2>
                <span class="px-2 py-0.5 rounded bg-secondary-container/30 text-secondary text-[10px] font-label">{{ $syllabus->courseObjectives->count() }} TOTAL</span>
            </div>

            @if ($syllabus->courseObjectives->count())
                <form method="POST" action="{{ route('lecturer.syllabuses.updateCO', $syllabus->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="flex flex-col gap-3">
                        @foreach ($syllabus->courseObjectives as $co)
                        <div class="glass-panel group hover:bg-surface-container-high/40 transition-all duration-300 rounded-xl p-5 flex flex-col md:flex-row gap-6 items-start border-l-4 border-l-transparent hover:border-l-primary-container">
                            <div class="flex flex-col gap-1 min-w-[100px]">
                                <span class="font-label text-[10px] text-on-surface-variant uppercase tracking-widest">Identifier</span>
                                <span class="font-label text-lg font-bold text-on-background">{{ $co->code }}</span>
                            </div>
                            <div class="flex-1 w-full">
                                <label class="font-label text-[10px] text-on-surface-variant uppercase tracking-widest mb-1 block">Refinement Editor</label>
                                <textarea name="course_objectives[{{ $co->id }}][description]"
                                          class="w-full bg-surface-container-lowest/50 border-none rounded-lg focus:ring-1 focus:ring-primary-container/50 text-sm text-on-surface p-3 custom-scrollbar h-24 resize-none transition-all placeholder-on-surface-variant/30"
                                          placeholder="Describe the objective outcome...">{{ old('course_objectives.' . $co->id . '.description', $co->description) }}</textarea>
                            </div>
                            <div class="flex md:flex-col gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button type="button" class="p-2 hover:bg-primary-container/20 rounded-md text-primary transition-colors" title="Lịch sử">
                                    <span class="material-symbols-outlined text-lg">history</span>
                                </button>
                                <button type="button" class="p-2 hover:bg-error/20 rounded-md text-error transition-colors" title="Xóa">
                                    <span class="material-symbols-outlined text-lg">delete</span>
                                </button>
                            </div>
                        </div>
                        @endforeach

                        <!-- Footer Action -->
                        <div class="mt-4 flex justify-end">
                            <button type="submit" class="bg-primary-container text-on-primary-container px-8 py-3 rounded-lg font-bold text-sm">
                                Save Orchestration
                            </button>
                        </div>
                    </div>
                </form>
            @else
                <!-- Empty State -->
                <div class="py-24 flex flex-col items-center justify-center glass-panel rounded-2xl border-dashed border-outline-variant/30">
                    <div class="w-16 h-16 bg-surface-container-highest rounded-full flex items-center justify-center mb-6">
                        <span class="material-symbols-outlined text-3xl text-primary/50">sync_problem</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2">No Objectives Synchronized</h3>
                    <p class="text-on-surface-variant/70 text-sm max-w-xs text-center mb-8">Begin by manually adding an objective or utilize our AI Synthesis engine to generate high-fidelity targets.</p>
                    <form method="POST" action="{{ route('lecturer.syllabuses.ai.generateCO', $syllabus->id) }}">
                        @csrf
                        <button type="submit" class="bg-primary-container/20 text-primary border border-primary/30 px-6 py-2 rounded-lg text-xs font-bold hover:bg-primary-container/40 transition-all">
                            Initiate AI Generation
                        </button>
                    </form>
                </div>
            @endif
        </section>

    </div>
</main>

<!-- Micro-interaction Spotlight -->
<script>
    document.addEventListener('mousemove', (e) => {
        const cards = document.querySelectorAll('.glass-panel');
        cards.forEach(card => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            card.style.setProperty('--mouse-x', `${x}px`);
            card.style.setProperty('--mouse-y', `${y}px`);
        });
    });
</script>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #0e0e0f;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #353436;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #5e6ad2;
    }
    .glass-panel {
        backdrop-filter: blur(12px);
        background: rgba(32, 31, 33, 0.6);
    }
    .grid-pattern {
        background-image: radial-gradient(circle at 2px 2px, rgba(69, 70, 82, 0.15) 1px, transparent 0);
        background-size: 24px 24px;
    }
</style>
@endsection
