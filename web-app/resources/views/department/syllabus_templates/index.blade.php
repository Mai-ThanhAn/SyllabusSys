@extends('layouts.department')

@section('title', 'Quản lý khung chuẩn đề cương | TechSyllabus')

@section('content')
    <style>
        /* Force dark theme for this page */
        .technical-grid {
            background: #0a0a0c;
            background-image:
                linear-gradient(rgba(94, 106, 210, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(94, 106, 210, 0.03) 1px, transparent 1px);
            background-size: 40px 40px;
        }

        .surface-container {
            background: rgba(28, 27, 29, 0.8);
            backdrop-filter: blur(10px);
        }

        .surface-container-low {
            background: rgba(28, 27, 29, 0.6);
        }

        .surface-container-lowest {
            background: rgba(32, 31, 33, 0.95);
        }

        .surface-container-high {
            background: rgba(40, 39, 42, 0.9);
        }

        .text-on-surface {
            color: #e6e6e6;
        }

        .text-on-surface-variant {
            color: #a1a1aa;
        }

        .text-outline {
            color: #71717a;
        }

        .border-outline-variant\/10 {
            border-color: rgba(113, 113, 122, 0.1);
        }

        .border-outline-variant\/20 {
            border-color: rgba(113, 113, 122, 0.2);
        }

        body,
        main {
            background: #0a0a0c;
        }
    </style>
    <!-- Header & Action Row -->
    <div class="max-w-7xl mx-auto">

        <section class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
            <div>
                <nav class="flex gap-2 text-[10px] font-label text-outline uppercase tracking-widest mb-2">
                    <a class="hover:text-primary" href="{{ route('department.syllabus-templates.index') }}">Console</a>
                    <span>/</span>
                    <span class="text-on-surface-variant">Templates</span>
                </nav>
                <h2 class="text-display-lg font-bold text-on-surface tracking-tighter leading-none">Quản lý khung đề cương
                </h2>
                <p class="text-on-surface-variant mt-3 max-w-2xl font-body">Ban chỉ có thể quản lý các đề cương thuộc viện của mình quản lý.
                </p>
            </div>
            <div>
                <a href="{{ route('department.syllabus-templates.create') }}"
                    class="group flex items-center gap-3 px-6 py-3 bg-primary text-on-primary rounded-lg font-bold text-sm shadow-extruded hover:brightness-110 active:scale-95 transition-all">
                    <span
                        class="material-symbols-outlined group-hover:rotate-90 transition-transform duration-300">add_circle</span>
                    Thêm khung đề cương
                </a>
            </div>
        </section>

        <!-- Dynamic Success Alert -->
        @if (session('success'))
            <div class="mb-8 overflow-hidden rounded-xl bg-primary-container/10 border-l-4 border-primary glass-panel p-4 flex items-start gap-4 animate-in fade-in slide-in-from-top-4 duration-500"
                id="success-alert">
                <span class="material-symbols-outlined text-primary"
                    style="font-variation-settings: 'FILL' 1;">check_circle</span>
                <div class="flex-1">
                    <p class="text-sm font-bold text-primary">Cập nhật thành công</p>
                    <p class="text-xs text-on-surface-variant mt-0.5">{{ session('success') }}</p>
                </div>
                <button class="text-outline hover:text-on-surface" onclick="this.closest('#success-alert').remove()">
                    <span class="material-symbols-outlined text-[18px]">close</span>
                </button>
            </div>
        @endif

        <!-- Technical Laboratory Data Table -->
        <div class="bg-surface-container rounded-xl overflow-hidden border border-outline-variant/10 shadow-xl">
            <div
                class="p-6 border-b border-outline-variant/10 flex items-center justify-between bg-surface-container-low/50">
                <div class="flex gap-4">
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-surface-container-lowest/50">
                        <tr>
                            <th class="px-6 py-4 font-label text-[10px] uppercase tracking-widest text-outline">ID</th>
                            <th class="px-6 py-4 font-label text-[10px] uppercase tracking-widest text-outline">Tên khung
                            </th>
                            <th class="px-6 py-4 font-label text-[10px] uppercase tracking-widest text-outline">Mô tả</th>
                            <th class="px-6 py-4 font-label text-[10px] uppercase tracking-widest text-outline">Trạng thái
                            </th>
                            <th class="px-6 py-4 font-label text-[10px] uppercase tracking-widest text-outline text-right">
                                Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/5">
                        @forelse($templates as $template)
                            <tr class="group hover:bg-surface-container-high/40 transition-colors"
                                data-id="{{ $template->id }}">
                                <td class="px-6 py-5 font-label text-xs text-primary/70">
                                    #TMP-{{ str_pad($template->id, 3, '0', STR_PAD_LEFT) }}</td>
                                <td class="px-6 py-5">
                                    <div class="font-bold text-on-surface text-sm">{{ $template->template_name }}</div>
                                    <div class="text-[10px] font-label text-outline uppercase mt-1">ID: {{ $template->id }}
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <p class="text-sm text-on-surface-variant line-clamp-1 max-w-xs">
                                        {{ $template->description ?? 'Chưa có mô tả' }}</p>
                                </td>
                                <td class="px-6 py-5">
                                    @if ($template->is_active)
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded bg-secondary-container/30 text-on-secondary-container text-[10px] font-bold uppercase tracking-wider">
                                            <span class="w-1 h-1 rounded-full bg-secondary mr-2"></span>
                                            Đang dùng
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded bg-surface-container-highest/50 text-outline text-[10px] font-bold uppercase tracking-wider border border-outline-variant/20">
                                            <span class="w-1 h-1 rounded-full bg-outline mr-2"></span>
                                            Tắt
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('department.syllabus-templates.edit', $template->id) }}"
                                            class="p-2 text-on-surface-variant hover:text-primary hover:bg-primary/10 rounded transition-all"
                                            title="Sửa">
                                            <span class="material-symbols-outlined text-[20px]">edit_square</span>
                                        </a>

                                        <a href="{{ route('department.syllabus-templates.sections.index', $template->id) }}"
                                            class="px-3 py-1.5 border border-outline-variant/20 rounded-lg font-label text-[10px] uppercase tracking-tighter text-on-surface-variant hover:bg-surface-container-highest hover:text-on-surface transition-all"
                                            title="Quản lý section">
                                            Manage Sections
                                        </a>

                                        <form method="POST"
                                            action="{{ route('department.syllabus-templates.destroy', $template->id) }}"
                                            class="inline delete-form" data-id="{{ $template->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="delete-btn p-2 text-error/60 hover:text-error hover:bg-error/10 rounded transition-all"
                                                title="Xóa">
                                                <span class="material-symbols-outlined text-[20px]">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-20 text-center text-outline italic">No templates found in
                                    active repository.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Footer Pagination / Technical Info -->
            <div
                class="p-4 bg-surface-container-lowest/30 flex flex-col md:flex-row justify-between items-center border-t border-outline-variant/5 gap-4">

                @if (isset($templates) && method_exists($templates, 'links'))
                    <div class="flex gap-1">
                        {{ $templates->links() }}
                    </div>
                @else
                    <div class="flex gap-1">
                        <button
                            class="w-8 h-8 flex items-center justify-center rounded border border-outline-variant/20 text-on-surface-variant hover:bg-surface-container-highest transition-colors">
                            <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                        </button>
                        <button
                            class="w-8 h-8 flex items-center justify-center rounded bg-primary text-on-primary font-label text-[10px] font-bold">1</button>
                        <button
                            class="w-8 h-8 flex items-center justify-center rounded border border-outline-variant/20 text-on-surface-variant hover:bg-surface-container-highest transition-colors font-label text-[10px]">2</button>
                        <button
                            class="w-8 h-8 flex items-center justify-center rounded border border-outline-variant/20 text-on-surface-variant hover:bg-surface-container-highest transition-colors font-label text-[10px]">3</button>
                        <button
                            class="w-8 h-8 flex items-center justify-center rounded border border-outline-variant/20 text-on-surface-variant hover:bg-surface-container-highest transition-colors">
                            <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // Delete confirmation with animation
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('.delete-form');
                const row = this.closest('tr');

                if (confirm('Executing permanent removal command. Are you sure?')) {
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

        // Auto-close success alert after 5 seconds
        const successAlert = document.getElementById('success-alert');
        if (successAlert) {
            setTimeout(() => {
                successAlert.style.opacity = '0';
                successAlert.style.transform = 'translateY(-10px)';
                setTimeout(() => {
                    successAlert.remove();
                }, 300);
            }, 5000);
        }
    </script>
@endpush
