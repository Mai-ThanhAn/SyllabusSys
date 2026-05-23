@extends('layouts.university_admin')

@section('title', 'Thêm viện / khoa | Syllabus Lab')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header Section -->
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('university-admin.departments.index') }}" class="p-2 hover:bg-surface-container rounded-lg transition-colors group">
            <span class="material-symbols-outlined text-on-surface-variant group-hover:text-primary transition-colors">arrow_back</span>
        </a>
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="w-2 h-2 bg-primary rounded-full animate-pulse"></span>
                <span class="text-label-md font-label uppercase tracking-widest text-primary-fixed-dim">Department Management</span>
            </div>
            <h1 class="text-4xl font-display font-bold tracking-tighter text-on-surface">Thêm viện / khoa</h1>
            <p class="text-on-surface-variant/70 mt-2 font-body">
                Thêm đơn vị trực thuộc đại học mới vào hệ thống.
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
                <span class="material-symbols-outlined text-primary">add_business</span>
                <h2 class="font-label text-xs uppercase tracking-widest text-primary">Thông tin đơn vị mới</h2>
            </div>
        </div>

        <form method="POST" action="{{ route('university-admin.departments.store') }}" class="p-6">
            @csrf

            <div class="space-y-6">
                <!-- Department Name Field -->
                <div class="space-y-2">
                    <label class="block font-label text-[10px] uppercase tracking-widest text-on-surface-variant" for="department_name">
                        Tên viện/khoa <span class="text-error">*</span>
                    </label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-lg">business</span>
                        <input type="text"
                               id="department_name"
                               name="department_name"
                               value="{{ old('department_name') }}"
                               class="w-full bg-surface-container-lowest border-none shadow-inset-soft rounded-lg pl-12 pr-4 py-3 text-on-surface text-sm focus:ring-2 focus:ring-primary/50 transition-all"
                               placeholder="VD: Viện Công Nghệ Số">
                    </div>
                    <p class="text-[10px] text-on-surface-variant/60 italic mt-1">
                        Tên đơn vị nên viết đầy đủ và chính xác theo quyết định thành lập.
                    </p>
                </div>

                <!-- University Field -->
                <div class="space-y-2">
                    <label class="block font-label text-[10px] uppercase tracking-widest text-on-surface-variant" for="university_id">
                        Trường <span class="text-error">*</span>
                    </label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-lg">account_balance</span>
                        <select name="university_id"
                                id="university_id"
                                class="w-full bg-surface-container-lowest border-none shadow-inset-soft rounded-lg pl-12 pr-10 py-3 text-on-surface text-sm appearance-none focus:ring-2 focus:ring-primary/50 transition-all cursor-pointer">
                            <option value="">-- Chọn trường --</option>
                            @foreach($universities as $university)
                                <option value="{{ $university->id }}" {{ old('university_id') == $university->id ? 'selected' : '' }}>
                                    {{ $university->name ?? ('University #' . $university->id) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Preview Department Code (Auto-generated preview) -->
                <div class="space-y-2 opacity-60">
                    <label class="block font-label text-[10px] uppercase tracking-widest text-on-surface-variant">
                        Mã khoa (Sẽ được tạo tự động)
                    </label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-lg">fingerprint</span>
                        <div class="w-full bg-surface-container-lowest border-none shadow-inset-soft rounded-lg pl-12 pr-4 py-3 text-on-surface text-sm font-mono">
                            <span id="code_preview" class="text-primary">DEP_XXXXXX</span>
                        </div>
                    </div>
                    <p class="text-[10px] text-on-surface-variant/60 italic mt-1">
                        Mã khoa sẽ được hệ thống tự động tạo dựa trên tên khoa và trường.
                    </p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-4 pt-8 mt-6 border-t border-outline-variant/10">
                <a href="{{ route('university-admin.departments.index') }}" class="px-5 py-2.5 rounded-lg text-sm font-label uppercase tracking-widest text-on-surface-variant hover:text-on-surface transition-colors">
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
                    <strong class="text-secondary">Lưu ý:</strong> Sau khi thêm khoa/viện, bạn có thể bổ nhiệm trưởng khoa và tạo các chương trình đào tạo trực thuộc.
                    Mã khoa sẽ được tạo tự động và không thể thay đổi sau khi lưu.
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    // Live preview for department code (just for visual, not actual logic)
    const deptNameInput = document.getElementById('department_name');
    const uniSelect = document.getElementById('university_id');
    const codePreview = document.getElementById('code_preview');

    function updateCodePreview() {
        const deptName = deptNameInput.value.trim();
        const uniId = uniSelect.value;

        if (deptName && uniId) {
            const prefix = deptName.substring(0, 3).toUpperCase().replace(/[^A-Z]/g, '');
            const suffix = uniId.padStart(3, '0');
            codePreview.textContent = `${prefix}_${suffix}`;
            codePreview.style.opacity = '1';
        } else if (deptName) {
            const prefix = deptName.substring(0, 4).toUpperCase().replace(/[^A-Z]/g, '');
            codePreview.textContent = `${prefix}_XXX`;
            codePreview.style.opacity = '0.7';
        } else if (uniId) {
            const suffix = uniId.padStart(3, '0');
            codePreview.textContent = `DEP_${suffix}`;
            codePreview.style.opacity = '0.7';
        } else {
            codePreview.textContent = 'DEP_XXXXXX';
            codePreview.style.opacity = '0.5';
        }
    }

    deptNameInput.addEventListener('input', updateCodePreview);
    uniSelect.addEventListener('change', updateCodePreview);
</script>

<style>
    .shadow-extruded {
        box-shadow: 0 2px 0 0 rgba(94, 106, 210, 0.4);
    }
    .shadow-inset-soft {
        box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.2);
    }
</style>
@endsection
