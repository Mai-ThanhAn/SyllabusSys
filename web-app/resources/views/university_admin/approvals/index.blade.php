@extends('layouts.admin')

@section('title', 'Danh sách tài khoản chờ duyệt | Syllabus_System')

@section('content')
<!-- Header Section -->
<div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
    <div>
        <h2 class="font-headline font-bold text-3xl tracking-tighter text-transparent bg-clip-text bg-gradient-to-b from-on-surface to-on-surface-variant">
            Danh sách tài khoản chờ duyệt
        </h2>
        <p class="text-on-surface-variant/70 mt-2 font-body max-w-lg">
            Xử lý các yêu cầu đăng ký tài khoản mới cho hệ thống Syllabus_System. Vui lòng kiểm tra kỹ vai trò và thông tin học thuật.
        </p>
    </div>
    <div class="flex items-center gap-3">
        <div class="px-4 py-2 bg-surface-container rounded-lg border border-outline-variant/10 flex items-center gap-3">
            <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
            <span class="font-label text-xs uppercase tracking-widest">Active Queue: {{ $requests->count() }} Requests</span>
        </div>
    </div>
</div>

<!-- Session Feedback Messages -->
@if(session('success'))
<div class="mb-6 p-4 bg-primary-container/10 border-l-4 border-primary rounded-r-xl flex items-center gap-4 animate-in fade-in slide-in-from-top-4 duration-500">
    <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">check_circle</span>
    <p class="text-on-primary-container text-sm font-medium">{{ session('success') }}</p>
</div>
@endif

@if(session('error'))
<div class="mb-6 p-4 bg-error-container/10 border-l-4 border-error rounded-r-xl flex items-center gap-4 animate-in fade-in slide-in-from-top-4 duration-500">
    <span class="material-symbols-outlined text-error" style="font-variation-settings: 'FILL' 1;">error</span>
    <p class="text-on-error-container text-sm font-medium">{{ session('error') }}</p>
</div>
@endif

