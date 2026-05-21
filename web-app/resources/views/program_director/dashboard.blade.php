@extends('layouts.program_director')

@section('title', 'Dashboard Giám đốc CTĐT | TechSyllabus')

@section('content')
<!-- Main Content Canvas -->
<main class="ml-64 pt-24 px-8 pb-12 relative z-10 technical-grid min-h-screen">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
            <div class="space-y-2">
                <div class="flex items-center gap-2 mb-2">
                    <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                    <p class="font-label text-[10px] uppercase tracking-[0.2em] text-primary-fixed-dim">
                        Academic Command Center / Executive Dashboard
                    </p>
                </div>
                <h2 class="text-4xl font-headline font-bold tracking-tighter text-transparent bg-clip-text bg-gradient-to-r from-on-surface to-on-surface-variant">
                    Dashboard Giám đốc CTĐT
                </h2>
                <p class="text-on-surface-variant font-body text-sm max-w-2xl">
                    Trung tâm điều khiển học thuật - Quản lý và giám sát toàn bộ quy trình xây dựng đề cương môn học.
                </p>
            </div>
            <div>
                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                    @csrf
                    <button type="submit" class="group flex items-center gap-2 px-5 py-2.5 bg-error-container/20 text-error border border-error/30 rounded-lg font-label text-xs uppercase tracking-widest font-bold hover:bg-error-container/30 hover:border-error/50 transition-all duration-200">
                        <span class="material-symbols-outlined text-lg group-hover:rotate-180 transition-transform duration-300">logout</span>
                        Đăng xuất
                    </button>
                </form>
            </div>
        </div>

        <!-- Stats Overview Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <!-- Card 1: Tạo đề cương -->
            <div class="group relative overflow-hidden rounded-2xl bg-surface-container-low border border-outline-variant/10 p-6 hover:border-primary/30 transition-all duration-300">
                <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-6xl">description</span>
                </div>
                <div class="relative z-10">
                    <div class="w-12 h-12 rounded-xl bg-primary-container/20 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-primary text-2xl">add_circle</span>
                    </div>
                    <h3 class="text-lg font-bold text-on-surface mb-2">Tạo đề cương</h3>
                    <p class="text-sm text-on-surface-variant mb-6">Khởi tạo đề cương mới và phân công giảng viên phụ trách.</p>
                    <a href="{{ route('program_director.syllabus_shells.create') }}"
                       class="inline-flex items-center gap-2 text-primary font-label text-xs uppercase tracking-widest font-bold hover:gap-3 transition-all">
                        <span>Bắt đầu</span>
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>
            </div>

            <!-- Card 2: Danh sách đề cương -->
            <div class="group relative overflow-hidden rounded-2xl bg-surface-container-low border border-outline-variant/10 p-6 hover:border-primary/30 transition-all duration-300">
                <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-6xl">format_list_bulleted</span>
                </div>
                <div class="relative z-10">
                    <div class="w-12 h-12 rounded-xl bg-secondary-container/20 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-secondary text-2xl">inventory_2</span>
                    </div>
                    <h3 class="text-lg font-bold text-on-surface mb-2">Danh sách đề cương</h3>
                    <p class="text-sm text-on-surface-variant mb-6">Xem và quản lý tất cả đề cương đã tạo và phân công.</p>
                    <a href="{{ route('program_director.syllabus_shells.index') }}"
                       class="inline-flex items-center gap-2 text-secondary font-label text-xs uppercase tracking-widest font-bold hover:gap-3 transition-all">
                        <span>Xem danh sách</span>
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>
            </div>

            <!-- Card 3: Duyệt đề cương -->
            <div class="group relative overflow-hidden rounded-2xl bg-surface-container-low border border-outline-variant/10 p-6 hover:border-primary/30 transition-all duration-300">
                <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-6xl">fact_check</span>
                </div>
                <div class="relative z-10">
                    <div class="w-12 h-12 rounded-xl bg-tertiary-container/20 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-tertiary text-2xl">approval</span>
                    </div>
                    <h3 class="text-lg font-bold text-on-surface mb-2">Duyệt đề cương</h3>
                    <p class="text-sm text-on-surface-variant mb-6">Phê duyệt đề cương từ giảng viên và quản lý tiến độ.</p>
                    <a href="{{ route('program_director.syllabus_approvals.index') }}"
                       class="inline-flex items-center gap-2 text-tertiary font-label text-xs uppercase tracking-widest font-bold hover:gap-3 transition-all">
                        <span>Phê duyệt</span>
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Activity / System Status Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Actions Log -->
            <div class="bg-surface-container-low rounded-2xl border border-outline-variant/10 overflow-hidden">
                <div class="p-6 border-b border-outline-variant/10">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-lg">history</span>
                        <h3 class="font-label text-xs uppercase tracking-widest text-outline font-bold">Hoạt động gần đây</h3>
                    </div>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="w-2 h-2 rounded-full bg-primary mt-2"></div>
                        <div>
                            <p class="text-sm text-on-surface font-medium">Chưa có hoạt động nào</p>
                            <p class="text-xs text-outline mt-1">Hệ thống đang chờ dữ liệu từ giảng viên</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Status -->
            <div class="bg-surface-container-low rounded-2xl border border-outline-variant/10 overflow-hidden">
                <div class="p-6 border-b border-outline-variant/10">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-lg">computer</span>
                        <h3 class="font-label text-xs uppercase tracking-widest text-outline font-bold">Trạng thái hệ thống</h3>
                    </div>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-on-surface-variant">API Status</span>
                        <span class="inline-flex items-center gap-1.5 text-[10px] text-primary font-bold uppercase">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span>
                            Operational
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-on-surface-variant">Database Sync</span>
                        <span class="text-[10px] text-on-surface font-mono">Real-time</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-on-surface-variant">Last Backup</span>
                        <span class="text-[10px] text-on-surface font-mono">{{ now()->format('d M Y H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer / Technical Specs -->
        <div class="mt-12 flex items-center justify-between border-t border-outline-variant/10 pt-6">
            <div class="flex gap-8">
                <div class="flex flex-col">
                    <span class="font-label text-[9px] uppercase tracking-widest text-on-surface-variant">System Status</span>
                    <span class="text-[10px] font-bold text-primary flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span>
                        SYNCHRONIZED
                    </span>
                </div>
                <div class="flex flex-col">
                    <span class="font-label text-[9px] uppercase tracking-widest text-on-surface-variant">User Role</span>
                    <span class="text-[10px] font-bold text-on-surface">Program Director</span>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <button class="p-2 text-on-surface-variant hover:text-primary transition-colors" title="Help">
                    <span class="material-symbols-outlined text-sm">help</span>
                </button>
                <button class="p-2 text-on-surface-variant hover:text-primary transition-colors" title="Settings">
                    <span class="material-symbols-outlined text-sm">settings</span>
                </button>
            </div>
        </div>
    </div>
</main>

<script>
    // Auto-refresh status indicators (optional)
    const statusIndicator = document.querySelector('.animate-pulse');
    if (statusIndicator) {
        setInterval(() => {
            // Simulate heartbeat
            statusIndicator.classList.add('opacity-0');
            setTimeout(() => {
                statusIndicator.classList.remove('opacity-0');
            }, 300);
        }, 3000);
    }
</script>
@endsection
