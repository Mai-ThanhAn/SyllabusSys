@extends('layouts.lecturer')

@section('title', 'Dashboard Giảng viên | Syllabus Lab')

@section('content')
<!-- Page Header -->
<div class="mb-10 flex items-end justify-between">
    <div>
        <h2 class="text-3xl font-bold text-on-surface tracking-[-0.04em] font-display mb-1">Dashboard Giảng viên</h2>
        <p class="text-on-surface-variant/70 font-display">Xin chào, <span class="text-primary font-medium">{{ Auth::user()->full_name ?? 'Giảng viên' }}</span></p>
    </div>
    <div class="flex gap-3">
        <div class="px-4 py-2 bg-surface-container border border-outline-variant/20 rounded-lg flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            <span class="text-xs font-label uppercase tracking-wider text-outline">Hệ thống: Online</span>
        </div>
    </div>
</div>

<!-- Session Alerts -->
@if(session('success'))
<div class="mb-6 flex items-center gap-4 p-4 bg-emerald-500/10 border-l-4 border-emerald-500 rounded-r-xl">
    <span class="material-symbols-outlined text-emerald-500">check_circle</span>
    <p class="text-sm text-emerald-200">{{ session('success') }}</p>
    <button class="ml-auto text-emerald-500/50 hover:text-emerald-500" onclick="this.closest('div').remove()">
        <span class="material-symbols-outlined text-sm">close</span>
    </button>
</div>
@endif

@if(session('error'))
<div class="mb-6 flex items-center gap-4 p-4 bg-error-container/20 border-l-4 border-error rounded-r-xl">
    <span class="material-symbols-outlined text-error">error</span>
    <p class="text-sm text-error">{{ session('error') }}</p>
    <button class="ml-auto text-error/50 hover:text-error" onclick="this.closest('div').remove()">
        <span class="material-symbols-outlined text-sm">close</span>
    </button>
</div>
@endif

<!-- Dashboard Statistics Bento Grid -->
<div class="grid grid-cols-4 gap-6 mb-8">
    <div class="col-span-1 bg-surface-container rounded-xl p-5 border border-outline-variant/10 relative overflow-hidden group">
        <div class="relative z-10">
            <p class="text-xs font-label uppercase tracking-widest text-outline mb-2">Tổng số đề cương</p>
            <h3 class="text-3xl font-bold text-on-surface font-display">{{ $assignments->count() }}</h3>
        </div>
        <span class="material-symbols-outlined absolute -right-4 -bottom-4 text-8xl text-outline/5 group-hover:text-primary/10 transition-colors">history_edu</span>
    </div>

    <div class="col-span-1 bg-surface-container rounded-xl p-5 border border-outline-variant/10 relative overflow-hidden group">
        <div class="relative z-10">
            <p class="text-xs font-label uppercase tracking-widest text-outline mb-2">Đang chờ duyệt</p>
            <h3 class="text-3xl font-bold text-tertiary font-display">
                {{ $assignments->filter(function($a) { return $a->syllabus?->status?->status_name === 'Submitted'; })->count() }}
            </h3>
        </div>
        <span class="material-symbols-outlined absolute -right-4 -bottom-4 text-8xl text-outline/5 group-hover:text-tertiary/10 transition-colors">pending_actions</span>
    </div>

    <div class="col-span-1 bg-surface-container rounded-xl p-5 border border-outline-variant/10 relative overflow-hidden group">
        <div class="relative z-10">
            <p class="text-xs font-label uppercase tracking-widest text-outline mb-2">Cần chỉnh sửa</p>
            <h3 class="text-3xl font-bold text-error font-display">
                {{ $assignments->filter(function($a) { return $a->syllabus?->status?->status_name === 'Rejected'; })->count() }}
            </h3>
        </div>
        <span class="material-symbols-outlined absolute -right-4 -bottom-4 text-8xl text-outline/5 group-hover:text-error/10 transition-colors">rule</span>
    </div>

    <div class="col-span-1 bg-primary-container/10 rounded-xl p-5 border border-primary-container/20 relative overflow-hidden group">
        <div class="relative z-10">
            <p class="text-xs font-label uppercase tracking-widest text-primary mb-2">Đã hoàn thành</p>
            <h3 class="text-3xl font-bold text-on-primary-container font-display">
                {{ $assignments->filter(function($a) { return $a->syllabus?->status?->status_name === 'Approved'; })->count() }}
            </h3>
        </div>
        <span class="material-symbols-outlined absolute -right-4 -bottom-4 text-8xl text-primary/5 group-hover:text-primary/10 transition-colors">verified</span>
    </div>
</div>

