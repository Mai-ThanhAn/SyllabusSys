@extends('layouts.university_admin')

@section('title', 'Quản lý viện / khoa | Syllabus Lab')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="w-2 h-2 bg-primary rounded-full animate-pulse"></span>
                <span class="text-label-md font-label uppercase tracking-widest text-primary-fixed-dim">Department Management</span>
            </div>
            <h1 class="text-4xl font-display font-bold tracking-tighter text-on-surface">Quản lý viện / khoa</h1>
            <p class="text-on-surface-variant/70 mt-2 font-body max-w-2xl">
                Quản lý các đơn vị trực thuộc đại học, bao gồm khoa, viện và bộ môn. Phân công trưởng khoa và cập nhật thông tin.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <div class="px-4 py-2 bg-surface-container rounded-lg border border-outline-variant/10 flex items-center gap-3">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="font-label text-xs uppercase tracking-widest">Total: {{ $departments->count() }} Departments</span>
            </div>
            <a href="{{ route('university-admin.departments.create') }}" class="flex items-center justify-center gap-2 px-5 py-2.5 bg-primary-container text-on-primary-container font-bold rounded-lg shadow-extruded active:translate-y-1 active:shadow-none transition-all hover:brightness-110">
                <span class="material-symbols-outlined text-lg">add</span>
                <span class="font-label text-xs uppercase tracking-widest">Thêm viện/khoa</span>
            </a>
        </div>
    </div>

    <!-- Back Link -->
    <div class="mt-8">
        <a href="{{ route('university-admin.dashboard') }}" class="inline-flex items-center gap-2 text-on-surface-variant hover:text-primary transition-colors group">
            <span class="material-symbols-outlined text-sm group-hover:-translate-x-1 transition-transform">arrow_back</span>
            <span class="font-label text-xs uppercase tracking-widest">Quay lại dashboard</span>
        </a>
    </div>