<!-- Data Table Container -->
<div class="bg-surface-container-lowest rounded-xl border border-outline-variant/10 overflow-hidden shadow-2xl">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-surface-container/50 border-b border-outline-variant/10">
                    <th class="px-6 py-4 font-label text-[10px] uppercase tracking-[0.2em] text-on-surface-variant/60">ID</th>
                    <th class="px-6 py-4 font-label text-[10px] uppercase tracking-[0.2em] text-on-surface-variant/60">Họ tên</th>
                    <th class="px-6 py-4 font-label text-[10px] uppercase tracking-[0.2em] text-on-surface-variant/60">Email</th>
                    <th class="px-6 py-4 font-label text-[10px] uppercase tracking-[0.2em] text-on-surface-variant/60">Vai trò</th>
                    <th class="px-6 py-4 font-label text-[10px] uppercase tracking-[0.2em] text-on-surface-variant/60">Ghi chú</th>
                    <th class="px-6 py-4 font-label text-[10px] uppercase tracking-[0.2em] text-on-surface-variant/60">Ngày gửi</th>
                    <th class="px-6 py-4 font-label text-[10px] uppercase tracking-[0.2em] text-on-surface-variant/60 text-right">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/10">
                @forelse($requests as $request)
                <tr class="hover:bg-surface-container/30 transition-colors group">
                    <td class="px-6 py-5 font-label text-xs text-on-surface-variant">#{{ $request->id }}</td>
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-outline-variant/20 flex items-center justify-center text-[10px] font-bold text-primary group-hover:bg-primary group-hover:text-on-primary transition-all duration-300">
                                {{ substr($request->user->full_name ?? 'N/A', 0, 1) }}
                            </div>
                            <span class="text-sm font-semibold text-on-surface">{{ $request->user->full_name ?? 'N/A' }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-5 text-sm text-on-surface-variant">{{ $request->user->email ?? 'N/A' }}</td>
                    <td class="px-6 py-5">
                        <span class="px-2.5 py-1 bg-secondary-container/40 text-on-secondary-container rounded-lg font-label text-[10px] uppercase tracking-wider">
                            {{ $request->requested_role }}
                        </span>
                    </td>
                    <td class="px-6 py-5">
                        <p class="text-xs text-on-surface-variant/60 italic max-w-[150px] truncate" title="{{ $request->note }}">
                            {{ $request->note ?? 'N/A' }}
                        </p>
                    </td>
                    <td class="px-6 py-5 font-label text-xs text-on-surface-variant">
                        {{ $request->created_at->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-5">
                        <div class="flex items-center justify-end gap-2">
                            <!-- Approve Action -->
                            <form method="POST" action="{{ route('admin.requests.approve', $request->id) }}" style="display:inline">
                                @csrf
                                <button class="px-4 py-1.5 bg-primary-container text-on-primary-container rounded-lg font-label text-[11px] font-bold uppercase tracking-widest shadow-extruded hover:-translate-y-0.5 transition-all" type="submit">
                                    Duyệt
                                </button>
                            </form>
                            <!-- Reject Trigger -->
                            <button class="p-1.5 border border-outline-variant/20 text-error hover:bg-error/10 rounded-lg transition-all" onclick="toggleRejectForm('reject-{{ $request->id }}')">
                                <span class="material-symbols-outlined text-lg">close</span>
                            </button>
                        </div>

                        <!-- Rejection Overlay/Form (Hidden by default) -->
                        <div class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-background/80 backdrop-blur-md p-4" id="reject-{{ $request->id }}">
                            <div class="bg-surface-container rounded-2xl w-full max-w-md p-6 border border-outline-variant/20 shadow-2xl transform transition-all">
                                <h3 class="font-headline font-bold text-xl mb-4 text-on-surface">Từ chối yêu cầu</h3>
                                <p class="text-sm text-on-surface-variant mb-6">Vui lòng cung cấp lý do cho người dùng <strong>{{ $request->user->full_name ?? 'N/A' }}</strong>.</p>
                                <form method="POST" action="{{ route('admin.requests.reject', $request->id) }}">
                                    @csrf
                                    <div class="mb-6">
                                        <label class="block font-label text-[10px] uppercase tracking-widest text-on-surface-variant/60 mb-2">Lý do từ chối</label>
                                        <textarea class="w-full bg-surface-container-lowest border-none shadow-inset-soft rounded-xl text-sm p-4 focus:ring-1 focus:ring-error/30 min-h-[120px]" name="reason" placeholder="VD: Thiếu chứng chỉ chuyên môn hoặc thông tin không trùng khớp..."></textarea>
                                    </div>
                                    <div class="flex gap-3 justify-end">
                                        <button class="px-6 py-2 text-sm font-label uppercase tracking-widest text-on-surface-variant hover:text-on-surface" type="button" onclick="toggleRejectForm('reject-{{ $request->id }}')">Hủy</button>
                                        <button class="px-6 py-2 bg-error-container text-on-error-container rounded-lg font-label text-xs font-bold uppercase tracking-widest shadow-extruded hover:bg-error transition-colors" type="submit">
                                            Xác nhận từ chối
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-20 text-center">
                        <div class="flex flex-col items-center gap-4">
                            <div class="w-20 h-20 rounded-full bg-surface-container flex items-center justify-center text-on-surface-variant/20 border border-outline-variant/5">
                                <span class="material-symbols-outlined text-4xl">inventory</span>
                            </div>
                            <p class="text-on-surface-variant/50 font-label tracking-wide">Không có tài khoản nào chờ duyệt.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Technical Footer Metadata -->
    <div class="px-6 py-3 bg-surface-container/30 border-t border-outline-variant/10 flex justify-between items-center">
        <p class="font-label text-[9px] uppercase tracking-[0.3em] text-on-surface-variant/40">Request Log Persistence: Enabled</p>
        <div class="flex gap-2">
            <span class="w-1.5 h-1.5 rounded-full bg-primary/40"></span>
            <span class="w-1.5 h-1.5 rounded-full bg-primary/40"></span>
            <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
        </div>
    </div>
</div>

<!-- Bento Side Stats (Asymmetric Layout) -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-8">
    <div class="lg:col-span-2 bg-surface-container-low rounded-xl p-6 border border-outline-variant/5 relative overflow-hidden group">
        <div class="absolute top-0 right-0 p-4 text-on-surface-variant/5">
            <span class="material-symbols-outlined text-8xl">assessment</span>
        </div>
        <h4 class="font-label text-[10px] uppercase tracking-widest text-primary mb-4">Approval Velocity</h4>
        <div class="flex items-end gap-1 h-24 mb-4">
            <div class="flex-1 bg-primary/10 rounded-t-sm h-12"></div>
            <div class="flex-1 bg-primary/20 rounded-t-sm h-16"></div>
            <div class="flex-1 bg-primary/40 rounded-t-sm h-20"></div>
            <div class="flex-1 bg-primary/60 rounded-t-sm h-14"></div>
            <div class="flex-1 bg-primary/80 rounded-t-sm h-24"></div>
            <div class="flex-1 bg-primary rounded-t-sm h-18"></div>
            <div class="flex-1 bg-primary-container rounded-t-sm h-22"></div>
        </div>
        <p class="text-xs text-on-surface-variant/70">Average response time: <span class="text-on-surface font-bold">2.4 hours</span> per academic request.</p>
    </div>
    <div class="bg-primary-container/10 rounded-xl p-6 border border-primary/20 flex flex-col justify-between shadow-2xl relative overflow-hidden">
        <div class="relative z-10">
            <h4 class="font-label text-[10px] uppercase tracking-widest text-primary mb-1">Queue Status</h4>
            <div class="text-4xl font-bold tracking-tighter text-on-surface mb-2">98.2%</div>
            <p class="text-xs text-on-surface-variant">SLA Compliance for Faculty Onboarding.</p>
        </div>
        <button class="relative z-10 w-full mt-6 py-2 bg-surface rounded-lg text-xs font-bold uppercase tracking-widest text-primary hover:bg-primary hover:text-on-primary transition-all">
            View Detailed Log
        </button>
        <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-primary blur-3xl opacity-20"></div>
    </div>
</div>

<script>
    function toggleRejectForm(id) {
        const modal = document.getElementById(id);
        if (modal.classList.contains('hidden')) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        } else {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }
    }
</script>
@endsection