<!-- Central Assignment Data Grid -->
<div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/10 overflow-hidden shadow-2xl">
    <div class="px-6 py-5 border-b border-outline-variant/10 flex items-center justify-between bg-surface-container-low/50">
        <div class="flex items-center gap-3">
            <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">list_alt</span>
            <h3 class="font-display font-semibold text-lg text-on-surface">Danh sách phân công đề cương</h3>
        </div>
        <div class="flex gap-2">
            <button class="px-3 py-1.5 text-xs font-label uppercase tracking-wider text-outline hover:text-on-surface transition-colors">Lọc theo năm</button>
            <button class="px-3 py-1.5 text-xs font-label uppercase tracking-wider text-outline hover:text-on-surface transition-colors">Xuất Excel</button>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-surface-container-low/30">
                    <th class="px-6 py-4 text-[10px] font-label uppercase tracking-[0.15em] text-outline border-b border-outline-variant/10">Môn học</th>
                    <th class="px-6 py-4 text-[10px] font-label uppercase tracking-[0.15em] text-outline border-b border-outline-variant/10">Chương trình</th>
                    <th class="px-6 py-4 text-[10px] font-label uppercase tracking-[0.15em] text-outline border-b border-outline-variant/10 text-center">Năm học</th>
                    <th class="px-6 py-4 text-[10px] font-label uppercase tracking-[0.15em] text-outline border-b border-outline-variant/10">Vai trò</th>
                    <th class="px-6 py-4 text-[10px] font-label uppercase tracking-[0.15em] text-outline border-b border-outline-variant/10">Trạng thái</th>
                    <th class="px-6 py-4 text-[10px] font-label uppercase tracking-[0.15em] text-outline border-b border-outline-variant/10">Ghi chú duyệt</th>
                    <th class="px-6 py-4 text-[10px] font-label uppercase tracking-[0.15em] text-outline border-b border-outline-variant/10 text-right">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/5">
                @forelse($assignments as $assignment)
                    @php
                        $syllabus = $assignment->syllabus;
                        $course = $syllabus?->course;
                        $statusName = $syllabus?->status?->status_name ?? 'N/A';
                        $latestApproval = $syllabus?->approvals ? $syllabus->approvals->sortByDesc('created_at')->first() : null;
                    @endphp

                    <tr class="hover:bg-surface-container-highest/20 transition-colors group">
                        <td class="px-6 py-5">
                            <div class="flex flex-col">
                                <span class="text-sm font-semibold text-on-surface tracking-tight">
                                    {{ $course->course_code ?? '' }} - {{ $course->course_name ?? '' }}
                                </span>
                                <span class="text-[10px] text-outline font-label uppercase tracking-wider mt-0.5">
                                    Mã HP: {{ $course->course_code ?? 'N/A' }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <span class="text-xs text-on-surface-variant">{{ $course->program->name ?? 'N/A' }}</span>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <span class="text-xs font-mono text-outline">{{ $syllabus->academic_year ?? 'N/A' }}</span>
                        </td>
                        <td class="px-6 py-5">
                            <span class="px-2 py-1 rounded bg-secondary-container/20 text-secondary text-[10px] font-label uppercase tracking-wider">
                                {{ $assignment->assignment_role }}
                            </span>
                        </td>
                        <td class="px-6 py-5">
                            @if($statusName === 'Rejected')
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-error/10 text-error border border-error/20">
                                    <span class="w-1 h-1 rounded-full bg-error"></span>
                                    <span class="text-[10px] font-label uppercase tracking-wider">Từ chối</span>
                                </div>
                            @elseif($statusName === 'Approved')
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                    <span class="w-1 h-1 rounded-full bg-emerald-500"></span>
                                    <span class="text-[10px] font-label uppercase tracking-wider">Đã phê duyệt</span>
                                </div>
                            @elseif($statusName === 'Submitted')
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-tertiary/10 text-tertiary border border-tertiary/20">
                                    <span class="w-1 h-1 rounded-full bg-tertiary"></span>
                                    <span class="text-[10px] font-label uppercase tracking-wider">Chờ duyệt</span>
                                </div>
                            @else
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-outline-variant/20 text-outline border border-outline-variant/30">
                                    <span class="w-1 h-1 rounded-full bg-outline"></span>
                                    <span class="text-[10px] font-label uppercase tracking-wider">Chưa soạn</span>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-5">
                            @if($latestApproval?->comment)
                                <p class="text-xs text-on-surface-variant/70 italic max-w-xs truncate" title="{{ $latestApproval->comment }}">
                                    {{ Str::limit($latestApproval->comment, 50) }}
                                </p>
                            @else
                                <span class="text-xs text-outline/50">Không có</span>
                            @endif
                        </td>
                        <td class="px-6 py-5 text-right">
                            @if($statusName === 'Rejected')
                                <a href="{{ route('lecturer.syllabuses.edit', $syllabus->id) }}"
                                   class="text-xs font-semibold text-primary hover:underline decoration-primary/30 flex items-center justify-end gap-1">
                                    Sửa và gửi lại <span class="material-symbols-outlined text-sm">keyboard_arrow_right</span>
                                </a>
                            @elseif($statusName === 'Approved')
                                <span class="text-[10px] font-label uppercase tracking-widest text-outline bg-surface-container-high px-2 py-1 rounded">Đã duyệt</span>
                            @elseif($statusName === 'Submitted')
                                <span class="text-[10px] font-label uppercase tracking-widest text-tertiary/80">Đang chờ duyệt</span>
                            @else
                                <a href="{{ route('lecturer.syllabuses.edit', $syllabus->id) }}"
                                   class="px-4 py-1.5 bg-primary-container text-on-primary-container text-[10px] font-label uppercase tracking-widest rounded shadow-extruded hover:opacity-90 active:translate-y-0.5 transition-all inline-block">
                                    Soạn đề cương
                                </a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-24 h-24 mb-6 rounded-full bg-surface-container flex items-center justify-center border border-dashed border-outline-variant/30">
                                    <span class="material-symbols-outlined text-5xl text-outline/20">inbox</span>
                                </div>
                                <h4 class="text-lg font-semibold text-on-surface mb-2">Chưa có phân công</h4>
                                <p class="text-outline text-sm max-w-xs">Bạn chưa được giao đề cương nào trong hệ thống. Vui lòng liên hệ quản lý khoa.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Lab Activity Feed (Asymmetric Column) -->
<div class="mt-8 grid grid-cols-3 gap-8">
    <div class="col-span-2">
        <div class="bg-surface-container rounded-2xl p-6 border border-outline-variant/10">
            <div class="flex items-center justify-between mb-6">
                <h4 class="text-sm font-label uppercase tracking-widest text-on-surface flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-lg">terminal</span>
                    Nhật ký hệ thống (Học thuật)
                </h4>
                <span class="text-[10px] text-outline font-label uppercase tracking-tighter">Live Updates</span>
            </div>
            <div class="space-y-4 font-mono">
                <div class="flex gap-4 p-3 rounded bg-surface-container-lowest/50 border-l-2 border-primary">
                    <span class="text-[10px] text-primary/60">14:22:10</span>
                    <p class="text-xs text-on-surface-variant"><span class="text-secondary">[SERVER]</span> Đề cương đã được gửi cho Hội đồng chuyên môn.</p>
                </div>
                <div class="flex gap-4 p-3 rounded bg-surface-container-lowest/50 border-l-2 border-emerald-500">
                    <span class="text-[10px] text-emerald-500/60">09:15:45</span>
                    <p class="text-xs text-on-surface-variant"><span class="text-emerald-400">[AI_SCAN]</span> Phân tích ma trận CLO-PLO hoàn tất (Độ tương quan 94%).</p>
                </div>
                <div class="flex gap-4 p-3 rounded bg-surface-container-lowest/50 border-l-2 border-outline-variant">
                    <span class="text-[10px] text-outline/60">Hôm qua</span>
                    <p class="text-xs text-on-surface-variant"><span class="text-outline">[USER]</span> Bạn đã thay đổi cấu trúc chương trình môn học.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-span-1">
        <div class="bg-primary-container rounded-2xl p-6 relative overflow-hidden h-full flex flex-col justify-between">
            <div class="relative z-10">
                <h4 class="text-on-primary font-bold text-lg leading-tight mb-2">Trợ lý AI Lab</h4>
                <p class="text-on-primary/80 text-xs">Cần hỗ trợ ánh xạ chuẩn đầu ra (CLO) sang ma trận PLO? Lab AI luôn sẵn sàng hỗ trợ bạn.</p>
            </div>
            <button class="relative z-10 w-full mt-6 py-3 bg-on-primary text-primary-container font-label uppercase tracking-widest text-xs font-bold rounded-lg shadow-lg hover:scale-[1.02] active:scale-[0.98] transition-all">
                Bắt đầu Mapping
            </button>
            <span class="material-symbols-outlined absolute -bottom-8 -right-8 text-[160px] text-on-primary/10">auto_awesome</span>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto-close alerts after 5 seconds
    setTimeout(() => {
        document.querySelectorAll('.bg-emerald-500\\/10, .bg-error-container\\/20').forEach(alert => {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => alert.remove(), 300);
        });
    }, 5000);
</script>
@endpush