<br>

    <!-- Session Feedback Messages -->
    @if(session('success'))
    <div class="mb-6 p-4 bg-primary-container/10 border-l-4 border-primary rounded-r-xl flex items-center gap-4 animate-in fade-in slide-in-from-top-4 duration-500">
        <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">check_circle</span>
        <p class="text-on-primary-container text-sm font-medium">{{ session('success') }}</p>
        <button class="ml-auto text-on-surface-variant hover:text-on-surface transition-colors" onclick="this.closest('.mb-6').remove()">
            <span class="material-symbols-outlined text-sm">close</span>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div class="mb-6 p-4 bg-error-container/10 border-l-4 border-error rounded-r-xl flex items-center gap-4 animate-in fade-in slide-in-from-top-4 duration-500">
        <span class="material-symbols-outlined text-error" style="font-variation-settings: 'FILL' 1;">error</span>
        <p class="text-on-error-container text-sm font-medium">{{ session('error') }}</p>
        <button class="ml-auto text-on-surface-variant hover:text-on-surface transition-colors" onclick="this.closest('.mb-6').remove()">
            <span class="material-symbols-outlined text-sm">close</span>
        </button>
    </div>
    @endif

    <!-- Data Table Container -->
    <div class="bg-surface-container-lowest rounded-xl border border-outline-variant/10 overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container/50 border-b border-outline-variant/10">
                        <th class="px-6 py-4 font-label text-[10px] uppercase tracking-[0.2em] text-on-surface-variant/60">ID</th>
                        <th class="px-6 py-4 font-label text-[10px] uppercase tracking-[0.2em] text-on-surface-variant/60">Mã</th>
                        <th class="px-6 py-4 font-label text-[10px] uppercase tracking-[0.2em] text-on-surface-variant/60">Tên viện/khoa</th>
                        <th class="px-6 py-4 font-label text-[10px] uppercase tracking-[0.2em] text-on-surface-variant/60">Viện trưởng/Khoa trưởng</th>
                        <th class="px-6 py-4 font-label text-[10px] uppercase tracking-[0.2em] text-on-surface-variant/60 text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/10">
                    @foreach($departments as $department)
                    <tr class="group hover:bg-surface-container/30 transition-colors">
                        <td class="px-6 py-5 font-label text-xs text-on-surface-variant">#{{ $department->id }}</td>
                        <td class="px-6 py-5">
                            <div class="inline-flex items-center px-2.5 py-1 rounded bg-secondary-container/40 text-secondary font-label font-bold text-xs">
                                {{ $department->department_code }}
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-primary-container/10 flex items-center justify-center text-primary">
                                    <span class="material-symbols-outlined text-lg">business</span>
                                </div>
                                <span class="text-sm font-semibold text-on-surface">{{ $department->department_name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-2">
                                @if($department->head)
                                <div class="w-6 h-6 rounded-full bg-outline-variant/20 flex items-center justify-center text-[10px] font-bold text-primary">
                                    {{ substr($department->head->full_name, 0, 1) }}
                                </div>
                                <span class="text-sm text-on-surface-variant">{{ $department->head->full_name }}</span>
                                @else
                                <span class="text-sm text-on-surface-variant/50 italic flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm">warning</span>
                                    Chưa bổ nhiệm
                                </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-5 text-right">
                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('university-admin.departments.edit', $department->id) }}" class="p-2 hover:bg-surface-variant rounded-lg text-primary transition-all" title="Sửa">
                                    <span class="material-symbols-outlined text-lg">edit</span>
                                </a>
                                <a href="{{ route('university-admin.departments.show', $department->id) }}" class="p-2 hover:bg-surface-variant rounded-lg text-secondary transition-all" title="Bổ nhiệm trưởng khoa">
                                    <span class="material-symbols-outlined text-lg">assignment_ind</span>
                                </a>
                                <form method="POST" action="{{ route('university-admin.departments.destroy', $department->id) }}" class="inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="delete-btn p-2 hover:bg-error-container/20 rounded-lg text-error transition-all" title="Xóa">
                                        <span class="material-symbols-outlined text-lg">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Technical Footer Metadata -->
        <div class="px-6 py-3 bg-surface-container/30 border-t border-outline-variant/10 flex justify-between items-center">
            <p class="font-label text-[9px] uppercase tracking-[0.3em] text-on-surface-variant/40">Department Management System v2.0</p>
            <div class="flex gap-2">
                <span class="w-1.5 h-1.5 rounded-full bg-primary/40"></span>
                <span class="w-1.5 h-1.5 rounded-full bg-primary/40"></span>
                <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
            </div>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
        <div class="bg-surface-container-low rounded-xl p-5 border border-outline-variant/5">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined">apartment</span>
                </div>
                <div>
                    <p class="text-[10px] font-label uppercase tracking-widest text-outline">Tổng số</p>
                    <p class="text-2xl font-bold text-on-surface">{{ $departments->count() }}</p>
                </div>
            </div>
            <p class="text-xs text-on-surface-variant/70">Đơn vị trực thuộc đại học</p>
        </div>
        <div class="bg-surface-container-low rounded-xl p-5 border border-outline-variant/5">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 rounded-lg bg-secondary/10 flex items-center justify-center text-secondary">
                    <span class="material-symbols-outlined">assignment_ind</span>
                </div>
                <div>
                    <p class="text-[10px] font-label uppercase tracking-widest text-outline">Đã bổ nhiệm</p>
                    <p class="text-2xl font-bold text-on-surface">{{ $departments->filter(function($dept) { return $dept->head_id !== null; })->count() }}</p>
                </div>
            </div>
            <p class="text-xs text-on-surface-variant/70">Đã có trưởng khoa</p>
        </div>
        <div class="bg-surface-container-low rounded-xl p-5 border border-outline-variant/5">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 rounded-lg bg-tertiary/10 flex items-center justify-center text-tertiary">
                    <span class="material-symbols-outlined">pending</span>
                </div>
                <div>
                    <p class="text-[10px] font-label uppercase tracking-widest text-outline">Chờ bổ nhiệm</p>
                    <p class="text-2xl font-bold text-on-surface">{{ $departments->filter(function($dept) { return $dept->head_id === null; })->count() }}</p>
                </div>
            </div>
            <p class="text-xs text-on-surface-variant/70">Cần bổ nhiệm trưởng khoa</p>
        </div>
    </div>
</div>

<script>
    // Delete confirmation with animation
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('.delete-form');
            const row = this.closest('tr');

            if (confirm('Bạn có chắc chắn muốn xóa khoa/viện này? Hành động này không thể hoàn tác.')) {
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

    // Auto-close alerts after 5 seconds
    setTimeout(() => {
        document.querySelectorAll('.bg-primary-container\\/10, .bg-error-container\\/10').forEach(alert => {
            if(alert) {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                setTimeout(() => alert.remove(), 300);
            }
        });
    }, 5000);
</script>

<style>
    .shadow-extruded {
        box-shadow: 0 2px 0 0 rgba(94, 106, 210, 0.4);
    }
</style>
@endsection
