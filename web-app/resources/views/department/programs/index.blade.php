@extends('layouts.department') {{-- Thay bằng layout thực tế của bạn --}}

@section('title', 'Quản lý chương trình đào tạo | TechSyllabus')

@section('content')
    <!-- Main Content Canvas -->
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
            <div class="space-y-1">
                <div class="flex items-center gap-2 mb-2">
                    <span class="w-2 h-2 rounded-full bg-primary-container"></span>
                    <p class="font-label text-[10px] uppercase tracking-[0.2em] text-primary-fixed-dim">
                        Program Management / Academic Catalog
                    </p>
                </div>
                <h2
                    class="text-3xl font-headline font-bold tracking-tighter text-transparent bg-clip-text bg-gradient-to-r from-on-surface to-on-surface-variant">
                    Quản lý chương trình đào tạo
                </h2>
                <p class="text-on-surface-variant font-body text-sm max-w-2xl">
                    Quản lý danh sách các chương trình đào tạo, bổ nhiệm giám đốc CTĐT và cấu hình PLO/PI.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('department.programs.create') }}"
                    class="group flex items-center gap-2 bg-primary-container text-on-primary-container px-5 py-2.5 rounded-lg font-label text-xs uppercase tracking-widest font-bold shadow-[0_4px_0_0_#2e3aa2] active:translate-y-1 active:shadow-none transition-all duration-75">
                    <span
                        class="material-symbols-outlined text-lg group-hover:rotate-90 transition-transform duration-300">add_circle</span>
                    Thêm chương trình đào tạo
                </a>
            </div>
        </div>

        <!-- Feedback Messages -->
        @if (session('success'))
            <div class="mb-8 p-4 bg-primary-container/10 border-l-2 border-primary-container rounded-r-xl flex items-center gap-4 animate-in fade-in slide-in-from-top-4 duration-500"
                id="success-alert">
                <span class="material-symbols-outlined text-primary">check_circle</span>
                <p class="text-sm font-medium text-on-primary-container tracking-tight">{{ session('success') }}</p>
                <button class="ml-auto text-outline hover:text-on-surface"
                    onclick="this.closest('#success-alert').remove()">
                    <span class="material-symbols-outlined text-[18px]">close</span>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-8 p-4 bg-error-container/10 border-l-2 border-error rounded-r-xl flex items-center gap-4">
                <span class="material-symbols-outlined text-error">error</span>
                <p class="text-sm font-medium text-on-error-container">{{ session('error') }}</p>
            </div>
        @endif

        <!-- Technical Data Grid (Table) -->
        <div class="glass-panel border border-outline-variant/10 rounded-2xl overflow-hidden shadow-2xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-surface-container-high/50 border-b border-outline-variant/10">
                            <th class="px-6 py-4 font-label text-[10px] uppercase tracking-widest text-outline">ID</th>
                            <th class="px-6 py-4 font-label text-[10px] uppercase tracking-widest text-outline">Mã CTĐT</th>
                            <th class="px-6 py-4 font-label text-[10px] uppercase tracking-widest text-outline">Tên CTĐT
                            </th>
                            <th class="px-6 py-4 font-label text-[10px] uppercase tracking-widest text-outline">Giám đốc
                                CTĐT</th>
                            <th class="px-6 py-4 font-label text-[10px] uppercase tracking-widest text-outline text-right">
                                Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/5">
                        @forelse($programs as $program)
                            <tr class="group hover:bg-surface-container-low transition-colors">
                                <td class="px-6 py-5 align-top">
                                    <span
                                        class="font-label text-sm font-bold text-primary/70 px-2 py-1 bg-primary/10 rounded border border-primary/20">
                                        #{{ $program->id }}
                                    </span>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="font-mono text-sm font-bold text-primary">{{ $program->code }}</span>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="text-sm text-on-surface font-medium max-w-md">{{ $program->name }}</div>
                                </td>
                                <td class="px-6 py-5">
                                    @if ($program->director)
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="material-symbols-outlined text-[14px] text-secondary">verified</span>
                                            <span class="text-sm text-on-surface">{{ $program->director->full_name }}</span>
                                        </div>
                                    @else
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="material-symbols-outlined text-[14px] text-outline">person_off</span>
                                            <span class="text-sm text-outline italic">Chưa bổ nhiệm</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <!-- Sửa -->
                                        <a href="{{ route('department.programs.edit', $program->id) }}"
                                            class="p-2 text-on-surface-variant hover:text-primary hover:bg-primary/10 rounded-lg transition-all group/tooltip"
                                            title="Sửa thông tin">
                                            <span class="material-symbols-outlined text-[20px]">edit_note</span>
                                        </a>

                                        <!-- Bổ nhiệm GĐ CTĐT -->
                                        <a href="{{ route('department.programs.show', $program->id) }}"
                                            class="p-2 text-on-surface-variant hover:text-secondary hover:bg-secondary/10 rounded-lg transition-all"
                                            title="Bổ nhiệm Giám đốc CTĐT">
                                            <span class="material-symbols-outlined text-[20px]">how_to_reg</span>
                                        </a>

                                        <!-- Quản lý PLO/PI -->
                                        <a href="{{ route('department.programs.plos.index', $program->id) }}"
                                            class="p-2 text-on-surface-variant hover:text-tertiary hover:bg-tertiary/10 rounded-lg transition-all"
                                            title="Quản lý PLO/PI">
                                            <span class="material-symbols-outlined text-[20px]">account_tree</span>
                                        </a>

                                        <!-- Xóa -->
                                        <form method="POST"
                                            action="{{ route('department.programs.destroy', $program->id) }}"
                                            class="inline delete-form" data-id="{{ $program->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="delete-btn p-2 text-error/60 hover:text-error hover:bg-error/10 rounded-lg transition-all"
                                                title="Xóa chương trình" data-name="{{ $program->name }}">
                                                <span class="material-symbols-outlined text-[20px]">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-24 text-center">
                                    <div class="flex flex-col items-center gap-4 opacity-40">
                                        <span class="material-symbols-outlined text-6xl">auto_stories</span>
                                        <p class="font-label text-sm uppercase tracking-widest">Chưa có chương trình đào tạo
                                            nào</p>
                                        <p class="text-xs text-outline">Bắt đầu bằng cách thêm chương trình đào tạo đầu
                                            tiên.</p>
                                        <a href="{{ route('department.programs.create') }}"
                                            class="mt-4 text-xs text-primary border border-primary/20 px-4 py-2 rounded hover:bg-primary/5 transition-all">
                                            Khởi tạo chương trình
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Terminal Accent Border -->
            <div class="h-1 bg-gradient-to-r from-transparent via-primary-container to-transparent opacity-30"></div>
        </div>


        <script>
            // Auto-close success alert after 5 seconds
            const successAlert = document.getElementById('success-alert');
            if (successAlert) {
                setTimeout(() => {
                    successAlert.style.opacity = '0';
                    successAlert.style.transform = 'translateY(-10px)';
                    setTimeout(() => {
                        successAlert?.remove();
                    }, 300);
                }, 5000);
            }

            // Delete confirmation with animation
            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const form = this.closest('.delete-form');
                    const programName = this.getAttribute('data-name') || 'chương trình này';
                    const row = this.closest('tr');

                    if (confirm(`Xác nhận xóa "${programName}"? Hành động này không thể hoàn tác.`)) {
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

            // Mouse-tracking spotlight effect for the table
            const tableContainer = document.querySelector('.glass-panel');
            if (tableContainer) {
                tableContainer.addEventListener('mousemove', (e) => {
                    const rect = tableContainer.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    tableContainer.style.setProperty('--mouse-x', `${x}px`);
                    tableContainer.style.setProperty('--mouse-y', `${y}px`);
                });
            }
        </script>
    @endsection
