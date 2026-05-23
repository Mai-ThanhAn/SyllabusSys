@extends('layouts.program_director')


@section('title', 'Danh sách đề cương chờ duyệt | Syllabus_System')

@section('content')
<main class="flex-1 flex flex-col h-screen relative overflow-y-auto">
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
                                <a href="{{ route('program_director.syllabus_approvals.show', $approval->id) }}" class="inline-flex items-center gap-2 text-primary hover:text-primary-fixed font-bold text-xs uppercase tracking-widest transition-all group-hover:translate-x-[-4px]">
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
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Technical Footer / Pagination -->
            <div class="px-6 py-4 bg-surface-container-low/20 border-t border-outline-variant/10 flex justify-between items-center">
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
