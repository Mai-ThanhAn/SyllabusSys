@extends('layouts.lecturer')

@section('title', 'Course Learning Outcomes | Syllabus Lab')

@section('content')
<!-- Main Content Area -->
<main class="ml-64 pt-24 pb-12 px-12 max-w-[1440px] mx-auto">
    <!-- Hero Section / Title -->
    <div class="flex justify-between items-end mb-12">
        <div>
            <span class="font-label text-primary-fixed text-xs tracking-widest uppercase mb-2 block">Refinement Workbench</span>
            <h2 class="text-4xl font-display font-bold tracking-tight text-on-surface">Course Learning Outcomes (CLO) <span class="text-surface-variant text-2xl ml-2 font-normal">Management</span></h2>
        </div>
        <div class="bg-surface-container-high rounded-full px-4 py-1.5 flex items-center gap-2 border border-outline-variant/20">
            <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
            <span class="text-xs font-label text-on-surface-variant">Live Session: {{ $syllabus->course->course_code ?? 'Course' }}</span>
        </div>
    </div>

    <!-- AI Synthesis Cluster (Asymmetric Grid) -->
    <section class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-16">
        <!-- AI Trigger Card -->
        <div class="lg:col-span-4 bg-surface-container-lowest border border-outline-variant/10 rounded-xl p-8 flex flex-col justify-between overflow-hidden relative group">
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-primary-container opacity-10 blur-[60px] group-hover:opacity-20 transition-opacity"></div>
            <div>
                <h3 class="font-label text-lg font-bold mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">auto_awesome</span>
                    AI Orchestration
                </h3>
                <p class="text-on-surface-variant/80 text-sm leading-relaxed mb-6">
                    Analyze current course objectives and generate technically aligned Learning Outcomes using bloom-taxonomy mapping.
                </p>
            </div>
            <form method="POST" action="{{ route('lecturer.syllabuses.ai.generateCLO', $syllabus->id) }}">
                @csrf
                <button type="submit" class="w-full bg-gradient-to-br from-primary to-primary-container text-white py-3 rounded-lg font-semibold flex items-center justify-center gap-2 shadow-lg transition-transform hover:scale-[1.02] active:scale-95">
                    Initialize AI CLO Generation
                </button>
            </form>
        </div>

        <!-- AI Result Console (Visible if result exists) -->
        @if (session('ai_result_clo'))
            @php($aiClo = session('ai_result_clo'))
            <div class="lg:col-span-8 glass-panel border border-primary/20 rounded-xl overflow-hidden terminal-glow">
                <div class="bg-surface-container-highest/30 px-6 py-4 border-b border-outline-variant/20 flex justify-between items-center">
                    <div class="flex items-center gap-4">
                        <span class="font-label text-xs text-primary bg-primary/10 px-2 py-0.5 rounded border border-primary/20">SYNTHESIS_ACTIVE</span>
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-medium text-on-surface-variant">Trạng thái:</span>
                            <span class="text-xs font-bold text-emerald-400 uppercase tracking-wider">{{ $aiClo['verification']['status'] ?? 'Optimal Alignment' }}</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-6">
                        <div class="flex items-center gap-2">
                            <div class="relative w-8 h-8">
                                <svg class="w-full h-full" viewBox="0 0 36 36">
                                    <path class="stroke-current text-outline-variant/20" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke-width="3"></path>
                                    <path class="stroke-current text-primary" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none"
                                          stroke-dasharray="{{ 251.2 * (($aiClo['verification']['final_score'] ?? 85) / 100) }}, 251.2"
                                          stroke-width="3"></path>
                                </svg>
                                <span class="absolute inset-0 flex items-center justify-center text-[10px] font-bold text-primary">{{ $aiClo['verification']['final_score'] ?? 85 }}</span>
                            </div>
                            <span class="text-xs font-label text-on-surface-variant">Điểm kiểm chứng</span>
                        </div>
                    </div>
                </div>

                <div class="p-6 space-y-4 max-h-[400px] overflow-y-auto custom-scrollbar">
                    @foreach ($aiClo['generated_data'] as $clo)
                    <div class="bg-surface-container-lowest/50 border-l-2 border-primary p-4 rounded-r-lg flex flex-col gap-3 group hover:bg-surface-container/50 transition-colors">
                        <div class="flex justify-between items-start">
                            <div class="flex items-center gap-3">
                                <span class="font-label font-bold text-primary">{{ $clo['code'] }}</span>
                                <span class="bg-secondary-container/30 text-secondary text-[10px] font-bold px-2 py-0.5 rounded uppercase">Bloom Level: {{ $clo['bloom_level'] ?? 'N/A' }}</span>
                            </div>
                            <div class="flex gap-1">
                                @foreach(($clo['mapped_co'] ?? []) as $co)
                                <span class="text-[9px] bg-outline-variant/20 text-on-surface-variant px-1.5 py-0.5 rounded">{{ $co }}</span>
                                @endforeach
                                @foreach(($clo['mapped_pi'] ?? []) as $pi)
                                <span class="text-[9px] bg-outline-variant/20 text-on-surface-variant px-1.5 py-0.5 rounded">{{ $pi }}</span>
                                @endforeach
                            </div>
                        </div>
                        <p class="text-sm text-on-surface/90 leading-relaxed italic">
                            "{{ $clo['description'] }}"
                        </p>
                    </div>
                    @endforeach

                    @if (!empty($aiClo['verification']['warnings']))
                    <div class="mt-6 border-t border-outline-variant/10 pt-4">
                        <p class="text-[10px] font-label text-error/70 uppercase mb-2 flex items-center gap-1">
                            <span class="material-symbols-outlined text-xs">warning</span>
                            Technical Warnings ({{ count($aiClo['verification']['warnings']) }})
                        </p>
                        <ul class="space-y-1 text-[11px] text-on-surface-variant/60">
                            @foreach ($aiClo['verification']['warnings'] as $warning)
                            <li>• {{ $warning }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>

                <div class="px-6 py-4 bg-surface-container-low border-t border-outline-variant/10 flex justify-end gap-3">
                    <form method="POST" action="{{ route('lecturer.syllabuses.ai.acceptCLO', $syllabus->id) }}">
                        @csrf
                        @foreach ($aiClo['generated_data'] as $index => $clo)
                            <input type="hidden" name="course_learning_outcomes[{{ $index }}][code]" value="{{ $clo['code'] }}">
                            <input type="hidden" name="course_learning_outcomes[{{ $index }}][description]" value="{{ $clo['description'] }}">
                            <input type="hidden" name="course_learning_outcomes[{{ $index }}][bloom_level]" value="{{ $clo['bloom_level'] ?? '' }}">
                        @endforeach
                        <button type="submit" class="px-5 py-1.5 text-xs font-bold bg-primary text-on-primary rounded-md shadow-lg hover:brightness-110 transition-all">Accept Synthesis</button>
                    </form>
                </div>
            </div>
        @endif
    </section>

    <!-- CLO Management Section -->
    <section class="mb-24">
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-4">
                <h3 class="text-xl font-bold">Course Learning Outcomes (CLO)</h3>
                <span class="bg-surface-container-highest text-on-surface-variant text-xs font-bold px-3 py-1 rounded-full border border-outline-variant/20">{{ $syllabus->courseLearningOutcomes->count() }} Total</span>
            </div>
        </div>

        @if ($syllabus->courseLearningOutcomes->count())
            <form method="POST" action="{{ route('lecturer.syllabuses.updateCLO', $syllabus->id) }}">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-6">
                    @foreach ($syllabus->courseLearningOutcomes as $clo)
                    <div class="bg-surface-container-low border border-outline-variant/10 rounded-xl p-6 flex flex-col md:flex-row gap-8 relative group transition-all hover:border-primary/20">
                        <div class="w-24 shrink-0">
                            <label class="block text-[10px] font-label text-on-surface-variant/50 uppercase tracking-widest mb-1">Identifier</label>
                            <div class="font-label font-bold text-2xl text-primary">{{ $clo->code }}</div>
                        </div>
                        <div class="flex-1 space-y-4">
                            <div>
                                <label class="block text-[10px] font-label text-on-surface-variant/50 uppercase tracking-widest mb-2">Refinement Editor</label>
                                <textarea name="course_learning_outcomes[{{ $clo->id }}][description]"
                                          class="w-full bg-surface-container-lowest border-none rounded-lg text-sm text-on-surface shadow-[inset_0_2px_4px_rgba(0,0,0,0.3)] p-4 leading-relaxed"
                                          placeholder="Enter outcome description..."
                                          rows="2">{{ old('course_learning_outcomes.' . $clo->id . '.description', $clo->description) }}</textarea>
                            </div>
                        </div>
                        <div class="w-full md:w-56 shrink-0">
                            <label class="block text-[10px] font-label text-on-surface-variant/50 uppercase tracking-widest mb-2">Bloom Level</label>
                            <select name="course_learning_outcomes[{{ $clo->id }}][bloom_level]"
                                    class="w-full bg-surface-container-lowest border-none rounded-lg text-sm text-on-surface shadow-[inset_0_2px_4px_rgba(0,0,0,0.3)] px-4 py-2 cursor-pointer">
                                <option value="Remember" {{ old('course_learning_outcomes.' . $clo->id . '.bloom_level', $clo->bloom_level) == 'Remember' ? 'selected' : '' }}>Remember</option>
                                <option value="Understand" {{ old('course_learning_outcomes.' . $clo->id . '.bloom_level', $clo->bloom_level) == 'Understand' ? 'selected' : '' }}>Understand</option>
                                <option value="Apply" {{ old('course_learning_outcomes.' . $clo->id . '.bloom_level', $clo->bloom_level) == 'Apply' ? 'selected' : '' }}>Apply</option>
                                <option value="Analyze" {{ old('course_learning_outcomes.' . $clo->id . '.bloom_level', $clo->bloom_level) == 'Analyze' ? 'selected' : '' }}>Analyze</option>
                                <option value="Evaluate" {{ old('course_learning_outcomes.' . $clo->id . '.bloom_level', $clo->bloom_level) == 'Evaluate' ? 'selected' : '' }}>Evaluate</option>
                                <option value="Create" {{ old('course_learning_outcomes.' . $clo->id . '.bloom_level', $clo->bloom_level) == 'Create' ? 'selected' : '' }}>Create</option>
                            </select>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Footer Action Bar -->
                <div class="mt-12 flex justify-between items-center p-8 bg-surface-container-lowest border border-outline-variant/10 rounded-xl shadow-2xl">
                    <div class="flex items-center gap-4">
                        <span class="material-symbols-outlined text-primary-fixed">info</span>
                        <p class="text-xs text-on-surface-variant/60 max-w-sm">Changes made here will propagate to the syllabus PDF and Student Information System upon final synchronization.</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <button type="button" class="px-6 py-3 rounded-lg text-sm font-semibold hover:bg-surface-container-highest transition-colors">Reset to Baseline</button>
                        <button type="submit" class="px-12 py-3 bg-gradient-to-r from-primary-container to-primary text-on-primary-container font-bold rounded-lg shadow-[0_8px_32px_rgba(94,106,210,0.4)] hover:shadow-primary/50 transition-all hover:scale-[1.02] active:scale-95">
                            Lưu CLO Configuration
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
                <h3 class="text-xl font-bold mb-2">No CLO Synchronized</h3>
                <p class="text-on-surface-variant/70 text-sm max-w-xs text-center mb-8">Begin by manually adding a CLO or utilize our AI Synthesis engine to generate high-fidelity learning outcomes.</p>
                <form method="POST" action="{{ route('lecturer.syllabuses.ai.generateCLO', $syllabus->id) }}">
                    @csrf
                    <button type="submit" class="bg-primary-container/20 text-primary border border-primary/30 px-6 py-2 rounded-lg text-xs font-bold hover:bg-primary-container/40 transition-all">
                        Initiate AI Generation
                    </button>
                </form>
            </div>
        @endif
    </section>
</main>

<!-- Floating Atmosphere Elements -->
<div class="fixed top-1/4 -right-20 w-80 h-80 bg-primary/5 rounded-full blur-[120px] pointer-events-none -z-10"></div>
<div class="fixed bottom-0 left-1/4 w-[600px] h-[300px] bg-secondary-container/5 rounded-full blur-[150px] pointer-events-none -z-10"></div>

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
</style>

<script>
    document.querySelectorAll('.group').forEach(item => {
        item.addEventListener('mousemove', (e) => {
            const rect = item.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            item.style.setProperty('--mouse-x', `${x}px`);
            item.style.setProperty('--mouse-y', `${y}px`);
        });
    });

    console.log("%c DIGITAL LABORATORY INITIALIZED ", "background: #5E6AD2; color: #fff; font-weight: bold; padding: 4px 8px;");
    console.log("%c Syll Orchestrator v4.2.0-stable ", "color: #bdc2ff; font-style: italic;");
</script>
@endsection
