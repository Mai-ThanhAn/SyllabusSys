@extends('layouts.department')

@section('title', 'Sửa chương trình đào tạo | TechSyllabus')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header Section -->
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('department.programs.index') }}" class="p-2 hover:bg-surface-container rounded-lg transition-colors group">
            <span class="material-symbols-outlined text-on-surface-variant group-hover:text-primary transition-colors">arrow_back</span>
        </a>
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="w-2 h-2 bg-primary rounded-full animate-pulse"></span>
                <span class="text-label-md font-label uppercase tracking-widest text-primary-fixed-dim">Program Management</span>
            </div>
            <h1 class="text-4xl font-display font-bold tracking-tighter text-on-surface">Sửa chương trình đào tạo</h1>
            <p class="text-on-surface-variant/70 mt-2 font-body">
                Cập nhật thông tin chương trình đào tạo.
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
                <h2 class="font-label text-xs uppercase tracking-widest text-primary">Thông tin chương trình</h2>
            </div>
        </div>

        <form method="POST" action="{{ route('department.programs.update', $program->id) }}" class="p-6">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Program Code Field -->
                <div class="space-y-2">
                    <label class="block font-label text-[10px] uppercase tracking-widest text-on-surface-variant" for="program_code">
                        Mã CTĐT <span class="text-error">*</span>
                    </label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-lg">fingerprint</span>
                        <input type="text"
                               id="program_code"
                               name="program_code"
                               value="{{ old('program_code', $program->program_code) }}"
                               class="w-full bg-surface-container-lowest border-none shadow-inset-soft rounded-lg pl-12 pr-4 py-3 text-on-surface text-sm focus:ring-2 focus:ring-primary/50 transition-all"
                               placeholder="VD: SE_2024">
                    </div>
                    <p class="text-[10px] text-on-surface-variant/60 italic mt-1">
                        Mã chương trình đào tạo phải là duy nhất trong hệ thống.
                    </p>
                </div>

                <!-- Program Name Field -->
                <div class="space-y-2">
                    <label class="block font-label text-[10px] uppercase tracking-widest text-on-surface-variant" for="program_name">
                        Tên CTĐT <span class="text-error">*</span>
                    </label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-lg">account_balance</span>
                        <input type="text"
                               id="program_name"
                               name="program_name"
                               value="{{ old('program_name', $program->program_name) }}"
                               class="w-full bg-surface-container-lowest border-none shadow-inset-soft rounded-lg pl-12 pr-4 py-3 text-on-surface text-sm focus:ring-2 focus:ring-primary/50 transition-all"
                               placeholder="VD: Cử nhân Công nghệ Phần mềm">
                    </div>
                </div>
            </div>

            <!-- Current Info Display -->
            <div class="mt-6 p-4 bg-surface-container-low/50 rounded-xl border border-outline-variant/5">
                <div class="flex items-center gap-2 mb-2">
                    <span class="material-symbols-outlined text-secondary text-sm">info</span>
                    <span class="font-label text-[10px] uppercase tracking-widest text-secondary">Thông tin hiện tại</span>
                </div>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-on-surface-variant/60">Mã:</span>
                        <span class="text-primary font-mono ml-2">{{ $program->program_code }}</span>
                    </div>
                    <div>
                        <span class="text-on-surface-variant/60">Tên:</span>
                        <span class="text-on-surface ml-2">{{ $program->program_name }}</span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-4 pt-8 mt-6 border-t border-outline-variant/10">
                <a href="{{ route('department.programs.index') }}" class="px-5 py-2.5 rounded-lg text-sm font-label uppercase tracking-widest text-on-surface-variant hover:text-on-surface transition-colors">
                    Hủy bỏ
                </a>
                <button type="submit" class="px-6 py-2.5 bg-primary-container text-on-primary-container rounded-lg font-label text-sm font-bold uppercase tracking-widest shadow-extruded hover:brightness-110 transition-all">
                    <span class="material-symbols-outlined text-sm align-middle mr-1">save</span>
                    Cập nhật
                </button>
            </div>
        </form>
    </div>

    <!-- Danger Zone (Delete Section) -->
    <div class="mt-8 p-5 bg-error-container/5 rounded-xl border border-error-container/20">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-error-container/20 flex items-center justify-center text-error">
                    <span class="material-symbols-outlined">warning</span>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-error">Vùng nguy hiểm</h4>
                    <p class="text-xs text-on-surface-variant/70">Xóa chương trình này sẽ ảnh hưởng đến các môn học và đề cương liên quan.</p>
                </div>
            </div>
            <form method="POST" action="{{ route('department.programs.destroy', $program->id) }}" class="inline delete-form">
                @csrf
                @method('DELETE')
                <button type="button" class="delete-btn px-5 py-2 bg-error-container/20 text-error rounded-lg text-sm font-bold uppercase tracking-widest hover:bg-error-container/40 transition-all">
                    <span class="material-symbols-outlined text-sm align-middle mr-1">delete</span>
                    Xóa chương trình
                </button>
            </form>
        </div>
    </div>

    <!-- Info Note -->
    <div class="mt-6 p-4 bg-secondary-container/5 rounded-xl border border-secondary-container/10">
        <div class="flex gap-3">
            <span class="material-symbols-outlined text-secondary text-lg">info</span>
            <div>
                <p class="text-xs text-on-surface-variant leading-relaxed">
                    <strong class="text-secondary">Lưu ý:</strong> Việc thay đổi mã chương trình có thể ảnh hưởng đến các liên kết với môn học và khung đề cương hiện có.
                    Hãy cân nhắc trước khi cập nhật thông tin này.
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    // Delete confirmation
    const deleteBtn = document.querySelector('.delete-btn');
    if (deleteBtn) {
        deleteBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('.delete-form');

            if (confirm('Bạn có chắc chắn muốn xóa chương trình đào tạo này? Hành động này không thể hoàn tác và sẽ ảnh hưởng đến các môn học liên quan.')) {
                form.submit();
            }
        });
    }
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
