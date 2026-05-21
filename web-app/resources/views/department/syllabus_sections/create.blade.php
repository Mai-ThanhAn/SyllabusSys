@extends('layouts.department')

@section('title', 'Thêm section | TechSyllabus')

@section('content')
<!-- Main Content Canvas -->
<main class="flex-1 ml-64 relative flex flex-col overflow-y-auto">
    <!-- Top App Bar -->
    <header class="fixed top-0 right-0 left-64 h-16 bg-[#131315]/80 backdrop-blur-xl border-b border-[#454652]/10 flex items-center justify-between px-8 z-40">
        <div class="flex items-center gap-4">
            <a href="{{ route('department.syllabus-templates.sections.index', $template->id) }}" class="flex items-center gap-2 text-outline hover:text-on-surface transition-colors group">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                <span class="font-label text-xs uppercase tracking-widest">Quay lại</span>
            </a>
            <div class="h-4 w-px bg-outline-variant/30"></div>
            <h1 class="font-headline font-semibold text-sm tracking-tight">Add Section - <span class="text-primary">Syllabus Orchestrator</span></h1>
        </div>
        <div class="flex items-center gap-6">
            <div class="flex items-center gap-3 px-3 py-1.5 bg-surface-container-lowest rounded-full border border-outline-variant/20">
                <span class="material-symbols-outlined text-sm text-outline">search</span>
                <input class="bg-transparent border-none focus:ring-0 text-xs w-48 text-on-surface placeholder:text-outline" placeholder="Search parameters..." type="text"/>
            </div>
            <div class="flex items-center gap-2">
                <button class="p-2 hover:bg-[#353436]/40 rounded-full transition-all text-outline hover:text-primary">
                    <span class="material-symbols-outlined text-lg">notifications</span>
                </button>
                <button class="p-2 hover:bg-[#353436]/40 rounded-full transition-all text-outline hover:text-primary">
                    <span class="material-symbols-outlined text-lg">help_outline</span>
                </button>
            </div>
        </div>
    </header>

    <!-- Page Content -->
    <div class="mt-16 p-10 max-w-5xl mx-auto w-full flex flex-col gap-8 pb-20">
        <!-- Breadcrumb & Header Info -->
        <div class="flex flex-col gap-2">
            <span class="font-label text-[10px] text-primary tracking-[0.2em] uppercase">Technical Configuration</span>
            <div class="flex items-center justify-between">
                <h2 class="text-3xl font-display font-bold text-on-surface tracking-tighter">New Section Profile</h2>
                <div class="px-4 py-1.5 bg-primary-container/10 border border-primary-container/20 rounded-full">
                    <span class="text-xs font-label text-primary uppercase tracking-wider">Template: {{ $template->template_name }}</span>
                </div>
            </div>
            <p class="text-on-surface-variant text-sm max-w-2xl">Define the structural parameters for this syllabus module. Integrated with AI Course Mapping and technical consistency checks.</p>
        </div>

        <!-- Error Notifications (Validation States) -->
        @if($errors->any())
        <div class="bg-error-container/10 border-l-4 border-error rounded-xl p-4 flex gap-4 items-start shadow-lg">
            <div class="mt-0.5">
                <span class="material-symbols-outlined text-error" style="font-variation-settings: 'FILL' 1;">report</span>
            </div>
            <div class="flex-1">
                <p class="font-headline font-bold text-error text-sm uppercase tracking-wide">Configuration Conflicts Detected</p>
                <ul class="mt-2 space-y-1 text-xs text-on-error-container opacity-80 list-disc list-inside">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        <!-- Main Form Surface -->
        <form action="{{ route('department.syllabus-templates.sections.store', $template->id) }}" class="grid grid-cols-12 gap-8" method="POST">
            @csrf

            <!-- Left Column: Primary Fields -->
            <div class="col-span-12 lg:col-span-8 space-y-6">
                <div class="bg-surface-container rounded-xl p-8 border border-outline-variant/10 relative overflow-hidden group">
                    <!-- Ambient Light Glow -->
                    <div class="absolute -top-24 -right-24 w-48 h-48 bg-primary-container/10 blur-[80px] group-hover:bg-primary-container/20 transition-all duration-700"></div>

                    <div class="relative flex flex-col gap-6">
                        <!-- Section Title -->
                        <div class="space-y-2">
                            <label class="font-label text-[10px] text-outline uppercase tracking-widest" for="title">Section Title</label>
                            <input class="w-full bg-surface-container-lowest neo-input rounded-lg px-4 py-3 text-sm text-on-surface placeholder:text-outline-variant/60"
                                   id="title"
                                   name="title"
                                   placeholder="e.g., Course Learning Outcomes"
                                   type="text"
                                   value="{{ old('title') }}"/>
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <!-- Section Code -->
                            <div class="space-y-2">
                                <label class="font-label text-[10px] text-outline uppercase tracking-widest" for="section_code">Section Code</label>
                                <div class="relative">
                                    <input class="w-full bg-surface-container-lowest neo-input rounded-lg pl-10 pr-4 py-3 text-sm font-label tracking-wider text-on-surface"
                                           id="section_code"
                                           name="section_code"
                                           placeholder="SC-001"
                                           type="text"
                                           value="{{ old('section_code') }}"/>
                                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline-variant text-sm">terminal</span>
                                </div>
                            </div>

                            <!-- Display Order -->
                            <div class="space-y-2">
                                <label class="font-label text-[10px] text-outline uppercase tracking-widest" for="display_order">Display Sequence</label>
                                <input class="w-full bg-surface-container-lowest neo-input rounded-lg px-4 py-3 text-sm text-on-surface"
                                       id="display_order"
                                       name="display_order"
                                       type="number"
                                       value="{{ old('display_order', 1) }}"/>
                            </div>
                        </div>

                        <!-- Input Type Stylized Dropdown -->
                        <div class="space-y-2">
                            <label class="font-label text-[10px] text-outline uppercase tracking-widest" for="input_type">Technical Input Protocol</label>
                            <div class="relative group/select">
                                <select class="w-full appearance-none bg-surface-container-lowest neo-input rounded-lg px-4 py-3 text-sm text-on-surface focus:ring-0"
                                        id="input_type"
                                        name="input_type">
                                    <option value="rich_text" {{ old('input_type') == 'rich_text' ? 'selected' : '' }}>Editorial (Rich Text Editor)</option>
                                    <option value="structured_co" {{ old('input_type') == 'structured_co' ? 'selected' : '' }}>Object Matrix (Course Objectives)</option>
                                    <option value="structured_clo" {{ old('input_type') == 'structured_clo' ? 'selected' : '' }}>Outcome Map (CLO Mapping)</option>
                                    <option value="structured_teaching_plan" {{ old('input_type') == 'structured_teaching_plan' ? 'selected' : '' }}>Chronological (Teaching Plan)</option>
                                </select>
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-outline">
                                    <span class="material-symbols-outlined text-sm">unfold_more</span>
                                </div>
                            </div>
                            <p class="text-[10px] text-outline italic">Defines how instructors interact with the data layer in the editor view.</p>
                        </div>
                    </div>
                </div>

                <!-- Terminal Style Preview (Design System Requirement) -->
                <div class="bg-surface-container-lowest rounded-xl p-4 border-l-2 border-primary-container relative overflow-hidden shadow-inset-deep">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="flex gap-1">
                            <div class="w-2 h-2 rounded-full bg-outline-variant/40"></div>
                            <div class="w-2 h-2 rounded-full bg-outline-variant/40"></div>
                            <div class="w-2 h-2 rounded-full bg-outline-variant/40"></div>
                        </div>
                        <span class="font-label text-[10px] text-outline-variant uppercase">Logic Debugger</span>
                    </div>
                    <code class="block text-[11px] font-label text-primary-fixed-dim/70 leading-relaxed">
                        [System] Initializing section parameters...<br/>
                        [Protocol] Mapping to InputType::STRUCTURED_CLO<br/>
                        [Validation] Checks passed. Ready for orchestration.<br/>
                        &gt; <span class="animate-pulse">_</span>
                    </code>
                </div>
            </div>

            <!-- Right Column: Configurations & Toggles -->
            <div class="col-span-12 lg:col-span-4 space-y-6">
                <div class="bg-surface-container rounded-xl p-6 border border-outline-variant/10">
                    <h3 class="font-label text-[11px] text-on-surface-variant uppercase tracking-widest mb-6">Execution Policy</h3>
                    <div class="space-y-4">
                        <!-- Required Toggle -->
                        <label class="flex items-center justify-between p-3 rounded-lg hover:bg-surface-container-high transition-colors cursor-pointer group">
                            <div class="flex flex-col">
                                <span class="text-xs font-semibold text-on-surface">Required</span>
                                <span class="text-[10px] text-outline">Mandatory for submission</span>
                            </div>
                            <div class="relative">
                                <input class="sr-only peer" name="is_required" type="checkbox" {{ old('is_required', '1') == '1' ? 'checked' : '' }}>
                                <div class="w-10 h-5 bg-surface-container-lowest border border-outline-variant/40 rounded-full peer peer-checked:bg-primary-container/20 peer-checked:border-primary-container transition-all"></div>
                                <div class="absolute left-1 top-1 w-3 h-3 bg-outline rounded-full peer-checked:left-6 peer-checked:bg-primary-container transition-all"></div>
                            </div>
                        </label>

                        <!-- Editable Toggle -->
                        <label class="flex items-center justify-between p-3 rounded-lg hover:bg-surface-container-high transition-colors cursor-pointer group">
                            <div class="flex flex-col">
                                <span class="text-xs font-semibold text-on-surface">Editable</span>
                                <span class="text-[10px] text-outline">Instructor modification allowed</span>
                            </div>
                            <div class="relative">
                                <input class="sr-only peer" name="is_editable" type="checkbox" {{ old('is_editable', '1') == '1' ? 'checked' : '' }}>
                                <div class="w-10 h-5 bg-surface-container-lowest border border-outline-variant/40 rounded-full peer peer-checked:bg-primary-container/20 peer-checked:border-primary-container transition-all"></div>
                                <div class="absolute left-1 top-1 w-3 h-3 bg-outline rounded-full peer-checked:left-6 peer-checked:bg-primary-container transition-all"></div>
                            </div>
                        </label>

                        <!-- AI Generatable Toggle -->
                        <label class="flex items-center justify-between p-3 rounded-lg hover:bg-surface-container-high transition-colors cursor-pointer group">
                            <div class="flex flex-col gap-1">
                                <div class="flex items-center gap-1.5">
                                    <span class="text-xs font-semibold text-on-surface">AI Synthesis</span>
                                    <span class="material-symbols-outlined text-[14px] text-tertiary">auto_awesome</span>
                                </div>
                                <span class="text-[10px] text-outline">Enable autonomous content generation</span>
                            </div>
                            <div class="relative">
                                <input class="sr-only peer" name="is_ai_generatable" type="checkbox" {{ old('is_ai_generatable') ? 'checked' : '' }}>
                                <div class="w-10 h-5 bg-surface-container-lowest border border-outline-variant/40 rounded-full peer peer-checked:bg-primary-container/20 peer-checked:border-primary-container transition-all"></div>
                                <div class="absolute left-1 top-1 w-3 h-3 bg-outline rounded-full peer-checked:left-6 peer-checked:bg-primary-container transition-all"></div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Action Surface -->
                <div class="flex flex-col gap-3">
                    <button class="w-full bg-primary-container text-on-primary-container font-headline font-bold text-sm py-4 rounded-lg shadow-[0_10px_20px_-10px_rgba(94,106,210,0.5)] active:scale-[0.98] transition-all flex items-center justify-center gap-2 group" type="submit">
                        Confirm Orchestration
                        <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">bolt</span>
                    </button>
                    <a href="{{ route('department.syllabus-templates.sections.index', $template->id) }}" class="w-full bg-surface-container-high border border-outline-variant/20 text-on-surface-variant font-label text-[10px] uppercase tracking-[0.2em] py-3 rounded-lg hover:bg-surface-bright transition-all text-center block">
                        Discard Profile
                    </a>
                </div>

                <!-- Helper Tip -->
                <div class="p-4 bg-tertiary-container/5 rounded-xl border border-tertiary-container/10">
                    <div class="flex gap-3">
                        <span class="material-symbols-outlined text-tertiary text-lg">lightbulb</span>
                        <p class="text-[11px] text-on-surface-variant leading-relaxed">
                            <strong class="text-tertiary-fixed-dim">Tip:</strong> Sections using "Outcome Map" protocols are automatically synchronized with the National Competency Framework.
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</main>

<!-- Ambient Lighting Effect -->
<div class="fixed bottom-0 right-0 w-[500px] h-[500px] bg-primary-container/5 blur-[120px] rounded-full pointer-events-none -z-10"></div>
<div class="fixed top-0 left-0 w-[300px] h-[300px] bg-secondary-container/5 blur-[100px] rounded-full pointer-events-none -z-10"></div>
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
