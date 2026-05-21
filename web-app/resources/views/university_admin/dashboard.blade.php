@extends('layouts.program_director')

@section('title', 'University Admin Dashboard | TechSyllabus')

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
                        University Admin Center / System Management
                    </p>
                </div>
                <h2 class="text-4xl font-headline font-bold tracking-tighter text-transparent bg-clip-text bg-gradient-to-r from-on-surface to-on-surface-variant">
                    University Admin Dashboard
                </h2>
                <p class="text-on-surface-variant font-body text-sm max-w-2xl">
                    Trung tâm quản lý hệ thống cấp đại học - Phân quyền tài khoản và quản lý cơ cấu viện/khoa.
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

        <!-- Stats Overview Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <!-- Card 1: Quản lý tài khoản và phân quyền -->
            <div class="group relative overflow-hidden rounded-2xl bg-surface-container-low border border-outline-variant/10 p-8 hover:border-primary/30 transition-all duration-300 hover:scale-[1.02]">
                <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-7xl">admin_panel_settings</span>
                </div>
                <div class="relative z-10">
                    <div class="w-14 h-14 rounded-xl bg-primary-container/20 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-primary text-3xl">manage_accounts</span>
                    </div>
                    <h3 class="text-xl font-bold text-on-surface mb-2">Quản lý tài khoản và phân quyền</h3>
                    <p class="text-sm text-on-surface-variant mb-6 leading-relaxed">
                        Quản lý người dùng toàn hệ thống, phân quyền truy cập theo vai trò (Admin, Trưởng viện, Giám đốc CTĐT, Giảng viên).
                    </p>
                    <a href="{{ route('university-admin.users.index') }}"
                       class="inline-flex items-center gap-2 text-primary font-label text-xs uppercase tracking-widest font-bold group-hover:gap-3 transition-all">
                        <span>Quản lý ngay</span>
                        <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </a>
                </div>
            </div>

            <!-- Card 2: Quản lý viện / khoa -->
            <div class="group relative overflow-hidden rounded-2xl bg-surface-container-low border border-outline-variant/10 p-8 hover:border-secondary/30 transition-all duration-300 hover:scale-[1.02]">
                <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-7xl">account_balance</span>
                </div>
                <div class="relative z-10">
                    <div class="w-14 h-14 rounded-xl bg-secondary-container/20 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-secondary text-3xl">business</span>
                    </div>
                    <h3 class="text-xl font-bold text-on-surface mb-2">Quản lý viện / khoa</h3>
                    <p class="text-sm text-on-surface-variant mb-6 leading-relaxed">
                        Cấu hình cơ cấu tổ chức, quản lý các viện và khoa đào tạo trực thuộc đại học.
                    </p>
                    <a href="{{ route('university-admin.departments.index') }}"
                       class="inline-flex items-center gap-2 text-secondary font-label text-xs uppercase tracking-widest font-bold group-hover:gap-3 transition-all">
                        <span>Quản lý ngay</span>
                        <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- System Monitoring Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
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
                        <span class="text-xs text-on-surface-variant">Cache System</span>
                        <span class="inline-flex items-center gap-1.5 text-[10px] text-primary font-bold uppercase">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
                            Active
                        </span>
                    </div>
                    <div class="flex justify-between items-center pt-2 border-t border-outline-variant/10">
                        <span class="text-xs text-on-surface-variant">Last Backup</span>
                        <span class="text-[10px] text-on-surface font-mono">{{ now()->format('d/m/Y H:i:s') }}</span>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="bg-surface-container-low rounded-2xl border border-outline-variant/10 overflow-hidden">
                <div class="p-6 border-b border-outline-variant/10">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-lg">analytics</span>
                        <h3 class="font-label text-xs uppercase tracking-widest text-outline font-bold">Thống kê hệ thống</h3>
                    </div>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-on-surface-variant">Tổng số người dùng</span>
                        <span class="text-lg font-bold text-primary">--</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-on-surface-variant">Số viện/khoa</span>
                        <span class="text-lg font-bold text-secondary">--</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-on-surface-variant">Chương trình đào tạo</span>
                        <span class="text-lg font-bold text-tertiary">--</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-on-surface-variant">Active Sessions</span>
                        <span class="text-lg font-bold text-primary">--</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity Section -->
        <div class="bg-surface-container-low rounded-2xl border border-outline-variant/10 overflow-hidden mb-8">
            <div class="p-6 border-b border-outline-variant/10">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-lg">history</span>
                    <h3 class="font-label text-xs uppercase tracking-widest text-outline font-bold">Hoạt động gần đây</h3>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="w-2 h-2 rounded-full bg-primary mt-2"></div>
                        <div class="flex-1">
                            <p class="text-sm text-on-surface font-medium">Chưa có hoạt động nào</p>
                            <p class="text-xs text-outline mt-1">Hệ thống đang chờ dữ liệu từ các tác vụ quản trị</p>
                        </div>
                        <span class="text-[10px] text-outline">--:--:--</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer / Technical Specs -->
        <div class="flex items-center justify-between border-t border-outline-variant/10 pt-6">
            <div class="flex gap-8">
                <div class="flex flex-col">
                    <span class="font-label text-[9px] uppercase tracking-widest text-outline">System Role</span>
                    <span class="text-[10px] font-bold text-primary flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span>
                        UNIVERSITY ADMINISTRATOR
                    </span>
                </div>
                <div class="flex flex-col">
                    <span class="font-label text-[9px] uppercase tracking-widest text-outline">Session ID</span>
                    <span class="text-[10px] font-mono text-on-surface">{{ substr(session()->getId(), 0, 8) }}...</span>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <button class="p-2 text-on-surface-variant hover:text-primary transition-colors" title="Documentation">
                    <span class="material-symbols-outlined text-sm">description</span>
                </button>
                <button class="p-2 text-on-surface-variant hover:text-primary transition-colors" title="Settings">
                    <span class="material-symbols-outlined text-sm">settings</span>
                </button>
                <button class="p-2 text-on-surface-variant hover:text-primary transition-colors" title="Refresh">
                    <span class="material-symbols-outlined text-sm">refresh</span>
                </button>
            </div>
        </div>
    </div>
</main>

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

    // Mouse-tracking spotlight effect for cards
    const cards = document.querySelectorAll('.bg-surface-container-low');
    cards.forEach(card => {
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            card.style.background = `radial-gradient(circle at ${x}px ${y}px, rgba(94, 106, 210, 0.08) 0%, rgba(28, 27, 29, 0.95) 60%)`;
        });
        card.addEventListener('mouseleave', () => {
            card.style.background = 'rgba(28, 27, 29, 0.6)';
        });
    });
</script>
@endsection
