@extends('layouts.department')

@section('title', 'Danh sách PI | Syllabus_System')

@section('content')
<!-- Main Content Area -->
<main class="flex-1 flex flex-col min-w-0 relative h-screen">
    <!-- TopAppBar -->
    <header class="fixed top-0 right-0 left-64 h-16 glass-panel border-b border-outline-variant/10 flex items-center justify-between px-8 z-40">
        <div class="flex items-center gap-4 text-sm">
            <span class="text-outline-variant uppercase font-label tracking-widest text-[10px]">Context:</span>
            <nav class="flex items-center gap-2">
                <span class="text-on-surface-variant">Program</span>
                <span class="material-symbols-outlined text-xs text-outline-variant">chevron_right</span>
                <span class="text-primary font-medium tracking-tight">{{ $program->name }}</span>
            </nav>
        </div>
        <div class="flex items-center gap-6">
            <div class="relative group">
                <span class="material-symbols-outlined text-on-surface-variant cursor-pointer hover:text-primary transition-colors">search</span>
            </div>
            <span class="material-symbols-outlined text-on-surface-variant cursor-pointer hover:text-primary transition-colors">notifications</span>
            <span class="material-symbols-outlined text-on-surface-variant cursor-pointer hover:text-primary transition-colors">settings</span>
        </div>
    </header>

    <!-- Scrollable Content -->
    <div class="mt-16 flex-1 overflow-y-auto custom-scrollbar p-8">
        <!-- Success Alert Block -->
        @if(session('success'))
        <div class="mb-8 transform transition-all duration-500 animate-in fade-in slide-in-from-top-4">
            <div class="bg-primary-container/10 border border-primary-container/20 rounded-xl p-4 flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-primary-container/20 flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined">check_circle</span>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-primary">Thành công</h4>
                    <p class="text-xs text-on-surface-variant">{{ session('success') }}</p>
                </div>
                <button class="ml-auto text-outline hover:text-on-surface transition-colors" onclick="this.closest('.mb-8').remove()">
                    <span class="material-symbols-outlined text-lg">close</span>
                </button>
            </div>
        </div>
        @endif

        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
            <div class="space-y-2">
                <div class="flex items-center gap-2 mb-1">
                    <a href="{{ route('department.programs.plos.index', $program->id) }}" class="text-[11px] font-label uppercase tracking-[0.2em] text-outline hover:text-primary transition-colors flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">arrow_back</span>
                        Quay lại PLO
                    </a>
                </div>
                <h2 class="text-4xl font-display font-bold tracking-tighter text-on-surface">Danh sách PI</h2>
                <div class="flex flex-wrap items-center gap-x-4 gap-y-2">
                    <div class="flex items-center gap-2 bg-surface-container-low px-3 py-1 rounded-full border border-outline-variant/10">
                        <span class="font-label uppercase text-[10px] text-primary tracking-widest">PLO Code</span>
                        <span class="text-sm font-medium">{{ $plo->code }}</span>
                    </div>
                    <div class="h-1 w-1 rounded-full bg-outline-variant/40 hidden md:block"></div>
                    <p class="text-on-surface-variant max-w-2xl text-sm leading-relaxed italic">
                        "{{ $plo->description }}"
                    </p>
                </div>
            </div>
            <a href="{{ route('department.programs.plos.pis.create', [$program->id, $plo->id]) }}" class="flex items-center justify-center gap-2 px-6 py-3 bg-primary-container text-on-primary-container font-bold rounded-lg shadow-extruded active:translate-y-1 active:shadow-none transition-all hover:brightness-110">
                <span class="material-symbols-outlined text-xl">add</span>
                <span>Thêm PI</span>
            </a>
        </div>

        <!-- Main Data Grid / Table -->
        <div class="grid grid-cols-1 gap-8">
            <div class="bg-surface-container-low border border-outline-variant/10 rounded-2xl overflow-hidden">
                <div class="p-6 border-b border-outline-variant/10 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-primary">data_array</span>
                        <h3 class="font-headline font-bold text-lg tracking-tight">Cấu trúc Performance Indicator</h3>
                    </div>
                    <div class="text-[10px] font-label uppercase text-outline tracking-widest">
                        Tổng số: {{ $pis->count() }} PI
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container-lowest/50 text-[11px] font-label uppercase tracking-[0.15em] text-outline-variant">
                                <th class="px-8 py-5 font-bold">Mã PI</th>
                                <th class="px-8 py-5 font-bold">Mô tả chi tiết</th>
                                <th class="px-8 py-5 font-bold text-right">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant/5">
                            @forelse($pis as $pi)
                            <tr class="group hover:bg-surface-container-high transition-colors">
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <div class="inline-flex items-center px-2.5 py-1 rounded bg-secondary-container/20 text-secondary font-label font-bold text-xs">
                                        {{ $pi->code }}
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <p class="text-on-surface text-sm leading-relaxed">{{ $pi->description }}</p>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('department.programs.plos.pis.edit', [$program->id, $plo->id, $pi->id]) }}" class="p-2 hover:bg-surface-variant rounded-lg text-primary transition-all" title="Chỉnh sửa">
                                            <span class="material-symbols-outlined text-lg">edit</span>
                                        </a>
                                        <form method="POST" action="{{ route('department.programs.plos.pis.destroy', [$program->id, $plo->id, $pi->id]) }}" class="inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="delete-btn p-2 hover:bg-error-container/20 rounded-lg text-error transition-all" title="Xóa">
                                                <span class="material-symbols-outlined text-lg">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-8 py-20 text-center">
                                    <div class="flex flex-col items-center gap-4 text-outline-variant">
                                        <span class="material-symbols-outlined text-5xl opacity-20">cloud_off</span>
                                        <p class="text-lg">Chưa có PI nào.</p>
                                        <a href="{{ route('programs.plos.pis.create', [$program->id, $plo->id]) }}" class="text-primary text-sm font-label uppercase underline underline-offset-4 tracking-widest hover:text-primary-fixed-dim">
                                            Khởi tạo PI đầu tiên
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 bg-surface-container-lowest/30 border-t border-outline-variant/10 text-[11px] font-label uppercase tracking-widest text-outline text-center">
                    End of Lab Results Container
                </div>
            </div>
        </div>

        <!-- Footer Spacer -->
        <div class="h-20"></div>
    </div>
</main>

<script>
    // Delete confirmation with animation
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('.delete-form');
            const row = this.closest('tr');

            if (confirm('Bạn có chắc chắn muốn xóa PI này?')) {
                if (row) {
                    row.classList.add('opacity-0', 'scale-95', 'translate-x-10');
                    setTimeout(() => {
                        form.submit();
                    }, 300);
                } else {
                    form.submit();
                }
            }
        });
    });

    // Spotlight Effect for Cards
    document.querySelectorAll('.bg-surface-container-low').forEach(card => {
        card.addEventListener('mousemove', e => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            card.style.setProperty('--x', `${x}px`);
            card.style.setProperty('--y', `${y}px`);
            card.style.background = `radial-gradient(400px circle at ${x}px ${y}px, rgba(189, 194, 255, 0.03), transparent 80%), #1c1b1d`;
        });
        card.addEventListener('mouseleave', () => {
            card.style.background = '#1c1b1d';
        });
    });
</script>
@endsection
