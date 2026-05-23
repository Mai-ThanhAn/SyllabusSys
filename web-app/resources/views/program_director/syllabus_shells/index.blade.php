@extends('layouts.program_director')

@section('title', 'Danh sách đề cương | TechSyllabus')

@section('content')
    <!-- Main Content Canvas -->
    <div class="flex justify-between items-end mb-10">
        <div class="max-w-[1600px] mx-auto">
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
                <div class="space-y-1">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="w-2 h-2 rounded-full bg-primary-container"></span>
                        <p class="font-label text-[10px] uppercase tracking-[0.2em] text-primary-fixed-dim">
                            Syllabus Repository / Academic Archive
                        </p>
                    </div>
                    <h2
                        class="text-3xl font-headline font-bold tracking-tighter text-transparent bg-clip-text bg-gradient-to-r from-on-surface to-on-surface-variant">
                        Danh sách đề cương đã tạo
                    </h2>
                    <p class="text-on-surface-variant font-body text-sm max-w-3xl">
                        Quản lý toàn bộ đề cương môn học đã được khởi tạo và phân công giảng viên.
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('program_director.syllabus_shells.create') }}"
                        class="group flex items-center gap-2 bg-primary-container text-on-primary-container px-5 py-2.5 rounded-lg font-label text-xs uppercase tracking-widest font-bold shadow-[0_4px_0_0_#2e3aa2] active:translate-y-1 active:shadow-none transition-all duration-75">
                        <span
                            class="material-symbols-outlined text-lg group-hover:rotate-90 transition-transform duration-300">add_circle</span>
                        Tạo đề cương mới
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

            <!-- Technical Data Grid (Table) -->
            <div class="glass-panel border border-outline-variant/10 rounded-2xl overflow-hidden shadow-2xl">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container-high/50 border-b border-outline-variant/10">
                                <th class="px-6 py-4 font-label text-[10px] uppercase tracking-widest text-outline">ID</th>
                                <th class="px-6 py-4 font-label text-[10px] uppercase tracking-widest text-outline">Môn học
                                </th>
                                <th class="px-6 py-4 font-label text-[10px] uppercase tracking-widest text-outline">CTĐT
                                </th>
                                <th class="px-6 py-4 font-label text-[10px] uppercase tracking-widest text-outline">Khung
                                </th>
                                <th class="px-6 py-4 font-label text-[10px] uppercase tracking-widest text-outline">Năm học
                                </th>
                                <th class="px-6 py-4 font-label text-[10px] uppercase tracking-widest text-outline">Trạng
                                    thái</th>
                                <th class="px-6 py-4 font-label text-[10px] uppercase tracking-widest text-outline">Giảng
                                    viên tham gia</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant/5">
                            @forelse($syllabuses as $syllabus)
                                <tr class="group hover:bg-surface-container-low transition-colors">
                                    <td class="px-6 py-5 align-top">
                                        <span
                                            class="font-label text-sm font-bold text-primary/70 px-2 py-1 bg-primary/10 rounded border border-primary/20">
                                            #{{ $syllabus->id }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="space-y-1">
                                            <div class="font-label text-xs font-bold text-primary">
                                                {{ $syllabus->course->course_code ?? 'N/A' }}</div>
                                            <div class="text-sm text-on-surface">
                                                {{ $syllabus->course->course_name ?? 'N/A' }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="space-y-1">
                                            <div class="font-label text-[10px] text-outline uppercase">
                                                {{ $syllabus->course->program->code ?? 'N/A' }}</div>
                                            <div class="text-xs text-on-surface-variant max-w-[200px]">
                                                {{ $syllabus->course->program->name ?? 'N/A' }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded bg-secondary-container/20 text-secondary text-[10px] font-bold uppercase tracking-wider">
                                            {{ $syllabus->template->template_name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span
                                            class="font-mono text-sm text-on-surface">{{ $syllabus->academic_year }}</span>
                                    </td>
                                    <td class="px-6 py-5">
                                        @php
                                            $statusName = $syllabus->status->status_name ?? 'N/A';
                                            $statusClass = match ($statusName) {
                                                'Draft' => 'bg-warning/10 text-warning border-warning/20',
                                                'Pending'
                                                    => 'bg-secondary-container/30 text-secondary border-secondary/20',
                                                'Approved' => 'bg-primary-container/30 text-primary border-primary/20',
                                                'Rejected' => 'bg-error-container/30 text-error border-error/20',
                                                default
                                                    => 'bg-surface-container-highest/50 text-outline border-outline-variant/20',
                                            };
                                        @endphp
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider border {{ $statusClass }}">
                                            <span
                                                class="w-1 h-1 rounded-full mr-1.5 {{ $statusName == 'Draft'
                                                    ? 'bg-warning'
                                                    : ($statusName == 'Pending'
                                                        ? 'bg-secondary'
                                                        : ($statusName == 'Approved'
                                                            ? 'bg-primary'
                                                            : ($statusName == 'Rejected'
                                                                ? 'bg-error'
                                                                : 'bg-outline'))) }}"></span>
                                            {{ $statusName }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="space-y-1.5">
                                            @forelse($syllabus->assignments as $assignment)
                                                <div class="flex items-center gap-2 text-xs">
                                                    <span
                                                        class="material-symbols-outlined text-[14px] text-secondary">person</span>
                                                    <span
                                                        class="text-on-surface font-medium">{{ $assignment->user->full_name ?? 'N/A' }}</span>
                                                    <span
                                                        class="text-[10px] text-outline uppercase px-1.5 py-0.5 rounded bg-surface-container-highest">
                                                        {{ $assignment->assignment_role }}
                                                    </span>
                                                </div>
                                            @empty
                                                <div class="flex items-center gap-2 text-xs text-outline/70">
                                                    <span class="material-symbols-outlined text-[14px]">warning</span>
                                                    <span>Chưa phân công</span>
                                                </div>
                                            @endforelse
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-24 text-center">
                                        <div class="flex flex-col items-center gap-4 opacity-40">
                                            <span class="material-symbols-outlined text-6xl">inventory_2</span>
                                            <p class="font-label text-sm uppercase tracking-widest">Chưa có đề cương nào</p>
                                            <a href="{{ route('program_director.syllabus_shells.create') }}"
                                                class="mt-4 text-xs text-primary border border-primary/20 px-4 py-2 rounded hover:bg-primary/5 transition-all">
                                                Khởi tạo đề cương đầu tiên
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
    </script>
@endsection
