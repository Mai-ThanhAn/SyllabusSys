@extends('layouts.program_director')

@section('title', 'Tạo khung đề cương & Phân công | Syllabus Lab')

@section('content')
<!-- Header Section -->
<div class="flex justify-between items-end mb-10">
    <div>
        <div class="flex items-center gap-3 mb-2">
            <span class="w-2 h-2 bg-primary rounded-full animate-pulse"></span>
            <span class="text-label-md font-label uppercase tracking-widest text-primary-fixed-dim">Orchestration Mode</span>
        </div>
        <h1 class="text-headline-sm font-headline font-black tracking-tighter bg-gradient-to-b from-on-surface to-on-surface-variant bg-clip-text text-transparent">
            Tạo khung đề cương &amp; Phân công
        </h1>
    </div>
    <div class="flex gap-4">
        <a href="#" class="px-6 py-2 rounded-lg border border-outline-variant/20 text-label-md font-label uppercase tracking-widest text-on-surface-variant hover:bg-surface-container transition-colors">
            Cancel session
        </a>
    </div>
</div>

<!-- Alert Handling -->
@if(session('success'))
<div class="mb-6 p-4 bg-primary-container/20 border-l-4 border-primary rounded-r-lg text-primary text-sm font-label uppercase tracking-wide">
    {{ session('success') }}
</div>
@endif

@if($errors->any())
<div class="mb-6 p-4 bg-error-container/20 border-l-4 border-error rounded-r-lg text-error text-sm font-label uppercase tracking-wide">
    <ul class="list-disc list-inside">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<!-- Laravel Form Container -->
