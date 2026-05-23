<!-- AI ORCHESTRATION CONSOLE -->
<div class="space-y-6">
    <div class="flex items-end justify-between">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="material-symbols-outlined text-primary text-sm">auto_awesome</span>
                <span class="font-label text-[10px] text-primary uppercase tracking-[0.2em]">Neural Engine</span>
            </div>
            <h3 class="text-lg font-bold tracking-tight text-on-background">AI Objective Synthesis</h3>
        </div>

        <form method="POST" action="{{ route('lecturer.syllabuses.ai.generateCO', $syllabus->id) }}">
            @csrf
            <button class="bg-primary-container text-on-primary-container px-4 py-2 rounded-lg flex items-center gap-2 font-semibold text-xs" type="submit">
                <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">bolt</span>
                Generate CO
            </button>
        </form>
    </div>

    <!-- AI Result State -->
    @if (session('ai_result'))
        @php($ai = session('ai_result'))
        <div class="glass-panel rounded-xl p-4">
            <div class="flex flex-wrap gap-4">
                <div class="flex items-center gap-3">
                    <div class="relative w-12 h-12">
                        <svg class="w-full h-full transform -rotate-90">
                            <circle class="text-surface-container-high" cx="24" cy="24" fill="transparent" r="20" stroke="currentColor" stroke-width="3"></circle>
                            <circle class="text-primary-container" cx="24" cy="24" fill="transparent" r="20" stroke="currentColor"
                                    stroke-dasharray="125.6"
                                    stroke-dashoffset="{{ 125.6 - (125.6 * ($ai['verification']['final_score'] ?? 85) / 100) }}"
                                    stroke-width="3"></circle>
                        </svg>
                        <span class="absolute inset-0 flex items-center justify-center text-[10px] font-bold text-primary">{{ $ai['verification']['final_score'] ?? 85 }}</span>
                    </div>
                    <div>
                        <p class="text-[10px] text-primary font-bold">{{ $ai['verification']['final_score'] ?? 85 }}% Match</p>
                        <p class="text-[9px] text-on-surface-variant/60">{{ $ai['verification']['status'] ?? 'Pending' }}</p>
                    </div>
                </div>
                <div class="flex-1">
                    @foreach ($ai['generated_data'] as $co)
                        <div class="text-xs p-2 bg-surface-container-lowest/50 rounded mb-2">
                            <span class="font-bold text-primary">{{ $co['code'] }}</span>
                            <p class="text-on-surface-variant/80 text-[11px]">{{ $co['description'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="mt-3 flex justify-end">
                <form method="POST" action="{{ route('lecturer.syllabuses.ai.acceptCO', $syllabus->id) }}">
                    @csrf
                    @foreach ($ai['generated_data'] as $index => $co)
                        <input type="hidden" name="course_objectives[{{ $index }}][code]" value="{{ $co['code'] }}">
                        <input type="hidden" name="course_objectives[{{ $index }}][description]" value="{{ $co['description'] }}">
                    @endforeach
                    <button type="submit" class="px-3 py-1 bg-primary text-on-primary rounded text-[10px] font-bold">Accept</button>
                </form>
            </div>
        </div>
    @endif

    <!-- OBJECTIVE REPOSITORY -->
    <div>
        <div class="flex items-center gap-2 mb-3">
            <h4 class="text-sm font-bold text-on-background">Course Objectives (CO)</h4>
            <span class="px-2 py-0.5 rounded bg-secondary-container/30 text-secondary text-[9px] font-label">{{ $syllabus->courseObjectives->count() }}</span>
        </div>

        @if ($syllabus->courseObjectives->count())
            <form method="POST" action="{{ route('lecturer.syllabuses.updateCO', $syllabus->id) }}" class="space-y-3">
                @csrf
                @method('PUT')
                @foreach ($syllabus->courseObjectives as $co)
                    <div class="bg-surface-container-low/50 p-3 rounded-lg border-l-2 border-primary">
                        <div class="flex justify-between items-start mb-2">
                            <span class="font-label text-xs font-bold text-primary">{{ $co->code }}</span>
                        </div>
                        <textarea name="course_objectives[{{ $co->id }}][description]"
                            class="w-full bg-surface-container-lowest border-none rounded text-sm text-on-surface p-2 resize-none"
                            rows="2">{{ old('course_objectives.' . $co->id . '.description', $co->description) }}</textarea>
                    </div>
                @endforeach
                <div class="flex justify-end">
                    <button type="submit" class="bg-primary-container text-on-primary-container px-4 py-2 rounded text-xs font-bold">Save COs</button>
                </div>
            </form>
        @else
            <div class="text-center py-8 text-on-surface-variant/50 text-sm">No COs yet. Use AI to generate.</div>
        @endif
    </div>
</div>

<style>
    .glass-panel {
        backdrop-filter: blur(8px);
        background: rgba(32, 31, 33, 0.5);
    }
</style>
