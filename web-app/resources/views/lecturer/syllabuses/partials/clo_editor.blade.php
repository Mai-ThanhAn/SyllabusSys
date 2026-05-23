<div class="space-y-6">
    <!-- AI Trigger -->
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-base font-bold text-on-background">Course Learning Outcomes (CLO)</h3>
            <p class="text-xs text-on-surface-variant/60">Generate learning outcomes from COs</p>
        </div>
        <form method="POST" action="{{ route('lecturer.syllabuses.ai.generateCLO', $syllabus->id) }}">
            @csrf
            <button class="bg-primary-container text-on-primary-container px-4 py-2 rounded-lg text-xs font-bold flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">auto_awesome</span>
                AI Generate CLO
            </button>
        </form>
    </div>

    <!-- AI Result -->
    @if (session('ai_result_clo'))
        @php($aiClo = session('ai_result_clo'))
        <div class="bg-primary-container/10 border border-primary/20 rounded-xl p-4">
            <div class="flex justify-between items-center mb-3">
                <span class="text-xs font-bold text-primary">Score: {{ $aiClo['verification']['final_score'] ?? 'N/A' }}</span>
                <span class="text-[10px] text-emerald-400">{{ $aiClo['verification']['status'] ?? '' }}</span>
            </div>
            <div class="space-y-2 max-h-60 overflow-y-auto">
                @foreach ($aiClo['generated_data'] as $clo)
                    <div class="bg-surface-container-lowest/50 p-2 rounded">
                        <div class="flex justify-between">
                            <span class="text-xs font-bold text-primary">{{ $clo['code'] }}</span>
                            <span class="text-[9px] text-secondary">Bloom: {{ $clo['bloom_level'] ?? 'N/A' }}</span>
                        </div>
                        <p class="text-[11px] text-on-surface-variant/80">{{ $clo['description'] }}</p>
                    </div>
                @endforeach
            </div>
            <form method="POST" action="{{ route('lecturer.syllabuses.ai.acceptCLO', $syllabus->id) }}" class="mt-3 text-right">
                @csrf
                @foreach ($aiClo['generated_data'] as $index => $clo)
                    <input type="hidden" name="course_learning_outcomes[{{ $index }}][code]" value="{{ $clo['code'] }}">
                    <input type="hidden" name="course_learning_outcomes[{{ $index }}][description]" value="{{ $clo['description'] }}">
                    <input type="hidden" name="course_learning_outcomes[{{ $index }}][bloom_level]" value="{{ $clo['bloom_level'] ?? '' }}">
                @endforeach
                <button class="px-3 py-1 bg-primary text-on-primary rounded text-[10px] font-bold">Accept All</button>
            </form>
        </div>
    @endif

    <!-- Existing CLOs -->
    @if ($syllabus->courseLearningOutcomes->count())
        <form method="POST" action="{{ route('lecturer.syllabuses.updateCLO', $syllabus->id) }}" class="space-y-3">
            @csrf
            @method('PUT')
            @foreach ($syllabus->courseLearningOutcomes as $clo)
                <div class="bg-surface-container-low/50 p-3 rounded-lg border-l-2 border-secondary">
                    <div class="flex justify-between items-start mb-2">
                        <span class="font-label text-xs font-bold text-secondary">{{ $clo->code }}</span>
                        <select name="course_learning_outcomes[{{ $clo->id }}][bloom_level]" class="bg-surface-container-lowest border-none rounded text-[10px] p-1">
                            <option {{ $clo->bloom_level == 'Remember' ? 'selected' : '' }}>Remember</option>
                            <option {{ $clo->bloom_level == 'Understand' ? 'selected' : '' }}>Understand</option>
                            <option {{ $clo->bloom_level == 'Apply' ? 'selected' : '' }}>Apply</option>
                            <option {{ $clo->bloom_level == 'Analyze' ? 'selected' : '' }}>Analyze</option>
                            <option {{ $clo->bloom_level == 'Evaluate' ? 'selected' : '' }}>Evaluate</option>
                            <option {{ $clo->bloom_level == 'Create' ? 'selected' : '' }}>Create</option>
                        </select>
                    </div>
                    <textarea name="course_learning_outcomes[{{ $clo->id }}][description]"
                        class="w-full bg-surface-container-lowest border-none rounded text-sm text-on-surface p-2 resize-none"
                        rows="2">{{ old('course_learning_outcomes.' . $clo->id . '.description', $clo->description) }}</textarea>
                </div>
            @endforeach
            <div class="flex justify-end">
                <button type="submit" class="bg-primary-container text-on-primary-container px-4 py-2 rounded text-xs font-bold">Save CLOs</button>
            </div>
        </form>
    @else
        <div class="text-center py-8 text-on-surface-variant/50 text-sm">No CLOs yet. Generate from COs.</div>
    @endif
</div>
