<div class="space-y-6">
    <!-- AI Trigger -->
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-base font-bold text-on-background">Teaching Plan</h3>
            <p class="text-xs text-on-surface-variant/60">Generate weekly teaching plan from CLOs</p>
        </div>
        <form method="POST" action="{{ route('lecturer.syllabuses.ai.generateTeachingPlan', $syllabus->id) }}">
            @csrf
            <button class="bg-primary-container text-on-primary-container px-4 py-2 rounded-lg text-xs font-bold flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">auto_awesome</span>
                AI Generate Plan
            </button>
        </form>
    </div>

    <!-- AI Result -->
    @if (session('ai_result_teaching_plan'))
        @php($aiPlan = session('ai_result_teaching_plan'))
        <div class="bg-primary-container/10 border border-primary/20 rounded-xl p-4">
            <div class="flex justify-between items-center mb-3">
                <span class="text-xs font-bold text-primary">Score: {{ $aiPlan['verification']['final_score'] ?? 'N/A' }}</span>
                <span class="text-[10px] text-emerald-400">{{ $aiPlan['verification']['status'] ?? '' }}</span>
            </div>
            <div class="space-y-2 max-h-60 overflow-y-auto">
                @foreach (array_slice($aiPlan['generated_data'] ?? [], 0, 3) as $item)
                    <div class="bg-surface-container-lowest/50 p-2 rounded">
                        <span class="text-xs font-bold text-primary">Week {{ $item['order'] }}: {{ $item['title'] }}</span>
                        <p class="text-[11px] text-on-surface-variant/80 line-clamp-2">{{ implode(' ', $item['content'] ?? []) }}</p>
                    </div>
                @endforeach
            </div>
            <form method="POST" action="{{ route('lecturer.syllabuses.ai.acceptTeachingPlan', $syllabus->id) }}" class="mt-3 text-right">
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
                <button class="px-3 py-1 bg-primary text-on-primary rounded text-[10px] font-bold">Accept Plan</button>
            </form>
        </div>
    @endif

    <!-- Existing Teaching Plan -->
    @if ($syllabus->teachingPlanItems->count())
        <div class="space-y-2">
            <h4 class="text-xs font-bold text-on-surface-variant">Current Plan ({{ $syllabus->teachingPlanItems->count() }} weeks)</h4>
            @foreach ($syllabus->teachingPlanItems->sortBy('item_order') as $item)
                <div class="bg-surface-container-low/30 p-3 rounded-lg">
                    <span class="text-xs font-bold text-primary">Week {{ $item->item_order }}</span>
                    <p class="text-xs text-on-surface">{{ $item->title }}</p>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-8 text-on-surface-variant/50 text-sm">No teaching plan yet. Generate from CLOs.</div>
    @endif
</div>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
