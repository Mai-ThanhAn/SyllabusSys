@extends('layouts.department')

@section('title', 'Dashboard Trưởng viện | TechSyllabus')

@section('content')
    <!-- Main Content Canvas -->
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
            <div class="space-y-2">
                <div class="flex items-center gap-2 mb-2">
                    <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                    <p class="font-label text-[10px] uppercase tracking-[0.2em] text-primary-fixed-dim">
                        Department Command Center / Faculty Administration
                    </p>
                </div>
                <h2
                    class="text-4xl font-headline font-bold tracking-tighter text-transparent bg-clip-text bg-gradient-to-r from-on-surface to-on-surface-variant">
                    Dashboard Trưởng viện
                </h2>
                <p class="text-on-surface-variant font-body text-sm max-w-2xl">
                    Trung tâm quản lý học thuật - Giám sát toàn bộ chương trình đào tạo, khung đề cương và nhân sự.
                </p>
            </div>
        </div>

        <!-- Stats Overview Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <!-- Card 1: Quản lý khung chuẩn đề cương -->
            <div
                class="group relative overflow-hidden rounded-2xl bg-surface-container-low border border-outline-variant/10 p-6 hover:border-primary/30 transition-all duration-300 hover:scale-[1.02]">
                <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-6xl">description</span>
                </div>
                <div class="relative z-10">
                    <div
                        class="w-12 h-12 rounded-xl bg-primary-container/20 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-primary text-2xl">dashboard_customize</span>
                    </div>
                    <h3 class="text-base font-bold text-on-surface mb-2">Khung chuẩn đề cương</h3>
                    <p class="text-xs text-on-surface-variant mb-4">Định nghĩa và quản lý cấu trúc đề cương chuẩn cho toàn
                        viện.</p>
                    <a href="{{ route('department.syllabus-templates.index') }}"
                        class="inline-flex items-center gap-1 text-primary font-label text-[10px] uppercase tracking-widest font-bold hover:gap-2 transition-all">
                        <span>Quản lý</span>
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>
            </div>

            <!-- Card 2: Quản lý chương trình đào tạo -->
            <div
                class="group relative overflow-hidden rounded-2xl bg-surface-container-low border border-outline-variant/10 p-6 hover:border-secondary/30 transition-all duration-300 hover:scale-[1.02]">
                <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-6xl">school</span>
                </div>
                <div class="relative z-10">
                    <div
                        class="w-12 h-12 rounded-xl bg-secondary-container/20 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-secondary text-2xl">auto_stories</span>
                    </div>
                    <h3 class="text-base font-bold text-on-surface mb-2">Chương trình đào tạo</h3>
                    <p class="text-xs text-on-surface-variant mb-4">Quản lý CTĐT, bổ nhiệm Giám đốc, thiết lập PLO/PI.</p>
                    <a href="{{ route('department.programs.index') }}"
                        class="inline-flex items-center gap-1 text-secondary font-label text-[10px] uppercase tracking-widest font-bold hover:gap-2 transition-all">
                        <span>Quản lý</span>
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>
            </div>

            <!-- Card 3: Quản lý môn học -->
            <div
                class="group relative overflow-hidden rounded-2xl bg-surface-container-low border border-outline-variant/10 p-6 hover:border-tertiary/30 transition-all duration-300 hover:scale-[1.02]">
                <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-6xl">menu_book</span>
                </div>
                <div class="relative z-10">
                    <div
                        class="w-12 h-12 rounded-xl bg-tertiary-container/20 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-tertiary text-2xl">library_books</span>
                    </div>
                    <h3 class="text-base font-bold text-on-surface mb-2">Môn học</h3>
                    <p class="text-xs text-on-surface-variant mb-4">Danh mục môn học, phân bổ giảng viên phụ trách.</p>
                    <a href="{{ route('department.courses.index') }}"
                        class="inline-flex items-center gap-1 text-tertiary font-label text-[10px] uppercase tracking-widest font-bold hover:gap-2 transition-all">
                        <span>Quản lý</span>
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>
            </div>

            <!-- Card 4: Quản lý thành viên -->
            <div
                class="group relative overflow-hidden rounded-2xl bg-surface-container-low border border-outline-variant/10 p-6 hover:border-primary/30 transition-all duration-300 hover:scale-[1.02]">
                <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-6xl">group</span>
                </div>
                <div class="relative z-10">
                    <div
                        class="w-12 h-12 rounded-xl bg-primary-container/20 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-primary text-2xl">people</span>
                    </div>
                    <h3 class="text-base font-bold text-on-surface mb-2">Thành viên viện/khoa</h3>
                    <p class="text-xs text-on-surface-variant mb-4">Quản lý giảng viên, phân quyền và vai trò học thuật.</p>
                    <a href="{{ route('department.members.index') }}"
                        class="inline-flex items-center gap-1 text-primary font-label text-[10px] uppercase tracking-widest font-bold hover:gap-2 transition-all">
                        <span>Quản lý</span>
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- System Status & Quick Actions Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
            <!-- System Status -->
            <div class="bg-surface-container-low rounded-2xl border border-outline-variant/10 overflow-hidden">
                <div class="p-6 border-b border-outline-variant/10">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-lg">computer</span>
                        <h3 class="font-label text-xs uppercase tracking-widest text-outline font-bold">Trạng thái hệ thống
                        </h3>
                    </div>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-on-surface-variant">Database Connection</span>
                        <span class="inline-flex items-center gap-1.5 text-[10px] text-primary font-bold uppercase">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span>
                            Connected
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-on-surface-variant">API Gateway</span>
                        <span class="inline-flex items-center gap-1.5 text-[10px] text-primary font-bold uppercase">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
                            Operational
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-on-surface-variant">Last Sync</span>
                        <span class="text-[10px] text-on-surface font-mono">{{ now()->format('d/m/Y H:i:s') }}</span>
                    </div>
                    <div class="flex justify-between items-center pt-2 border-t border-outline-variant/10">
                        <span class="text-xs text-on-surface-variant">User Role</span>
                        <span
                            class="text-[10px] bg-primary-container/30 text-primary px-2 py-1 rounded font-bold uppercase">Department
                            Admin</span>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="bg-surface-container-low rounded-2xl border border-outline-variant/10 overflow-hidden">
                <div class="p-6 border-b border-outline-variant/10">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-lg">analytics</span>
                        <h3 class="font-label text-xs uppercase tracking-widest text-outline font-bold">Thống kê nhanh</h3>
                    </div>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-on-surface-variant">Số chương trình đào tạo</span>
                        <span class="text-lg font-bold text-primary">--</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-on-surface-variant">Số môn học</span>
                        <span class="text-lg font-bold text-secondary">--</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-on-surface-variant">Số giảng viên</span>
                        <span class="text-lg font-bold text-tertiary">--</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-on-surface-variant">Khung đề cương</span>
                        <span class="text-lg font-bold text-primary">--</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer / Technical Specs -->
        <div class="flex items-center justify-between border-t border-outline-variant/10 pt-6">
            <div class="flex gap-8">
                <div class="flex flex-col">
                    <span class="font-label text-[9px] uppercase tracking-widest text-outline">System Status</span>
                    <span class="text-[10px] font-bold text-primary flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span>
                        SYNCHRONIZED
                    </span>
                </div>
                <div class="flex flex-col">
                    <span class="font-label text-[9px] uppercase tracking-widest text-outline">Session ID</span>
                    <span class="text-[10px] font-mono text-on-surface">{{ substr(session()->getId(), 0, 8) }}...</span>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <button class="p-2 text-on-surface-variant hover:text-primary transition-colors" title="Help">
                    <span class="material-symbols-outlined text-sm">help</span>
                </button>
                <button class="p-2 text-on-surface-variant hover:text-primary transition-colors" title="Settings">
                    <span class="material-symbols-outlined text-sm">settings</span>
                </button>
            </div>
        </div>

        <script>
            // Auto-refresh status indicator animation
            const statusIndicator = document.querySelector('.animate-pulse');
            if (statusIndicator) {
                setInterval(() => {
                    statusIndicator.style.opacity = '0.3';
                    setTimeout(() => {
                        statusIndicator.style.opacity = '1';
                    }, 300);
                }, 3000);
            }
        </script>
    @endsection
