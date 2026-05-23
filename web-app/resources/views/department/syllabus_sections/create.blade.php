@extends('layouts.department')

@section('title', 'Thêm section | TechSyllabus')

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
    <!-- Main Content Canvas -->
    <div class="max-w-7xl mx-auto">
        <!-- Page Content -->
        <div class="mt-16 p-10 max-w-5xl mx-auto w-full flex flex-col gap-8 pb-20">
            <!-- Breadcrumb & Header Info -->
            <div class="flex flex-col gap-2">
                <span class="font-label text-[10px] text-primary tracking-[0.2em] uppercase">Technical Configuration</span>
                <div class="flex items-center justify-between">
                    <h2 class="text-3xl font-display font-bold text-on-surface tracking-tighter">Tạo Mới Mục</h2>
                    <div class="px-4 py-1.5 bg-primary-container/10 border border-primary-container/20 rounded-full">
                        <span class="text-xs font-label text-primary uppercase tracking-wider">Template:
                            {{ $template->template_name }}</span>
                    </div>
                </div>
            </div>

            <!-- Error Notifications (Validation States) -->
            @if ($errors->any())
                <div class="bg-error-container/10 border-l-4 border-error rounded-xl p-4 flex gap-4 items-start shadow-lg">
                    <div class="mt-0.5">
                        <span class="material-symbols-outlined text-error"
                            style="font-variation-settings: 'FILL' 1;">Tên Mục</span>
                    </div>
                    <div class="flex-1">
                        <p class="font-headline font-bold text-error text-sm uppercase tracking-wide">Configuration
                            Conflicts Detected</p>
                        <ul class="mt-2 space-y-1 text-xs text-on-error-container opacity-80 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Main Form Surface -->
            <form action="{{ route('department.syllabus-templates.sections.store', $template->id) }}"
                class="grid grid-cols-12 gap-8" method="POST">
                @csrf

                <!-- Left Column: Primary Fields -->
                <div class="col-span-12 lg:col-span-8 space-y-6">
                    <div
                        class="bg-surface-container rounded-xl p-8 border border-outline-variant/10 relative overflow-hidden group">
                        <!-- Ambient Light Glow -->
                        <div
                            class="absolute -top-24 -right-24 w-48 h-48 bg-primary-container/10 blur-[80px] group-hover:bg-primary-container/20 transition-all duration-700">
                        </div>

                        <div class="relative flex flex-col gap-6">
                            <!-- Section Title -->
                            <div class="space-y-2">
                                <label class="font-label text-[10px] text-outline uppercase tracking-widest"
                                    for="title">Tên Mục</label>
                                <input
                                    class="w-full bg-surface-container-lowest neo-input rounded-lg px-4 py-3 text-sm text-on-surface placeholder:text-outline-variant/60"
                                    id="title" name="title" placeholder="e.g., Course Learning Outcomes"
                                    type="text" value="{{ old('title') }}" />
                            </div>

                            <div class="grid grid-cols-2 gap-6">
                                <!-- Section Code -->
                                <div class="space-y-2">
                                    <label class="font-label text-[10px] text-outline uppercase tracking-widest"
                                        for="section_code">Mã Mục</label>
                                    <div class="relative">
                                        <input
                                            class="w-full bg-surface-container-lowest neo-input rounded-lg pl-10 pr-4 py-3 text-sm font-label tracking-wider text-on-surface"
                                            id="section_code" name="section_code" placeholder="SC-001" type="text"
                                            value="{{ old('section_code') }}" />
                                        <span
                                            class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline-variant text-sm">terminal</span>
                                    </div>
                                </div>

                                <!-- Display Order -->
                                <div class="space-y-2">
                                    <label class="font-label text-[10px] text-outline uppercase tracking-widest"
                                        for="display_order">Thứ Tự Hiển Thị</label>
                                    <input
                                        class="w-full bg-surface-container-lowest neo-input rounded-lg px-4 py-3 text-sm text-on-surface"
                                        id="display_order" name="display_order" type="number"
                                        value="{{ old('display_order', 1) }}" />
                                </div>
                            </div>

                            <!-- Input Type Stylized Dropdown -->
                            <div class="space-y-2">
                                <label class="font-label text-[10px] text-outline uppercase tracking-widest"
                                    for="input_type">Loại Nhập Liệu</label>
                                <div class="relative group/select">
                                    <select
                                        class="w-full appearance-none bg-surface-container-lowest neo-input rounded-lg px-4 py-3 text-sm text-on-surface focus:ring-0"
                                        id="input_type" name="input_type">
                                        <option value="rich_text" {{ old('input_type') == 'rich_text' ? 'selected' : '' }}>
                                            Văn Bản Thuần (Rich Text Editor)</option>
                                        <option value="structured_co"
                                            {{ old('input_type') == 'structured_co' ? 'selected' : '' }}>Object Matrix
                                            (Course Objectives)</option>
                                        <option value="structured_clo"
                                            {{ old('input_type') == 'structured_clo' ? 'selected' : '' }}>Outcome Map (CLO
                                            Mapping)</option>
                                        <option value="structured_teaching_plan"
                                            {{ old('input_type') == 'structured_teaching_plan' ? 'selected' : '' }}>
                                            Chronological (Teaching Plan)</option>
                                    </select>
                                    <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-outline">
                                        <span class="material-symbols-outlined text-sm">unfold_more</span>
                                    </div>
                                </div>
                                <p class="text-[10px] text-outline italic">Defines how instructors interact with the data
                                    layer in the editor view.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Terminal Style Preview (Design System Requirement) -->
                    <div
                        class="bg-surface-container-lowest rounded-xl p-4 border-l-2 border-primary-container relative overflow-hidden shadow-inset-deep">
                        <div class="flex items-center gap-2 mb-3">
                            <div class="flex gap-1">
                                <div class="w-2 h-2 rounded-full bg-outline-variant/40"></div>
                                <div class="w-2 h-2 rounded-full bg-outline-variant/40"></div>
                                <div class="w-2 h-2 rounded-full bg-outline-variant/40"></div>
                            </div>
                            <span class="font-label text-[10px] text-outline-variant uppercase">Logic Debugger</span>
                        </div>
                        <code class="block text-[11px] font-label text-primary-fixed-dim/70 leading-relaxed">
                            [System] Initializing section parameters...<br />
                            [Protocol] Mapping to InputType::STRUCTURED_CLO<br />
                            [Validation] Checks passed. Ready for orchestration.<br />
                            &gt; <span class="animate-pulse">_</span>
                        </code>
                    </div>
                </div>

                <!-- Right Column: Configurations & Toggles -->
                <div class="col-span-12 lg:col-span-4 space-y-6">
                    <div class="bg-surface-container rounded-xl p-6 border border-outline-variant/10">
                        <h3 class="font-label text-[11px] text-on-surface-variant uppercase tracking-widest mb-6">Cấu Hình</h3>
                        <div class="space-y-4">
                            <!-- Required Toggle -->
                            <label
                                class="flex items-center justify-between p-3 rounded-lg hover:bg-surface-container-high transition-colors cursor-pointer group">
                                <div class="flex flex-col">
                                    <span class="text-xs font-semibold text-on-surface">Bắt Buộc</span>
                                    <span class="text-[10px] text-outline">Bắt buộc cho việc nhập liệu</span>
                                </div>
                                <div class="relative">
                                    <input class="sr-only peer" name="is_required" type="checkbox"
                                        {{ old('is_required', '1') == '1' ? 'checked' : '' }}>
                                    <div
                                        class="w-10 h-5 bg-surface-container-lowest border border-outline-variant/40 rounded-full peer peer-checked:bg-primary-container/20 peer-checked:border-primary-container transition-all">
                                    </div>
                                    <div
                                        class="absolute left-1 top-1 w-3 h-3 bg-outline rounded-full peer-checked:left-6 peer-checked:bg-primary-container transition-all">
                                    </div>
                                </div>
                            </label>

                            <!-- Editable Toggle -->
                            <label
                                class="flex items-center justify-between p-3 rounded-lg hover:bg-surface-container-high transition-colors cursor-pointer group">
                                <div class="flex flex-col">
                                    <span class="text-xs font-semibold text-on-surface">Cho phép sửa đổi</span>
                                    <span class="text-[10px] text-outline">Cho phép sửa đổi của giảng viên</span>
                                </div>
                                <div class="relative">
                                    <input class="sr-only peer" name="is_editable" type="checkbox"
                                        {{ old('is_editable', '1') == '1' ? 'checked' : '' }}>
                                    <div
                                        class="w-10 h-5 bg-surface-container-lowest border border-outline-variant/40 rounded-full peer peer-checked:bg-primary-container/20 peer-checked:border-primary-container transition-all">
                                    </div>
                                    <div
                                        class="absolute left-1 top-1 w-3 h-3 bg-outline rounded-full peer-checked:left-6 peer-checked:bg-primary-container transition-all">
                                    </div>
                                </div>
                            </label>

                            <!-- AI Generatable Toggle -->
                            <label
                                class="flex items-center justify-between p-3 rounded-lg hover:bg-surface-container-high transition-colors cursor-pointer group">
                                <div class="flex flex-col gap-1">
                                    <div class="flex items-center gap-1.5">
                                        <span class="text-xs font-semibold text-on-surface">Cho Phép Sử Dụng AI</span>
                                        <span
                                            class="material-symbols-outlined text-[14px] text-tertiary">auto_awesome</span>
                                    </div>
                                    <span class="text-[10px] text-outline">Kích hoạt tạo nội dung tự động</span>
                                </div>
                                <div class="relative">
                                    <input class="sr-only peer" name="is_ai_generatable" type="checkbox"
                                        {{ old('is_ai_generatable') ? 'checked' : '' }}>
                                    <div
                                        class="w-10 h-5 bg-surface-container-lowest border border-outline-variant/40 rounded-full peer peer-checked:bg-primary-container/20 peer-checked:border-primary-container transition-all">
                                    </div>
                                    <div
                                        class="absolute left-1 top-1 w-3 h-3 bg-outline rounded-full peer-checked:left-6 peer-checked:bg-primary-container transition-all">
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Action Surface -->
                    <div class="flex flex-col gap-3">
                        <button
                            class="w-full bg-primary-container text-on-primary-container font-headline font-bold text-sm py-4 rounded-lg shadow-[0_10px_20px_-10px_rgba(94,106,210,0.5)] active:scale-[0.98] transition-all flex items-center justify-center gap-2 group"
                            type="submit">
                            Xác Nhận Tạo Mục
                            <span
                                class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">bolt</span>
                        </button>
                        <a href="{{ route('department.syllabus-templates.sections.index', $template->id) }}"
                            class="w-full bg-surface-container-high border border-outline-variant/20 text-on-surface-variant font-label text-[10px] uppercase tracking-[0.2em] py-3 rounded-lg hover:bg-surface-bright transition-all text-center block">
                            Hủy Tạo Mục
                        </a>
                    </div>

                    <!-- Helper Tip -->
                    <div class="p-4 bg-tertiary-container/5 rounded-xl border border-tertiary-container/10">
                        <div class="flex gap-3">
                            <span class="material-symbols-outlined text-tertiary text-lg">lightbulb</span>
                            <p class="text-[11px] text-on-surface-variant leading-relaxed">
                                <strong class="text-tertiary-fixed-dim">Tip:</strong> Hiện tại hệ thống hỗ trợ AI sinh nội dung cho các loại nhập liệu cho CO, CLO và Teaching Plan. Hãy thử bật tùy chọn "Cho Phép Sử Dụng AI" để trải nghiệm tính năng này trong trình soạn thảo.
                            </p>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Ambient Lighting Effect -->
        <div
            class="fixed bottom-0 right-0 w-125 h-125 bg-primary-container/5 blur-[120px] rounded-full pointer-events-none -z-10">
        </div>
        <div
            class="fixed top-0 left-0 w-75 h-75 bg-secondary-container/5 blur-[100px] rounded-full pointer-events-none -z-10">
        </div>
    @endsection

    @push('scripts')
        <script>
            // Subtle mouse tracking spotlight effect for form cards
            document.addEventListener('mousemove', (e) => {
                const cards = document.querySelectorAll('.bg-surface-container');
                cards.forEach(card => {
                    const rect = card.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    card.style.setProperty('--mouse-x', `${x}px`);
                    card.style.setProperty('--mouse-y', `${y}px`);
                });
            });
        </script>
    @endpush
