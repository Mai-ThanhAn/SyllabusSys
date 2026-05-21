@extends('layouts.department')

@section('title', 'Danh sách PLO | Syllabus Lab')

@section('content')
<!-- Main Content Canvas -->
<main class="ml-64 pt-24 px-8 pb-12 relative z-10 technical-grid min-h-screen">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
        <div class="space-y-1">
            <div class="flex items-center gap-2 mb-2">
                <span class="w-2 h-2 rounded-full bg-primary-container"></span>
                <p class="font-label text-[10px] uppercase tracking-[0.2em] text-primary-fixed-dim">
                    Academic Architecture / PLO Mapping
                </p>
            </div>
            <h2 class="text-3xl font-headline font-bold tracking-tighter text-on-surface">
                Danh sách PLO
            </h2>
            <p class="text-on-surface-variant font-body flex items-center gap-2">
                <span class="opacity-50">Chương trình:</span>
                <span class="text-on-surface font-semibold">{{ $program->name }}</span>
            </p>
        </div>
        <a class="inline-flex items-center gap-2 bg-primary-container text-on-primary-container px-5 py-2.5 rounded-lg font-label text-xs uppercase tracking-widest font-bold shadow-[0_4px_0_0_#2e3aa2] active:translate-y-1 active:shadow-none transition-all duration-75"
           href="{{ route('programs.plos.create', $program->id) }}">
            <span class="material-symbols-outlined text-lg">add_circle</span>
            Thêm PLO
        </a>
    </div>

    <!-- Feedback Messages -->
    @if (session('success'))
        <div class="mb-8 p-4 bg-primary-container/10 border-l-2 border-primary-container rounded-r-xl flex items-center gap-4 animate-in fade-in slide-in-from-top-4 duration-500">
            <span class="material-symbols-outlined text-primary">check_circle</span>
            <p class="text-sm font-medium text-on-primary-container tracking-tight">{{ session('success') }}</p>
        </div>
    @endif

    <!-- Technical Data Grid (Table) -->
    <div class="glass-panel border border-outline-variant/10 rounded-2xl overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-high/50 border-b border-outline-variant/10">
                        <th class="px-6 py-4 font-label text-[10px] uppercase tracking-widest text-on-surface-variant">Mã PLO</th>
                        <th class="px-6 py-4 font-label text-[10px] uppercase tracking-widest text-on-surface-variant">Mô tả chi tiết</th>
                        <th class="px-6 py-4 font-label text-[10px] uppercase tracking-widest text-on-surface-variant text-right">Thao tác hệ thống</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/5">
                    @forelse($plos as $plo)
                        <tr class="hover:bg-surface-container-low transition-colors group">
                            <td class="px-6 py-5 align-top">
                                <span class="font-label text-sm font-bold text-primary px-2 py-1 bg-primary/10 rounded border border-primary/20">
                                    {{ $plo->code }}
                                </span>
                            </td>
                            <td class="px-6 py-5">
                                <p class="text-sm text-on-surface leading-relaxed max-w-2xl font-body">
                                    {{ $plo->description }}
                                </p>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <!-- Quản lý PI -->
                                    <a class="p-2 rounded-lg bg-surface-container hover:bg-surface-container-highest text-on-surface-variant hover:text-on-surface transition-all flex items-center justify-center group/btn"
                                       href="{{ route('programs.plos.pis.index', [$program->id, $plo->id]) }}"
                                       title="Quản lý PI">
                                        <span class="material-symbols-outlined text-sm">account_tree</span>
                                        <span class="max-w-0 overflow-hidden group-hover/btn:max-w-xs group-hover/btn:ml-2 transition-all duration-300 font-label text-[10px] uppercase tracking-tighter">Quản lý PI</span>
                                    </a>

                                    <!-- Sửa -->
                                    <a class="p-2 rounded-lg bg-surface-container hover:bg-surface-container-highest text-on-surface-variant hover:text-on-surface transition-all flex items-center justify-center group/btn"
                                       href="{{ route('programs.plos.edit', [$program->id, $plo->id]) }}"
                                       title="Sửa">
                                        <span class="material-symbols-outlined text-sm">edit_note</span>
                                        <span class="max-w-0 overflow-hidden group-hover/btn:max-w-xs group-hover/btn:ml-2 transition-all duration-300 font-label text-[10px] uppercase tracking-tighter">Sửa</span>
                                    </a>

                                    <!-- Xóa -->
                                    <form action="{{ route('programs.plos.destroy', [$program->id, $plo->id]) }}"
                                          method="POST"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="p-2 rounded-lg bg-error-container/10 hover:bg-error-container text-error transition-all flex items-center justify-center group/btn"
                                                onclick="return confirm('Xác nhận xóa PLO này?')"
                                                type="submit">
                                            <span class="material-symbols-outlined text-sm">delete</span>
                                            <span class="max-w-0 overflow-hidden group-hover/btn:max-w-xs group-hover/btn:ml-2 transition-all duration-300 font-label text-[10px] uppercase tracking-tighter">Xóa</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-6 py-24 text-center" colspan="3">
                                <div class="flex flex-col items-center gap-4 opacity-40">
                                    <span class="material-symbols-outlined text-6xl">inventory</span>
                                    <p class="font-label text-sm uppercase tracking-widest">Chưa có PLO nào trong hệ thống</p>
                                    <a href="{{ route('programs.plos.create', $program->id) }}"
                                       class="mt-4 text-xs text-primary border border-primary/20 px-4 py-2 rounded hover:bg-primary/5 transition-all">
                                        Khởi tạo dữ liệu mẫu
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Terminal Accent Border -->
        <div class="h-1 bg-linear-to-r from-transparent via-primary-container to-transparent opacity-30"></div>
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
                <span class="font-label text-[9px] uppercase tracking-widest text-on-surface-variant">Active Objects</span>
                <span class="text-[10px] font-bold text-on-surface">{{ count($plos) }} PLO Elements</span>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <button class="p-2 text-on-surface-variant hover:text-primary transition-colors">
                <span class="material-symbols-outlined text-sm">print</span>
            </button>
            <button class="p-2 text-on-surface-variant hover:text-primary transition-colors">
                <span class="material-symbols-outlined text-sm">download</span>
            </button>
        </div>
    </div>
</main>

<script>
    // Micro-interaction: Mouse-tracking spotlight on table
    document.addEventListener('mousemove', (e) => {
        const table = document.querySelector('.glass-panel');
        if (!table) return;
        const rect = table.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;

        table.style.setProperty('--mouse-x', `${x}px`);
        table.style.setProperty('--mouse-y', `${y}px`);
    });
</script>
@endsection
