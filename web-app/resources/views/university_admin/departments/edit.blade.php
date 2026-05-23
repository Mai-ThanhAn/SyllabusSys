@extends('layouts.university_admin')

@section('title', 'Sửa viện / khoa | Syllabus Lab')

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
            <h1 class="text-4xl font-display font-bold tracking-tighter text-on-surface">Sửa viện / khoa</h1>
            <p class="text-on-surface-variant/70 mt-2 font-body">
                Cập nhật thông tin đơn vị trực thuộc đại học.
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

    <!-- Edit Form Card -->
    <div class="bg-surface-container-lowest rounded-xl border border-outline-variant/10 overflow-hidden shadow-2xl">
        <div class="p-6 border-b border-outline-variant/10 bg-surface-container/30">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-primary">edit_note</span>
                <h2 class="font-label text-xs uppercase tracking-widest text-primary">Thông tin đơn vị</h2>
            </div>
        </div>

        <form method="POST" action="{{ route('university-admin.departments.update', $department->id) }}" class="p-6">
            @csrf
            @method('PUT')

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
                               value="{{ old('department_name', $department->department_name) }}"
                               class="w-full bg-surface-container-lowest border-none shadow-inset-soft rounded-lg pl-12 pr-4 py-3 text-on-surface text-sm focus:ring-2 focus:ring-primary/50 transition-all"
                               placeholder="VD: Khoa Công nghệ Thông tin">
                    </div>
                </div>

                <!-- University Field -->
                <div class="space-y-2">
                    <label class="block font-label text-[10px] uppercase tracking-widest text-on-surface-variant" for="university_id">
                        Trường <span class="text-error">*</span>
                    </label>
                    <div class="relative">
                        <select name="university_id"
                                id="university_id"
                                class="w-full bg-surface-container-lowest border-none shadow-inset-soft rounded-lg px-4 py-3 text-on-surface text-sm appearance-none focus:ring-2 focus:ring-primary/50 transition-all cursor-pointer">
                            @foreach($universities as $university)
                                <option value="{{ $university->id }}"
                                    @selected(old('university_id', $department->university_id) == $university->id)>
                                    {{ $university->name ?? ('University #' . $university->id) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Department Code Display (Read-only) -->
                <div class="space-y-2 opacity-60">
                    <label class="block font-label text-[10px] uppercase tracking-widest text-on-surface-variant" for="department_code">
                        Mã khoa (Tự động)
                    </label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-lg">fingerprint</span>
                        <input type="text"
                               id="department_code"
                               value="{{ $department->department_code ?? 'Chưa có mã' }}"
                               class="w-full bg-surface-container-lowest border-none shadow-inset-soft rounded-lg pl-12 pr-4 py-3 text-on-surface text-sm cursor-not-allowed"
                               disabled readonly>
                    </div>
                    <p class="text-[10px] text-on-surface-variant/60 italic mt-1">
                        Mã khoa được hệ thống tự động tạo và không thể chỉnh sửa.
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
                    Cập nhật
                </button>
            </div>
        </form>
    </div>

    <!-- Danger Zone (Delete Section) - Optional -->
    <div class="mt-8 p-5 bg-error-container/5 rounded-xl border border-error-container/20">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-error-container/20 flex items-center justify-center text-error">
                    <span class="material-symbols-outlined">warning</span>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-error">Vùng nguy hiểm</h4>
                    <p class="text-xs text-on-surface-variant/70">Xóa khoa/viện này sẽ ảnh hưởng đến tất cả dữ liệu liên quan.</p>
                </div>
            </div>
            <form method="POST" action="{{ route('university-admin.departments.destroy', $department->id) }}" class="inline delete-form">
                @csrf
                @method('DELETE')
                <button type="button" class="delete-btn px-5 py-2 bg-error-container/20 text-error rounded-lg text-sm font-bold uppercase tracking-widest hover:bg-error-container/40 transition-all">
                    <span class="material-symbols-outlined text-sm align-middle mr-1">delete</span>
                    Xóa khoa/viện
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    // Delete confirmation
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('.delete-form');

            if (confirm('Bạn có chắc chắn muốn xóa khoa/viện này? Hành động này không thể hoàn tác và sẽ ảnh hưởng đến các chương trình đào tạo liên quan.')) {
                form.submit();
            }
        });
    });
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