<form method="POST" action="{{ route('program_director.syllabus_shells.store') }}">
    @csrf

    <div class="grid grid-cols-12 gap-8">
        <!-- Left Column: Main Info -->
        <div class="col-span-12 lg:col-span-7 space-y-8">
            <div class="surface-container p-8 rounded-xl relative overflow-hidden group">
                <div class="absolute top-0 left-0 w-full h-[2px] bg-gradient-to-r from-transparent via-primary/30 to-transparent"></div>
                <h2 class="text-label-md font-label uppercase tracking-widest text-on-surface-variant mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">database</span>
                    Primary identification
                </h2>
                <div class="space-y-6">
                    <div class="grid grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-label uppercase tracking-widest text-outline ml-1">Môn học</label>
                            <select class="w-full bg-surface-container-lowest border-none shadow-inset-soft text-on-surface text-sm p-4 rounded-lg appearance-none" name="course_id">
                                <option value="">-- Chọn môn học --</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                        {{ $course->course_code }} - {{ $course->course_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-label uppercase tracking-widest text-outline ml-1">Năm học</label>
                            <input class="w-full bg-surface-container-lowest border-none shadow-inset-soft text-on-surface text-sm p-4 rounded-lg placeholder:opacity-30"
                                   name="academic_year"
                                   placeholder="2023-2024"
                                   type="text"
                                   value="{{ old('academic_year') }}"/>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-label uppercase tracking-widest text-outline ml-1">Khung đề cương (Template)</label>
                        <select class="w-full bg-surface-container-lowest border-none shadow-inset-soft text-on-surface text-sm p-4 rounded-lg appearance-none" name="template_id">
                            <option value="">-- Chọn khung --</option>
                            @foreach($templates as $template)
                                <option value="{{ $template->id }}" {{ old('template_id') == $template->id ? 'selected' : '' }}>
                                    {{ $template->template_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-label uppercase tracking-widest text-outline ml-1">Giảng viên phụ trách</label>
                        <div class="relative">
                            <select class="w-full bg-surface-container-lowest border-none shadow-inset-soft text-on-surface text-sm p-4 rounded-lg appearance-none" name="assigned_to">
                                <option value="">-- Chọn giảng viên --</option>
                                @foreach($lecturers as $lecturer)
                                    <option value="{{ $lecturer->id }}" {{ old('assigned_to') == $lecturer->id ? 'selected' : '' }}>
                                        {{ $lecturer->full_name }} - {{ $lecturer->email }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Alignment & Logistics -->
        <div class="col-span-12 lg:col-span-5 space-y-8">
            <div class="surface-container p-8 rounded-xl h-full border border-outline-variant/10">
                <h2 class="text-label-md font-label uppercase tracking-widest text-on-surface-variant mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">account_tree</span>
                    Alignment &amp; Logistics
                </h2>
                <div class="space-y-8">
                    <!-- PLO Selection -->
                    <div class="space-y-4">
                        <label class="text-[10px] font-label uppercase tracking-widest text-outline ml-1">PLO mục tiêu</label>
                        <div class="grid grid-cols-2 gap-3">
                            @foreach($plos as $plo)
                            <div class="p-4 rounded-lg bg-surface-container-low border border-outline-variant/10 hover:border-primary/40 transition-all cursor-pointer group">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="text-[10px] font-label text-primary">{{ $plo->code }}</span>
                                    <input class="rounded bg-surface-container-lowest border-outline-variant text-primary focus:ring-primary focus:ring-offset-surface"
                                           name="plo_ids[]"
                                           type="checkbox"
                                           value="{{ $plo->id }}"
                                           {{ in_array($plo->id, old('plo_ids', [])) ? 'checked' : '' }}/>
                                </div>
                                <p class="text-[11px] leading-tight text-on-surface-variant group-hover:text-on-surface transition-colors">{{ $plo->description }}</p>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- PI Selection -->
                    <div class="space-y-4">
                        <label class="text-[10px] font-label uppercase tracking-widest text-outline ml-1">PI mục tiêu</label>
                        <div class="grid grid-cols-2 gap-3">
                            @foreach($pis as $pi)
                            <div class="p-4 rounded-lg bg-surface-container-low border border-outline-variant/10 hover:border-primary/40 transition-all cursor-pointer group">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="text-[10px] font-label text-primary">{{ $pi->code }}</span>
                                    <input class="rounded bg-surface-container-lowest border-outline-variant text-primary focus:ring-primary focus:ring-offset-surface"
                                           name="pi_ids[]"
                                           type="checkbox"
                                           value="{{ $pi->id }}"
                                           {{ in_array($pi->id, old('pi_ids', [])) ? 'checked' : '' }}/>
                                </div>
                                <p class="text-[11px] leading-tight text-on-surface-variant group-hover:text-on-surface transition-colors">{{ $pi->description }}</p>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Note & Date -->
                    <div class="space-y-6 pt-4 border-t border-outline-variant/10">
                        <div class="space-y-2">
                            <label class="text-[10px] font-label uppercase tracking-widest text-outline ml-1">Ghi chú định hướng</label>
                            <textarea class="w-full bg-surface-container-lowest border-none shadow-inset-soft text-on-surface text-sm p-4 rounded-lg placeholder:opacity-30 resize-none"
                                      name="planning_note"
                                      placeholder="Nhập các yêu cầu cụ thể cho đề cương..."
                                      rows="4">{{ old('planning_note') }}</textarea>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-label uppercase tracking-widest text-outline ml-1">Hạn hoàn thành</label>
                            <div class="relative">
                                <input class="w-full bg-surface-container-lowest border-none shadow-inset-soft text-on-surface text-sm p-4 rounded-lg"
                                       name="due_date"
                                       type="date"
                                       value="{{ old('due_date') }}"/>
                                <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-primary opacity-60 pointer-events-none">calendar_today</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Action -->
    <div class="mt-12 flex items-center justify-end gap-6 p-8 surface-container-high rounded-xl border border-primary/20">
        <div class="flex-1">
            <div class="text-[10px] font-label uppercase tracking-widest text-outline">Action Intelligence</div>
            <div class="text-xs text-on-surface-variant opacity-70">Khởi tạo shell sẽ kích hoạt thông báo cho giảng viên và bắt đầu quy trình theo dõi PLO.</div>
        </div>
        <button class="bg-gradient-to-br from-primary to-primary-container text-white px-10 py-4 rounded-lg font-label uppercase tracking-widest text-sm flex items-center gap-3 shadow-extruded hover:scale-[1.02] active:scale-[0.98] transition-all" type="submit">
            <span class="material-symbols-outlined">rocket_launch</span>
            Khởi tạo &amp; Phân công
        </button>
    </div>
</form>
@endsection

@push('scripts')
<script>
    // Micro-interactions for mouse tracking spotlights
    document.addEventListener('mousemove', (e) => {
        const cards = document.querySelectorAll('.surface-container');
        cards.forEach(card => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            if (x >= 0 && x <= rect.width && y >= 0 && y <= rect.height) {
                card.style.background = `radial-gradient(300px circle at ${x}px ${y}px, rgba(189, 194, 255, 0.03), rgba(32, 31, 33, 0.6))`;
            } else {
                card.style.background = `rgba(32, 31, 33, 0.6)`;
            }
        });
    });
</script>
@endpush
