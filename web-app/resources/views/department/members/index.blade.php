@extends('layouts.department') {{-- Thay bằng layout thực tế của bạn --}}

@section('title', 'Quản lý thành viên | TechSyllabus')

@section('content')
<!-- Main Content Canvas -->
<main class="ml-64 pt-24 px-8 pb-12 relative z-10 technical-grid min-h-screen">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
            <div class="space-y-1">
                <div class="flex items-center gap-2 mb-2">
                    <span class="w-2 h-2 rounded-full bg-primary-container"></span>
                    <p class="font-label text-[10px] uppercase tracking-[0.2em] text-primary-fixed-dim">
                        Faculty Management / Department Personnel
                    </p>
                </div>
                <h2 class="text-3xl font-headline font-bold tracking-tighter text-transparent bg-clip-text bg-gradient-to-r from-on-surface to-on-surface-variant">
                    Quản lý thành viên trong viện/khoa
                </h2>
                <p class="text-on-surface-variant font-body text-sm max-w-2xl">
                    Quản lý danh sách giảng viên và nhân sự, phân quyền và bổ nhiệm vai trò Program Director.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2 text-xs text-outline">
                    <span class="material-symbols-outlined text-sm">people</span>
                    <span>Tổng số: {{ $members->count() }} thành viên</span>
                </div>
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
                            <th class="px-6 py-4 font-label text-[10px] uppercase tracking-widest text-outline">Họ tên</th>
                            <th class="px-6 py-4 font-label text-[10px] uppercase tracking-widest text-outline">Email</th>
                            <th class="px-6 py-4 font-label text-[10px] uppercase tracking-widest text-outline">Role hiện tại</th>
                            <th class="px-6 py-4 font-label text-[10px] uppercase tracking-widest text-outline text-right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/5">
                        @forelse($members as $member)
                        <tr class="group hover:bg-surface-container-low transition-colors">
                            <td class="px-6 py-5 align-top">
                                <span class="font-label text-sm font-bold text-primary/70 px-2 py-1 bg-primary/10 rounded border border-primary/20">
                                    #{{ $member->id }}
                                </span>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-primary-container/20 flex items-center justify-center">
                                        <span class="material-symbols-outlined text-primary text-sm">person</span>
                                    </div>
                                    <div>
                                        <div class="text-sm text-on-surface font-medium">{{ $member->full_name }}</div>
                                        <div class="text-[10px] text-outline">{{ $member->username ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-[14px] text-outline">mail</span>
                                    <span class="text-sm text-on-surface-variant">{{ $member->email }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex flex-wrap gap-1.5">
                                    @forelse($member->roles as $role)
                                        @php
                                            $roleColor = match($role->role_name) {
                                                'Program Director' => 'bg-secondary-container/30 text-secondary border-secondary/20',
                                                'Department Admin' => 'bg-primary-container/30 text-primary border-primary/20',
                                                'Lecturer' => 'bg-tertiary-container/30 text-tertiary border-tertiary/20',
                                                default => 'bg-surface-container-highest/50 text-outline border-outline-variant/20'
                                            };
                                        @endphp
                                        <span class="inline-flex items-center px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider border {{ $roleColor }}">
                                            {{ $role->role_name }}
                                        </span>
                                    @empty
                                        <span class="inline-flex items-center px-2 py-1 rounded text-[10px] text-outline bg-surface-container-highest/50">
                                            Chưa có vai trò
                                        </span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <!-- Assign Program Director Button -->
                                    <form method="POST" action="{{ route('department.members.assignProgramDirector', $member->id) }}"
                                          class="inline assign-form"
                                          data-id="{{ $member->id }}">
                                        @csrf
                                        <button type="submit"
                                                class="assign-btn px-3 py-1.5 bg-secondary-container/20 text-secondary hover:bg-secondary-container/40 rounded-lg transition-all font-label text-[10px] uppercase tracking-wider flex items-center gap-1.5"
                                                title="Bổ nhiệm Program Director"
                                                data-name="{{ $member->full_name }}">
                                            <span class="material-symbols-outlined text-[14px">how_to_reg</span>
                                            Bổ nhiệm PD
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-24 text-center">
                                <div class="flex flex-col items-center gap-4 opacity-40">
                                    <span class="material-symbols-outlined text-6xl">group_off</span>
                                    <p class="font-label text-sm uppercase tracking-widest">Chưa có thành viên nào trong viện/khoa</p>
                                    <p class="text-xs text-outline">Vui lòng thêm thành viên hoặc đồng bộ từ hệ thống.</p>
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
            <a href="{{ route('department.dashboard') }}"
               class="group flex items-center gap-2 text-on-surface-variant hover:text-on-surface transition-colors text-sm font-label uppercase tracking-widest">
                <span class="material-symbols-outlined group-hover:-translate-x-1 transition-transform">arrow_back</span>
                Quay lại dashboard
            </a>
            <div class="flex gap-8">
                <div class="flex flex-col">
                    <span class="font-label text-[9px] uppercase tracking-widest text-outline">Total Members</span>
                    <span class="text-[10px] font-bold text-primary">{{ $members->count() }} Thành viên</span>
                </div>
                <div class="flex flex-col">
                    <span class="font-label text-[9px] uppercase tracking-widest text-outline">Program Directors</span>
                    <span class="text-[10px] font-bold text-secondary">
                        {{ $members->filter(fn($m) => $m->roles->contains('role_name', 'Program Director'))->count() }}
                        đã bổ nhiệm
                    </span>
                </div>
                <div class="flex flex-col">
                    <span class="font-label text-[9px] uppercase tracking-widest text-outline">Last Updated</span>
                    <span class="text-[10px] font-bold text-on-surface">{{ now()->format('d/m/Y H:i') }}</span>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <button class="p-2 text-on-surface-variant hover:text-primary transition-colors" title="Export Data">
                    <span class="material-symbols-outlined text-sm">download</span>
                </button>
                <button class="p-2 text-on-surface-variant hover:text-primary transition-colors" title="Print">
                    <span class="material-symbols-outlined text-sm">print</span>
                </button>
                <button class="p-2 text-on-surface-variant hover:text-primary transition-colors" title="Refresh">
                    <span class="material-symbols-outlined text-sm">refresh</span>
                </button>
            </div>
        </div>
    </div>
</main>

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

    // Assign Program Director confirmation with animation
    document.querySelectorAll('.assign-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = this.querySelector('.assign-btn');
            const memberName = btn?.getAttribute('data-name') || 'thành viên này';

            if (confirm(`Xác nhận bổ nhiệm "${memberName}" làm Program Director?`)) {
                this.submit();
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
