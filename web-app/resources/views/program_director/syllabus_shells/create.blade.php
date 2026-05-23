@extends('layouts.program_director')

@section('title', 'Tạo khung đề cương & Phân công | Syllabus_System')

@section('content')
    <!-- Header Section -->
    <div class="flex justify-between items-end mb-10">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="w-2 h-2 bg-primary rounded-full animate-pulse"></span>
                <span class="text-label-md font-label uppercase tracking-widest text-primary-fixed-dim">
                    Orchestration Mode
                </span>
            </div>
            <h1
                class="text-headline-sm font-headline font-black tracking-tighter bg-gradient-to-b from-on-surface to-on-surface-variant bg-clip-text text-transparent">
                Tạo khung đề cương &amp; Phân công
            </h1>
        </div>
        <div class="flex gap-4">
            <a href="#"
                class="px-6 py-2 rounded-lg border border-outline-variant/20 text-label-md font-label uppercase tracking-widest text-on-surface-variant hover:bg-surface-container transition-colors">
                Hủy
            </a>
        </div>
    </div>

    <!-- Alert Handling -->
    @if (session('success'))
        <div
            class="mb-6 p-4 bg-primary-container/20 border-l-4 border-primary rounded-r-lg text-primary text-sm font-label uppercase tracking-wide">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div
            class="mb-6 p-4 bg-error-container/20 border-l-4 border-error rounded-r-lg text-error text-sm font-label uppercase tracking-wide">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Main Form -->
    <form method="POST" action="{{ route('program_director.syllabus_shells.store') }}">
        @csrf

        <div class="grid grid-cols-12 gap-8">
            <!-- LEFT COLUMN: Main Info & General Course Info -->
            <div class="col-span-12 lg:col-span-7 space-y-8">
                <!-- Card: Primary Identification -->
                <div class="surface-container p-8 rounded-xl relative overflow-hidden group">
                    <div
                        class="absolute top-0 left-0 w-full h-[2px] bg-gradient-to-r from-transparent via-primary/30 to-transparent">
                    </div>

                    <h2
                        class="text-label-md font-label uppercase tracking-widest text-on-surface-variant mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">database</span>
                        Thông Tin Cơ Bản &amp; Phân Công
                    </h2>

                    <div class="space-y-6">
                        <!-- Row 1: Course + Academic Year -->
                        <div class="grid grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-label uppercase tracking-widest text-outline ml-1">Môn
                                    học</label>
                                <select name="course_id"
                                    class="w-full bg-surface-container-lowest border-none shadow-inset-soft text-on-surface text-sm p-4 rounded-lg appearance-none">
                                    <option value="">-- Chọn môn học --</option>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}"
                                            {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                            {{ $course->course_code }} - {{ $course->course_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-label uppercase tracking-widest text-outline ml-1">Năm
                                    học</label>
                                <input type="text" name="academic_year" value="{{ old('academic_year') }}"
                                    class="w-full bg-surface-container-lowest border-none shadow-inset-soft text-on-surface text-sm p-4 rounded-lg placeholder:opacity-30"
                                    placeholder="2023-2024">
                            </div>
                        </div>

                        <!-- Row 2: Template -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-label uppercase tracking-widest text-outline ml-1">Khung đề cương
                                (Template)</label>
                            <select name="template_id"
                                class="w-full bg-surface-container-lowest border-none shadow-inset-soft text-on-surface text-sm p-4 rounded-lg appearance-none">
                                <option value="">-- Chọn khung --</option>
                                @foreach ($templates as $template)
                                    <option value="{{ $template->id }}"
                                        {{ old('template_id') == $template->id ? 'selected' : '' }}>
                                        {{ $template->template_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Row 3: Lecturer Assignment -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-label uppercase tracking-widest text-outline ml-1">Giảng viên phụ
                                trách</label>
                            <select name="assigned_to"
                                class="w-full bg-surface-container-lowest border-none shadow-inset-soft text-on-surface text-sm p-4 rounded-lg appearance-none">
                                <option value="">-- Chọn giảng viên --</option>
                                @foreach ($lecturers as $lecturer)
                                    <option value="{{ $lecturer->id }}"
                                        {{ old('assigned_to') == $lecturer->id ? 'selected' : '' }}>
                                        {{ $lecturer->full_name }} - {{ $lecturer->email }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Card: General Course Info -->
                <div class="surface-container p-8 rounded-xl relative overflow-hidden group">
                    <div
                        class="absolute top-0 left-0 w-full h-[2px] bg-gradient-to-r from-transparent via-primary/30 to-transparent">
                    </div>

                    <h2
                        class="text-label-md font-label uppercase tracking-widest text-on-surface-variant mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">info</span>
                        1. Thông tin tổng quát về học phần
                    </h2>

                    <div class="space-y-4">
                        <!-- Row 1: Basic Info -->
                        <div class="grid grid-cols-2 gap-4">
                            <input type="text" name="general_info[course_name]"
                                value="{{ old('general_info.course_name') }}"
                                class="form-input w-full bg-surface-container-lowest border-none shadow-inset-soft text-on-surface text-sm p-4 rounded-lg"
                                placeholder="Tên học phần">

                            <input type="text" name="general_info[english_name]"
                                value="{{ old('general_info.english_name') }}"
                                class="form-input w-full bg-surface-container-lowest border-none shadow-inset-soft text-on-surface text-sm p-4 rounded-lg"
                                placeholder="Tên tiếng Anh">
                        </div>

                        <!-- Row 2: Course Code + E-learning -->
                        <div class="grid grid-cols-2 gap-4">
                            <input type="text" name="general_info[course_code]"
                                value="{{ old('general_info.course_code') }}"
                                class="form-input w-full bg-surface-container-lowest border-none shadow-inset-soft text-on-surface text-sm p-4 rounded-lg"
                                placeholder="Mã học phần">

                            <input type="text" name="general_info[e_learning]"
                                value="{{ old('general_info.e_learning') }}"
                                class="form-input w-full bg-surface-container-lowest border-none shadow-inset-soft text-on-surface text-sm p-4 rounded-lg"
                                placeholder="E-learning">
                        </div>

                        <!-- Row 3: Credits -->
                        <div class="grid grid-cols-4 gap-4">
                            <input type="number" name="general_info[credits]" value="{{ old('general_info.credits') }}"
                                class="form-input w-full bg-surface-container-lowest border-none shadow-inset-soft text-on-surface text-sm p-4 rounded-lg"
                                placeholder="Số tín chỉ">

                            <input type="number" name="general_info[theory_hours]"
                                value="{{ old('general_info.theory_hours') }}"
                                class="form-input w-full bg-surface-container-lowest border-none shadow-inset-soft text-on-surface text-sm p-4 rounded-lg"
                                placeholder="Số tiết lý thuyết">

                            <input type="number" name="general_info[practice_hours]"
                                value="{{ old('general_info.practice_hours') }}"
                                class="form-input w-full bg-surface-container-lowest border-none shadow-inset-soft text-on-surface text-sm p-4 rounded-lg"
                                placeholder="Số tiết thực hành">

                            <input type="number" name="general_info[self_study_hours]"
                                value="{{ old('general_info.self_study_hours') }}"
                                class="form-input w-full bg-surface-container-lowest border-none shadow-inset-soft text-on-surface text-sm p-4 rounded-lg"
                                placeholder="Số tiết tự học">
                        </div>

                        <!-- Row 4: Prerequisite -->
                        <textarea name="general_info[prerequisite]" rows="2"
                            class="form-input w-full bg-surface-container-lowest border-none shadow-inset-soft text-on-surface text-sm p-4 rounded-lg"
                            placeholder="Học phần tiên quyết">{{ old('general_info.prerequisite') }}</textarea>

                        <!-- Row 5: Previous Course -->
                        <textarea name="general_info[previous_course]" rows="2"
                            class="form-input w-full bg-surface-container-lowest border-none shadow-inset-soft text-on-surface text-sm p-4 rounded-lg"
                            placeholder="Học phần học trước">{{ old('general_info.previous_course') }}</textarea>

                        <!-- Row 6: Parallel Course -->
                        <textarea name="general_info[parallel_course]" rows="2"
                            class="form-input w-full bg-surface-container-lowest border-none shadow-inset-soft text-on-surface text-sm p-4 rounded-lg"
                            placeholder="Học phần song hành">{{ old('general_info.parallel_course') }}</textarea>
                    </div>
                </div>

                <!-- Card: General Course Info -->
                <div class="surface-container p-8 rounded-xl relative overflow-hidden group">
                    <div
                        class="absolute top-0 left-0 w-full h-[2px] bg-gradient-to-r from-transparent via-primary/30 to-transparent">
                    </div>

                    <h2
                        class="text-label-md font-label uppercase tracking-widest text-on-surface-variant mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">info</span>
                        2. Mô tả học phần
                    </h2>

                    <div class="space-y-2">
                         <textarea name="course_description" rows="5"
                            class="form-input w-full bg-surface-container-lowest border-none shadow-inset-soft text-on-surface text-sm p-4 rounded-lg"
                            placeholder="Nhập mô tả học phần...">{{ old('course_description') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN: PLO/PI Selection & Logistics -->
            <div class="col-span-12 lg:col-span-5 space-y-8">
                <div class="surface-container p-8 rounded-xl h-full border border-outline-variant/10">
                    <h2
                        class="text-label-md font-label uppercase tracking-widest text-on-surface-variant mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">account_tree</span>
                        Chuẩn Đầu Ra Của Chương Trình Đào Tạo
                    </h2>

                    <div class="space-y-8">
                        <!-- PLO & PI Selection -->
                        <div class="space-y-4">
                            <label class="text-[10px] font-label uppercase tracking-widest text-outline ml-1">
                                PI mục tiêu
                            </label>

                            <div class="space-y-4">
                                @foreach ($plos as $plo)
                                    <div
                                        class="rounded-xl bg-surface-container-low border border-outline-variant/10 overflow-hidden">
                                        <!-- PLO HEADER -->
                                        <label
                                            class="flex items-start gap-3 p-4 cursor-pointer hover:bg-surface-container transition-all">
                                            <input type="checkbox"
                                                class="plo-toggle mt-1 rounded border-outline-variant text-primary focus:ring-primary"
                                                data-target="pi-list-{{ $plo->id }}">
                                            <div>
                                                <p class="text-xs font-label text-primary mb-1">{{ $plo->code }}</p>
                                                <p class="text-[11px] leading-tight text-on-surface-variant">
                                                    {{ $plo->description }}</p>
                                            </div>
                                        </label>

                                        <!-- PI LIST -->
                                        <div id="pi-list-{{ $plo->id }}"
                                            class="hidden border-t border-outline-variant/10 bg-surface-container-lowest/30 p-4">
                                            <div class="grid grid-cols-2 gap-3">
                                                @foreach ($plo->performanceIndicators as $pi)
                                                    <label
                                                        class="p-3 rounded-lg bg-surface-container-low border border-outline-variant/10 hover:border-primary/40 transition-all cursor-pointer group">
                                                        <div class="flex justify-between items-start mb-2">
                                                            <span
                                                                class="text-[10px] font-label text-primary">{{ $pi->code }}</span>
                                                            <input type="checkbox" name="pi_ids[]"
                                                                value="{{ $pi->id }}"
                                                                class="rounded bg-surface-container-lowest border-outline-variant text-primary focus:ring-primary focus:ring-offset-surface"
                                                                {{ in_array($pi->id, old('pi_ids', [])) ? 'checked' : '' }}>
                                                        </div>
                                                        <p
                                                            class="text-[11px] leading-tight text-on-surface-variant group-hover:text-on-surface transition-colors">
                                                            {{ $pi->description }}
                                                        </p>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Note & Deadline -->
                        <div class="space-y-6 pt-4 border-t border-outline-variant/10">
                            <div class="space-y-2">
                                <label class="text-[10px] font-label uppercase tracking-widest text-outline ml-1">Ghi chú
                                    định hướng</label>
                                <textarea name="planning_note" rows="4"
                                    class="w-full bg-surface-container-lowest border-none shadow-inset-soft text-on-surface text-sm p-4 rounded-lg placeholder:opacity-30 resize-none"
                                    placeholder="Nhập các yêu cầu cụ thể cho đề cương...">{{ old('planning_note') }}</textarea>
                            </div>

                            <div class="space-y-2">
                                <label class="text-[10px] font-label uppercase tracking-widest text-outline ml-1">Hạn hoàn
                                    thành</label>
                                <div class="relative">
                                    <input type="date" name="due_date" value="{{ old('due_date') }}"
                                        class="w-full bg-surface-container-lowest border-none shadow-inset-soft text-on-surface text-sm p-4 rounded-lg">
                                    <span
                                        class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-primary opacity-60 pointer-events-none">
                                        calendar_today
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Action -->
        <div
            class="mt-12 flex items-center justify-end gap-6 p-8 surface-container-high rounded-xl border border-primary/20">
            <div class="flex-1">
                <div class="text-[10px] font-label uppercase tracking-widest text-outline"></div>
                <div class="text-xs text-on-surface-variant opacity-70">

                </div>
            </div>
            <button type="submit"
                class="bg-gradient-to-br from-primary to-primary-container text-white px-10 py-4 rounded-lg font-label uppercase tracking-widest text-sm flex items-center gap-3 shadow-extruded hover:scale-[1.02] active:scale-[0.98] transition-all">
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
                    card.style.background =
                        `radial-gradient(300px circle at ${x}px ${y}px, rgba(189, 194, 255, 0.03), rgba(32, 31, 33, 0.6))`;
                } else {
                    card.style.background = `rgba(32, 31, 33, 0.6)`;
                }
            });
        });

        // PLO/PI Toggle Logic
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.plo-toggle').forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    const targetId = this.dataset.target;
                    const piList = document.getElementById(targetId);
                    if (this.checked) {
                        piList.classList.remove('hidden');
                    } else {
                        piList.classList.add('hidden');
                        piList.querySelectorAll('input[type="checkbox"]').forEach(function(
                            piCheckbox) {
                            piCheckbox.checked = false;
                        });
                    }
                });
            });
        });
    </script>
@endpush
