@extends('layouts.department')

@section('title', 'Quản lý môn học | TechSyllabus')

@section('content')
<!-- Main Content Canvas -->
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
            <div class="space-y-1">
                <div class="flex items-center gap-2 mb-2">
                    <span class="w-2 h-2 rounded-full bg-primary-container"></span>
                    <p class="font-label text-[10px] uppercase tracking-[0.2em] text-primary-fixed-dim">
                        Course Management / Academic Catalog
                    </p>
                </div>
                <h2 class="text-3xl font-headline font-bold tracking-tighter text-transparent bg-clip-text bg-gradient-to-r from-on-surface to-on-surface-variant">
                    Quản lý môn học
                </h2>
                <p class="text-on-surface-variant font-body text-sm max-w-2xl">
                    Quản lý danh sách môn học, thông tin tín chỉ và chương trình đào tạo liên kết.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('department.courses.create') }}"
                   class="group flex items-center gap-2 bg-primary-container text-on-primary-container px-5 py-2.5 rounded-lg font-label text-xs uppercase tracking-widest font-bold shadow-[0_4px_0_0_#2e3aa2] active:translate-y-1 active:shadow-none transition-all duration-75">
                    <span class="material-symbols-outlined text-lg group-hover:rotate-90 transition-transform duration-300">add_circle</span>
                    Thêm môn học
                </a>
            </div>
        </div>

        <!-- Feedback Messages -->
        @if(session('success'))
        <div class="mb-8 p-4 bg-primary-container/10 border-l-2 border-primary-container rounded-r-xl flex items-center gap-4 animate-in fade-in slide-in-from-top-4 duration-500" id="success-alert">
            <span class="material-symbols-outlined text-primary">check_circle</span>
            <p class="text-sm font-medium text-on-primary-container tracking-tight">{{ session('success') }}</p>
            <button class="ml-auto text-outline hover:text-on-surface" onclick="this.closest('#success-alert').remove()">
                <span class="material-symbols-outlined text-[18px]">close</span>
            </button>
        </div>
        @endif

        @if(session('error'))
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
                            <th class="px-6 py-4 font-label text-[10px] uppercase tracking-widest text-outline">Mã môn</th>
                            <th class="px-6 py-4 font-label text-[10px] uppercase tracking-widest text-outline">Tên môn học</th>
                            <th class="px-6 py-4 font-label text-[10px] uppercase tracking-widest text-outline text-center">Số tín chỉ</th>
                            <th class="px-6 py-4 font-label text-[10px] uppercase tracking-widest text-outline">CTĐT</th>
                            <th class="px-6 py-4 font-label text-[10px] uppercase tracking-widest text-outline text-right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/5">
                        @forelse($courses as $course)
                        <tr class="group hover:bg-surface-container-low transition-colors">
                            <td class="px-6 py-5 align-top">
                                <span class="font-label text-sm font-bold text-primary/70 px-2 py-1 bg-primary/10 rounded border border-primary/20">
                                    #{{ $course->id }}
                                </span>
                            </td>
                            <td class="px-6 py-5">
                                <span class="font-mono text-sm font-bold text-primary">{{ $course->course_code }}</span>
                            </td>
                            <td class="px-6 py-5">
                                <div class="text-sm text-on-surface font-medium max-w-md">{{ $course->course_name }}</div>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <span class="inline-flex items-center justify-center w-12 px-2 py-1 rounded-full bg-secondary-container/30 text-secondary text-sm font-bold">
                                    {{ $course->credits }}
                                </span>
                            </td>
                            <td class="px-6 py-5">
                                <div class="space-y-1">
                                    <div class="font-label text-[10px] text-outline uppercase">{{ $course->program->code ?? 'N/A' }}</div>
                                    <div class="text-xs text-on-surface-variant max-w-[250px]">{{ $course->program->name ?? 'Chưa liên kết CTĐT' }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <!-- Sửa -->
                                    <a href="{{ route('department.courses.edit', $course->id) }}"
                                       class="p-2 text-on-surface-variant hover:text-primary hover:bg-primary/10 rounded-lg transition-all group/tooltip"
                                       title="Sửa môn học">
                                        <span class="material-symbols-outlined text-[20px]">edit_note</span>
                                    </a>

                                    <!-- Xóa -->
                                    <form method="POST" action="{{ route('department.courses.destroy', $course->id) }}"
                                          class="inline delete-form"
                                          data-id="{{ $course->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                                class="delete-btn p-2 text-error/60 hover:text-error hover:bg-error/10 rounded-lg transition-all"
                                                title="Xóa môn học"
                                                data-name="{{ $course->course_name }}">
                                            <span class="material-symbols-outlined text-[20px]">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-24 text-center">
                                <div class="flex flex-col items-center gap-4 opacity-40">
                                    <span class="material-symbols-outlined text-6xl">menu_book</span>
                                    <p class="font-label text-sm uppercase tracking-widest">Chưa có môn học nào</p>
                                    <p class="text-xs text-outline">Bắt đầu bằng cách thêm môn học đầu tiên vào hệ thống.</p>
                                    <a href="{{ route('department.courses.create') }}"
                                       class="mt-4 text-xs text-primary border border-primary/20 px-4 py-2 rounded hover:bg-primary/5 transition-all">
                                        Khởi tạo môn học
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

        <!-- Footer Navigation & Stats -->
        <div class="mt-8 flex flex-col md:flex-row md:items-center justify-between gap-4 border-t border-outline-variant/10 pt-6">
            <div class="flex gap-8">
                <div class="flex flex-col">
                    <span class="font-label text-[9px] uppercase tracking-widest text-outline">Total Courses</span>
                    <span class="text-[10px] font-bold text-primary">{{ $courses->count() }} Môn học</span>
                </div>
                <div class="flex flex-col">
                    <span class="font-label text-[9px] uppercase tracking-widest text-outline">Total Credits</span>
                    <span class="text-[10px] font-bold text-secondary">{{ $courses->sum('credits') }} Tín chỉ</span>
                </div>
                <div class="flex flex-col">
                    <span class="font-label text-[9px] uppercase tracking-widest text-outline">Last Updated</span>
                    <span class="text-[10px] font-bold text-on-surface">{{ now()->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </div>
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
            const courseName = this.getAttribute('data-name') || 'môn học này';
            const row = this.closest('tr');

            if (confirm(`Xác nhận xóa "${courseName}"? Hành động này không thể hoàn tác.`)) {
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
