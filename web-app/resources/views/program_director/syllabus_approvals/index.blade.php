@extends('layouts.app')

@section('title', 'Danh sách đề cương chờ duyệt | Syllabus Lab')

@section('content')
<main class="flex-1 flex flex-col h-screen relative overflow-y-auto">
    <!-- TopAppBar -->
    <header class="flex justify-between items-center w-full px-8 h-16 z-50 backdrop-blur-xl sticky top-0 bg-surface/80 border-b border-outline-variant/5">
        <div class="flex items-center gap-4">
            <div class="relative group">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-sm group-focus-within:text-primary transition-colors">search</span>
                <input class="bg-surface-container-lowest border-none shadow-inset-soft rounded-full pl-10 pr-4 py-1.5 text-sm w-64 focus:ring-1 focus:ring-primary/50 transition-all placeholder:text-on-surface-variant/50" placeholder="Search instrumentations..." type="text"/>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <button class="p-2 text-on-surface-variant hover:bg-surface-variant/20 rounded-full transition-colors active:scale-95 duration-150 relative">
                <span class="material-symbols-outlined">notifications</span>
                <span class="absolute top-2 right-2 w-2 h-2 bg-primary rounded-full border border-surface"></span>
            </button>
            <button class="p-2 text-on-surface-variant hover:bg-surface-variant/20 rounded-full transition-colors active:scale-95 duration-150">
                <span class="material-symbols-outlined">settings</span>
            </button>
            <div class="h-8 w-px bg-outline-variant/20 mx-2"></div>
            <button class="flex items-center gap-2 pl-2 pr-1 py-1 rounded-full hover:bg-surface-variant/20 transition-colors">
                <span class="text-sm font-medium text-on-surface">Program Director</span>
                <span class="material-symbols-outlined text-primary">account_circle</span>
            </button>
        </div>
    </header>

    <!-- Canvas -->
    <div class="p-8 max-w-7xl w-full mx-auto">
        <!-- Session Flash Message -->
        @if(session('success'))
        <div class="mb-8 transform transition-all duration-500 opacity-100" id="flash-message">
            <div class="bg-primary-container/10 border-l-4 border-primary p-4 rounded-r-xl flex items-center justify-between backdrop-blur-sm">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                    <p class="text-sm font-medium text-primary-fixed">{{ session('success') }}</p>
                </div>
                <button class="text-on-surface-variant hover:text-on-surface" onclick="document.getElementById('flash-message').classList.add('opacity-0', 'translate-y-2'); setTimeout(() => document.getElementById('flash-message').remove(), 500);">
                    <span class="material-symbols-outlined text-sm">close</span>
                </button>
            </div>
        </div>
        @endif

        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
            <div>
                <nav class="flex gap-2 mb-2">
                    <span class="font-label text-[10px] uppercase tracking-widest text-on-surface-variant/60">Orchestrator</span>
                    <span class="text-on-surface-variant/40 text-[10px]">/</span>
                    <span class="font-label text-[10px] uppercase tracking-widest text-primary/80">Approvals</span>
                </nav>
                <h2 class="text-4xl font-bold tracking-tight text-on-surface mb-2">Danh sách đề cương chờ duyệt</h2>
                <p class="text-on-surface-variant max-w-xl text-sm leading-relaxed">
                    Kiểm tra và phê duyệt các đề cương học thuật mới nhất từ các khoa. Dữ liệu được đồng bộ hóa với hệ thống quản lý phòng thí nghiệm kỹ thuật.
                </p>
            </div>
            <div class="flex gap-3">
                <button class="bg-surface-container-high border border-outline-variant/20 text-on-surface px-5 py-2.5 rounded-lg text-sm font-medium flex items-center gap-2 hover:bg-surface-variant/40 transition-colors">
                    <span class="material-symbols-outlined text-sm">filter_list</span>
                    Bộ lọc
                </button>
                <a href="{{ route('program-director.syllabus-shells.create') }}" class="bg-primary-container text-on-primary-container px-6 py-2.5 rounded-lg text-sm font-bold flex items-center gap-2 shadow-extruded hover:brightness-110 active:scale-95 transition-all">
                    <span class="material-symbols-outlined text-sm">add</span>
                    New Orchestration
                </a>
            </div>
        </div>

        <!-- Dashboard Grid / Data Table -->
        <div class="glass-panel rounded-2xl border border-outline-variant/10 overflow-hidden">
            <!-- Table Header Metadata -->
            <div class="px-6 py-4 border-b border-outline-variant/10 bg-surface-container-lowest/50 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                        <span class="font-label text-[10px] uppercase tracking-widest text-on-surface-variant">Live Instrumentation</span>
                    </div>
                    <span class="text-outline-variant text-xs">|</span>
                    <span class="text-xs text-on-surface-variant font-medium">{{ $approvals->count() }} entries detected</span>
                </div>
                <div class="flex gap-2">
                    <button class="p-1.5 hover:bg-surface-variant/20 rounded text-on-surface-variant"><span class="material-symbols-outlined text-sm">download</span></button>
                    <button class="p-1.5 hover:bg-surface-variant/20 rounded text-on-surface-variant"><span class="material-symbols-outlined text-sm">more_vert</span></button>
                </div>
            </div>

            <!-- Technical Data Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-surface-container-low/30">
                            <th class="px-6 py-4 font-label text-[10px] uppercase tracking-[0.2em] text-on-surface-variant/70 font-semibold border-b border-outline-variant/10">ID</th>
                            <th class="px-6 py-4 font-label text-[10px] uppercase tracking-[0.2em] text-on-surface-variant/70 font-semibold border-b border-outline-variant/10">Môn học</th>
                            <th class="px-6 py-4 font-label text-[10px] uppercase tracking-[0.2em] text-on-surface-variant/70 font-semibold border-b border-outline-variant/10">Chương trình</th>
                            <th class="px-6 py-4 font-label text-[10px] uppercase tracking-[0.2em] text-on-surface-variant/70 font-semibold border-b border-outline-variant/10">Version</th>
                            <th class="px-6 py-4 font-label text-[10px] uppercase tracking-[0.2em] text-on-surface-variant/70 font-semibold border-b border-outline-variant/10">Người gửi</th>
                            <th class="px-6 py-4 font-label text-[10px] uppercase tracking-[0.2em] text-on-surface-variant/70 font-semibold border-b border-outline-variant/10">Ngày gửi</th>
                            <th class="px-6 py-4 font-label text-[10px] uppercase tracking-[0.2em] text-on-surface-variant/70 font-semibold border-b border-outline-variant/10 text-right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/5">
                        @forelse($approvals as $approval)
                        <tr class="group hover:bg-primary-container/5 transition-colors">
                            <td class="px-6 py-5 font-label text-xs text-primary/80">#{{ str_pad($approval->id, 5, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-6 py-5">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-on-surface tracking-tight">
                                        {{ $approval->version->syllabus->course->course_code ?? '' }} - {{ $approval->version->syllabus->course->course_name ?? '' }}
                                    </span>
                                    <span class="text-[10px] text-on-surface-variant font-medium uppercase mt-1">Khoa {{ $approval->version->syllabus->course->program->name ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-secondary-container/30 text-secondary uppercase tracking-wider">
                                    {{ $approval->version->syllabus->course->program->name ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-6 py-5">
                                <span class="font-label text-xs font-medium text-tertiary">v{{ $approval->version->version_number }}</span>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-surface-variant flex items-center justify-center text-[10px] font-bold">
                                        {{ substr($approval->version->creator->full_name ?? 'N/A', 0, 2) }}
                                    </div>
                                    <span class="text-sm text-on-surface">{{ $approval->version->creator->full_name ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-5 text-sm text-on-surface-variant">{{ $approval->created_at->format('Y-m-d H:i') }}</td>
                            <td class="px-6 py-5 text-right">
                                <a href="{{ route('program-director.syllabus-approvals.show', $approval->id) }}" class="inline-flex items-center gap-2 text-primary hover:text-primary-fixed font-bold text-xs uppercase tracking-widest transition-all group-hover:translate-x-[-4px]">
                                    Xem chi tiết
                                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center opacity-40">
                                    <span class="material-symbols-outlined text-5xl mb-4">inventory_2</span>
                                    <p class="text-lg font-medium">Không có đề cương nào chờ duyệt.</p>
                                    <p class="text-sm">Tất cả các orchestrations đã được hoàn tất.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Technical Footer / Pagination -->
            <div class="px-6 py-4 bg-surface-container-low/20 border-t border-outline-variant/10 flex justify-between items-center">
                <p class="text-[10px] font-label uppercase tracking-widest text-on-surface-variant/60">System Ready: Monitoring 128 Curricula</p>
                <div class="flex items-center gap-4">
                    <span class="text-xs text-on-surface-variant">Page 1 of {{ ceil($approvals->total() / 10) ?? 1 }}</span>
                    <div class="flex gap-1">
                        <button class="w-8 h-8 flex items-center justify-center rounded border border-outline-variant/20 hover:bg-surface-variant/20 disabled:opacity-30">
                            <span class="material-symbols-outlined text-sm">chevron_left</span>
                        </button>
                        <button class="w-8 h-8 flex items-center justify-center rounded border border-outline-variant/20 hover:bg-surface-variant/20">
                            <span class="material-symbols-outlined text-sm">chevron_right</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- AI Insight Section (Digital Lab Aesthetic) -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-surface-container-lowest border-l-2 border-primary p-6 rounded-r-xl shadow-inset-soft">
                <h4 class="font-label text-[10px] uppercase tracking-widest text-primary mb-3">Priority Score</h4>
                <div class="flex items-end gap-2 mb-2">
                    <span class="text-3xl font-bold tracking-tighter">0.82</span>
                    <span class="text-xs text-on-surface-variant mb-1">High Volatility</span>
                </div>
                <div class="w-full bg-surface-variant/30 h-1 rounded-full overflow-hidden">
                    <div class="bg-primary w-[82%] h-full"></div>
                </div>
            </div>
            <div class="bg-surface-container-lowest border-l-2 border-secondary p-6 rounded-r-xl shadow-inset-soft">
                <h4 class="font-label text-[10px] uppercase tracking-widest text-secondary mb-3">Wait Time Avg</h4>
                <div class="flex items-end gap-2 mb-2">
                    <span class="text-3xl font-bold tracking-tighter">1.4</span>
                    <span class="text-xs text-on-surface-variant mb-1">Days in queue</span>
                </div>
                <div class="w-full bg-surface-variant/30 h-1 rounded-full overflow-hidden">
                    <div class="bg-secondary w-[40%] h-full"></div>
                </div>
            </div>
            <div class="bg-surface-container-lowest border-l-2 border-tertiary p-6 rounded-r-xl shadow-inset-soft">
                <h4 class="font-label text-[10px] uppercase tracking-widest text-tertiary mb-3">AI Mapping Integrity</h4>
                <div class="flex items-end gap-2 mb-2">
                    <span class="text-3xl font-bold tracking-tighter">98%</span>
                    <span class="text-xs text-on-surface-variant mb-1">CLO Compliance</span>
                </div>
                <div class="w-full bg-surface-variant/30 h-1 rounded-full overflow-hidden">
                    <div class="bg-tertiary w-[98%] h-full"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Decorative Lab Elements -->
    <div class="fixed bottom-10 left-10 opacity-10 pointer-events-none">
        <pre class="font-label text-[8px] text-primary">
            ORCHESTRATION_LAYER_01
            STATUS: ACTIVE
            DRONE_ID: SYLLABUS_PD_MAIN
            CLOCK: 1.254s
        </pre>
    </div>
</main>
@endsection

@push('scripts')
<script>
    // Micro-interactions for the "Digital Laboratory" feel
    document.querySelectorAll('tr').forEach(row => {
        row.addEventListener('mousemove', (e) => {
            const rect = row.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            row.style.setProperty('--mouse-x', `${x}px`);
            row.style.setProperty('--mouse-y', `${y}px`);
            // Adding a slight glow effect following mouse
            row.style.background = `radial-gradient(circle at ${x}px ${y}px, rgba(94, 106, 210, 0.05) 0%, transparent 70%)`;
        });
        row.addEventListener('mouseleave', () => {
            row.style.background = '';
        });
    });
</script>
@endpush
