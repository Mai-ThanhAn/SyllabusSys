@extends('layouts.department')

@section('title', 'Thêm môn học | TechSyllabus')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header Section -->
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('department.courses.index') }}" class="p-2 hover:bg-surface-container rounded-lg transition-colors group">
            <span class="material-symbols-outlined text-on-surface-variant group-hover:text-primary transition-colors">arrow_back</span>
        </a>
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="w-2 h-2 bg-primary rounded-full animate-pulse"></span>
                <span class="text-label-md font-label uppercase tracking-widest text-primary-fixed-dim">Course Management</span>
            </div>
            <h1 class="text-4xl font-display font-bold tracking-tighter text-on-surface">Thêm môn học</h1>
            <p class="text-on-surface-variant/70 mt-2 font-body">
                Thêm môn học mới vào chương trình đào tạo.
            </p>
        </div>
    </div>

    <!-- Error Display -->
    @if($errors->any())
    <div class="mb-6 p-4 bg-error-container/10 border-l-4 border-error rounded-r-xl">
        <div class="flex items-start gap-3">
            <span class="material-symbols-outlined text-error mt-0.5">warning</span>
            <div>
                <h4 class="font-label text-xs font-bold text-error uppercase tracking-widest mb-2">Validation Errors</h4>
                <ul class="text-sm text-on-error-container/80 list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    <!-- Create Form Card -->
    <div class="bg-surface-container-lowest rounded-xl border border-outline-variant/10 overflow-hidden shadow-2xl">
        <div class="p-6 border-b border-outline-variant/10 bg-surface-container/30">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-primary">add_circle</span>
                <h2 class="font-label text-xs uppercase tracking-widest text-primary">Thông tin môn học mới</h2>
            </div>
        </div>

        <form method="POST" action="{{ route('department.courses.store') }}" class="p-6">
            @csrf

            <div class="space-y-6">
                <!-- Course Code Field -->
                <div class="space-y-2">
                    <label class="block font-label text-[10px] uppercase tracking-widest text-on-surface-variant" for="course_code">
                        Mã môn học <span class="text-error">*</span>
                    </label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-lg">fingerprint</span>
                        <input type="text"
                               id="course_code"
                               name="course_code"
                               value="{{ old('course_code') }}"
                               class="w-full bg-surface-container-lowest border-none shadow-inset-soft rounded-lg pl-12 pr-4 py-3 text-on-surface text-sm focus:ring-2 focus:ring-primary/50 transition-all"
                               placeholder="VD: IT1010">
                    </div>
                    <p class="text-[10px] text-on-surface-variant/60 italic mt-1">
                        Mã môn học phải là duy nhất trong hệ thống.
                    </p>
                </div>

                <!-- Course Name Field -->
                <div class="space-y-2">
                    <label class="block font-label text-[10px] uppercase tracking-widest text-on-surface-variant" for="course_name">
                        Tên môn học <span class="text-error">*</span>
                    </label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-lg">menu_book</span>
                        <input type="text"
                               id="course_name"
                               name="course_name"
                               value="{{ old('course_name') }}"
                               class="w-full bg-surface-container-lowest border-none shadow-inset-soft rounded-lg pl-12 pr-4 py-3 text-on-surface text-sm focus:ring-2 focus:ring-primary/50 transition-all"
                               placeholder="VD: Lập trình hướng đối tượng">
                    </div>
                </div>

                <!-- Credits Field -->
                <div class="space-y-2">
                    <label class="block font-label text-[10px] uppercase tracking-widest text-on-surface-variant" for="credits">
                        Số tín chỉ <span class="text-error">*</span>
                    </label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-lg">star</span>
                        <input type="number"
                               id="credits"
                               name="credits"
                               min="1"
                               max="20"
                               value="{{ old('credits', 3) }}"
                               class="w-full bg-surface-container-lowest border-none shadow-inset-soft rounded-lg pl-12 pr-4 py-3 text-on-surface text-sm focus:ring-2 focus:ring-primary/50 transition-all">
                    </div>
                    <p class="text-[10px] text-on-surface-variant/60 italic mt-1">
                        Số tín chỉ từ 1 đến 20.
                    </p>
                </div>

                <!-- Program Selection Field -->
                <div class="space-y-2">
                    <label class="block font-label text-[10px] uppercase tracking-widest text-on-surface-variant" for="program_id">
                        Chương trình đào tạo <span class="text-error">*</span>
                    </label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-lg">account_balance</span>
                        <select name="program_id"
                                id="program_id"
                                class="w-full bg-surface-container-lowest border-none shadow-inset-soft rounded-lg pl-12 pr-10 py-3 text-on-surface text-sm appearance-none focus:ring-2 focus:ring-primary/50 transition-all cursor-pointer">
                            <option value="">-- Chọn CTĐT --</option>
                            @foreach($programs as $program)
                                <option value="{{ $program->id }}" {{ old('program_id') == $program->id ? 'selected' : '' }}>
                                    {{ $program->code }} - {{ $program->name }}
                                </option>
                            @endforeach
                        </select>
                        <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-outline pointer-events-none">
                            expand_more
                        </span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-4 pt-8 mt-6 border-t border-outline-variant/10">
                <a href="{{ route('department.courses.index') }}" class="px-5 py-2.5 rounded-lg text-sm font-label uppercase tracking-widest text-on-surface-variant hover:text-on-surface transition-colors">
                    Hủy bỏ
                </a>
                <button type="submit" class="px-6 py-2.5 bg-primary-container text-on-primary-container rounded-lg font-label text-sm font-bold uppercase tracking-widest shadow-extruded hover:brightness-110 transition-all">
                    <span class="material-symbols-outlined text-sm align-middle mr-1">save</span>
                    Lưu
                </button>
            </div>
        </form>
    </div>

    <!-- Info Note -->
    <div class="mt-6 p-4 bg-secondary-container/5 rounded-xl border border-secondary-container/10">
        <div class="flex gap-3">
            <span class="material-symbols-outlined text-secondary text-lg">info</span>
            <div>
                <p class="text-xs text-on-surface-variant leading-relaxed">
                    <strong class="text-secondary">Lưu ý:</strong> Sau khi thêm môn học, bạn có thể tạo đề cương chi tiết và phân công giảng viên phụ trách.
                    Môn học sẽ được sử dụng trong các khung đề cương và chương trình đào tạo.
                </p>
            </div>
        </div>
    </div>
</div>

<style>
    .shadow-extruded {
        box-shadow: 0 2px 0 0 rgba(94, 106, 210, 0.4);
    }
    .shadow-inset-soft {
        box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.2);
    }
</style>
@endsection
