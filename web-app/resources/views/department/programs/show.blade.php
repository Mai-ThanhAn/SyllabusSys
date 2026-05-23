@extends('layouts.department')

@section('title', 'Bổ nhiệm giám đốc CTĐT | TechSyllabus')

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
                <span class="text-label-md font-label uppercase tracking-widest text-primary-fixed-dim">Program Director</span>
            </div>
            <h1 class="text-4xl font-display font-bold tracking-tighter text-on-surface">Bổ nhiệm giám đốc CTĐT</h1>
            <p class="text-on-surface-variant/70 mt-2 font-body">
                Phân công người đứng đầu chương trình đào tạo.
            </p>
        </div>
    </div>

    <!-- Session Feedback Messages -->
    @if(session('success'))
    <div class="mb-6 p-4 bg-primary-container/10 border-l-4 border-primary rounded-r-xl flex items-center gap-4 animate-in fade-in slide-in-from-top-4 duration-500">
        <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">check_circle</span>
        <p class="text-on-primary-container text-sm font-medium">{{ session('success') }}</p>
        <button class="ml-auto text-on-surface-variant hover:text-on-surface transition-colors" onclick="this.closest('.mb-6').remove()">
            <span class="material-symbols-outlined text-sm">close</span>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div class="mb-6 p-4 bg-error-container/10 border-l-4 border-error rounded-r-xl flex items-center gap-4 animate-in fade-in slide-in-from-top-4 duration-500">
        <span class="material-symbols-outlined text-error" style="font-variation-settings: 'FILL' 1;">error</span>
        <p class="text-on-error-container text-sm font-medium">{{ session('error') }}</p>
        <button class="ml-auto text-on-surface-variant hover:text-on-surface transition-colors" onclick="this.closest('.mb-6').remove()">
            <span class="material-symbols-outlined text-sm">close</span>
        </button>
    </div>
    @endif

    <!-- Program Information Card -->
    <div class="bg-surface-container-low rounded-xl border border-outline-variant/10 overflow-hidden mb-8">
        <div class="p-6 border-b border-outline-variant/10 bg-surface-container/30">
            <h2 class="font-label text-xs uppercase tracking-widest text-primary">Thông tin chương trình</h2>
        </div>
        <div class="p-6 space-y-4">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="space-y-1">
                    <p class="text-[10px] font-label uppercase tracking-widest text-on-surface-variant/60">Mã CTĐT</p>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">fingerprint</span>
                        <span class="text-lg font-semibold text-on-surface">{{ $program->program_code }}</span>
                    </div>
                </div>
                <div class="space-y-1">
                    <p class="text-[10px] font-label uppercase tracking-widest text-on-surface-variant/60">Tên CTĐT</p>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-secondary">account_balance</span>
                        <span class="text-base text-on-surface-variant">{{ $program->program_name }}</span>
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-outline-variant/10">
                <p class="text-[10px] font-label uppercase tracking-widest text-on-surface-variant/60 mb-2">Giám đốc CTĐT hiện tại</p>
                <div class="flex items-center gap-3">
                    @if($program->director)
                    <div class="w-10 h-10 rounded-full bg-primary-container/20 flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary">person</span>
                    </div>
                    <div>
                        <p class="text-base font-semibold text-on-surface">{{ $program->director->full_name }}</p>
                        <p class="text-xs text-on-surface-variant/60">{{ $program->director->email }}</p>
                    </div>
                    @else
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-tertiary">warning</span>
                        <span class="text-base text-on-surface-variant/70 italic">Chưa bổ nhiệm giám đốc CTĐT</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Assignment Form Card -->
    <div class="bg-surface-container-lowest rounded-xl border border-outline-variant/10 overflow-hidden shadow-2xl">
        <div class="p-6 border-b border-outline-variant/10 bg-surface-container/30">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-secondary">assignment_ind</span>
                <h2 class="font-label text-xs uppercase tracking-widest text-secondary">Bổ nhiệm mới</h2>
            </div>
        </div>

        <form method="POST" action="{{ route('department.programs.assignDirector', $program->id) }}" class="p-6">
            @csrf

            <div class="space-y-6">
                <!-- User Selection -->
                <div class="space-y-2">
                    <label class="block font-label text-[10px] uppercase tracking-widest text-on-surface-variant" for="user_id">
                        Chọn tài khoản trong viện/khoa <span class="text-error">*</span>
                    </label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-lg">groups</span>
                        <select name="user_id"
                                id="user_id"
                                class="w-full bg-surface-container-lowest border-none shadow-inset-soft rounded-lg pl-12 pr-10 py-3 text-on-surface text-sm appearance-none focus:ring-2 focus:ring-primary/50 transition-all cursor-pointer">
                            <option value="">-- Chọn giảng viên --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->full_name }} - {{ $user->email }}
                                </option>
                            @endforeach
                        </select>
                        <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-outline pointer-events-none">
                            expand_more
                        </span>
                    </div>
                    <p class="text-[10px] text-on-surface-variant/60 italic mt-1">
                        Chỉ những tài khoản có vai trò giảng viên thuộc viện/khoa mới có thể được bổ nhiệm.
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end gap-4 pt-8 border-t border-outline-variant/10">
                    <a href="{{ route('department.programs.index') }}" class="px-5 py-2.5 rounded-lg text-sm font-label uppercase tracking-widest text-on-surface-variant hover:text-on-surface transition-colors">
                        Hủy bỏ
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-primary-container text-on-primary-container rounded-lg font-label text-sm font-bold uppercase tracking-widest shadow-extruded hover:brightness-110 transition-all">
                        <span class="material-symbols-outlined text-sm align-middle mr-1">assignment_ind</span>
                        Bổ nhiệm giám đốc CTĐT
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Info Note -->
    <div class="mt-6 p-4 bg-secondary-container/5 rounded-xl border border-secondary-container/10">
        <div class="flex gap-3">
            <span class="material-symbols-outlined text-secondary text-lg">info</span>
            <div>
                <p class="text-xs text-on-surface-variant leading-relaxed">
                    <strong class="text-secondary">Lưu ý:</strong> Giám đốc CTĐT sẽ có quyền quản lý và phê duyệt các đề cương thuộc chương trình này.
                    Việc bổ nhiệm sẽ cập nhật ngay lập tức và ảnh hưởng đến quyền hạn trong hệ thống.
                </p>
            </div>
        </div>
    </div>

    <!-- Additional Info Card -->
    <div class="mt-6 p-4 bg-surface-container-low/30 rounded-xl border border-outline-variant/5">
        <div class="flex items-center gap-2 mb-2">
            <span class="material-symbols-outlined text-tertiary text-sm">tips_and_updates</span>
            <span class="font-label text-[10px] uppercase tracking-widest text-tertiary">Trách nhiệm</span>
        </div>
        <ul class="text-xs text-on-surface-variant/70 space-y-1 list-disc list-inside">
            <li>Chịu trách nhiệm về chất lượng chương trình đào tạo</li>
            <li>Phê duyệt đề cương môn học thuộc chương trình</li>
            <li>Rà soát và cập nhật chuẩn đầu ra chương trình (PLO)</li>
            <li>Đảm bảo sự nhất quán giữa các môn học trong chương trình</li>
        </ul>
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

<script>
    // Auto-close alerts after 5 seconds
    setTimeout(() => {
        document.querySelectorAll('.bg-primary-container\\/10, .bg-error-container\\/10').forEach(alert => {
            if(alert) {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                setTimeout(() => alert.remove(), 300);
            }
        });
    }, 5000);
</script>
@endsection
