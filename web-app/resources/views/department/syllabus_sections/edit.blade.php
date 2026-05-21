@extends('layouts.department')

@section('title', 'Sửa section | TechSyllabus')

@section('content')
<main class="ml-64 pt-24 pb-12 px-8 min-h-screen z-10 relative">
    <div class="max-w-6xl mx-auto">
        <!-- Context Banner -->
        <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h3 class="text-3xl font-display font-bold tracking-tighter text-on-surface mb-2">
                    Section: <span class="text-primary-container">{{ old('title', $section->title) }}</span>
                </h3>
                <div class="flex items-center gap-3">
                    <span class="px-2 py-0.5 bg-surface-container-high rounded text-[10px] font-label text-outline border border-outline-variant/20 uppercase tracking-wider">Template: {{ $template->template_name }}</span>
                    <span class="px-2 py-0.5 bg-primary-container/10 rounded text-[10px] font-label text-primary border border-primary-container/20 uppercase tracking-wider">ID: #SEC-{{ str_pad($section->id, 5, '0', STR_PAD_LEFT) }}</span>
                </div>
            </div>
        </div>

        <!-- Error Alerts (Conditional) -->
        @if($errors->any())
        <div class="mb-8 p-4 bg-error-container/10 border border-error/20 rounded-xl flex gap-4 animate-in fade-in slide-in-from-top-4">
            <div class="p-2 bg-error-container rounded-lg h-fit">
                <span class="material-symbols-outlined text-on-error-container">report</span>
            </div>
            <div>
                <h4 class="font-bold text-on-error-container text-sm">Configuration Conflict</h4>
                <ul class="text-xs text-on-error-container/80 mt-1 list-disc list-inside">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        <!-- Main Lab Form -->
        <form action="{{ route('department.syllabus-templates.sections.update', [$template->id, $section->id]) }}" class="grid grid-cols-12 gap-8" method="POST">
            @csrf
            @method('PUT')

            <!-- Left Column: Technical Metadata -->
            <div class="col-span-12 lg:col-span-8 space-y-6">
                <section class="glass-panel rounded-xl border border-outline-variant/10 overflow-hidden">
                    <div class="p-6 border-b border-outline-variant/10 bg-surface-container-low/50">
                        <h3 class="font-label text-xs font-bold uppercase tracking-[0.2em] text-primary flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">settings_input_component</span>
                            Technical Identity
                        </h3>
                    </div>
                    <div class="p-8 grid grid-cols-2 gap-6">
                        <div class="col-span-2">
                            <label class="block font-label text-[10px] uppercase tracking-widest text-outline mb-2">Section Title</label>
                            <input class="w-full bg-surface-container-lowest border-none shadow-inset-soft rounded-lg px-4 py-3 text-on-surface focus:ring-1 focus:ring-primary-container transition-all font-body text-sm"
                                   name="title"
                                   placeholder="e.g. Course Learning Outcomes"
                                   type="text"
                                   value="{{ old('title', $section->title) }}"/>
                        </div>

                        <div class="col-span-1">
                            <label class="block font-label text-[10px] uppercase tracking-widest text-outline mb-2">Section Code</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 font-label text-xs text-primary opacity-50">CODE_</span>
                                <input class="w-full bg-surface-container-lowest border-none shadow-inset-soft rounded-lg pl-14 pr-4 py-3 text-on-surface focus:ring-1 focus:ring-primary-container transition-all font-label text-xs tracking-wider"
                                       name="section_code"
                                       placeholder="CLO_01"
                                       type="text"
                                       value="{{ old('section_code', $section->section_code) }}"/>
                            </div>
                        </div>

                        <div class="col-span-1">
                            <label class="block font-label text-[10px] uppercase tracking-widest text-outline mb-2">Display Sequence</label>
                            <input class="w-full bg-surface-container-lowest border-none shadow-inset-soft rounded-lg px-4 py-3 text-on-surface focus:ring-1 focus:ring-primary-container transition-all font-body text-sm"
                                   min="0"
                                   name="display_order"
                                   type="number"
                                   value="{{ old('display_order', $section->display_order) }}"/>
                        </div>

                        <div class="col-span-2">
                            <label class="block font-label text-[10px] uppercase tracking-widest text-outline mb-2">Technical Input Protocol</label>
                            <div class="relative group">
                                <select class="w-full appearance-none bg-surface-container-lowest border-none shadow-inset-soft rounded-lg px-4 py-3 text-on-surface focus:ring-1 focus:ring-primary-container transition-all font-body text-sm"
                                        name="input_type">
                                    <option value="rich_text" @selected($section->input_type == 'rich_text')>Rich Text Editor (Standard)</option>
                                    <option value="structured_co" @selected($section->input_type == 'structured_co')>Structured: Course Objectives</option>
                                    <option value="structured_clo" @selected($section->input_type == 'structured_clo')>Structured: Course Learning Outcomes (CLOs)</option>
                                    <option value="structured_teaching_plan" @selected($section->input_type == 'structured_teaching_plan')>Structured: Teaching & Assessment Plan</option>
                                </select>
                                <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-outline">expand_more</span>
                            </div>
                            <p class="mt-2 text-[10px] text-outline italic">Defines the UI schema and data validation rules for this module.</p>
                        </div>
                    </div>
                </section>

                <!-- Logic Debugger Terminal -->
                <div class="bg-surface-container-lowest rounded-xl border border-primary-container/20 p-6 shadow-2xl relative overflow-hidden group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-primary-container animate-pulse"></div>
                            <span class="font-label text-[10px] uppercase tracking-[0.2em] text-primary-container">Orchestration Monitor</span>
                        </div>
                        <span class="font-label text-[9px] text-outline">v2.4.0-stable</span>
                    </div>
                    <div class="space-y-1.5 font-label text-[11px] leading-relaxed">
                        <p class="text-primary-container/80"><span class="text-outline/40 mr-2">[14:02:01]</span> [SYSTEM] Loading section parameters...</p>
                        <p class="text-on-surface/60"><span class="text-outline/40 mr-2">[14:02:02]</span> [MAPPING] Fetching database entity: SECTION_{{ str_pad($section->id, 5, '0', STR_PAD_LEFT) }}</p>
                        <p class="text-tertiary"><span class="text-outline/40 mr-2">[14:02:03]</span> [READY] Orchestration layer active. Waiting for input stream.</p>
                        <p class="text-primary-container/80" id="terminal-cursor"><span class="text-outline/40 mr-2">[14:02:04]</span> [STATUS] Synchronized <span class="animate-pulse">_</span></p>
                    </div>
                    <div class="absolute inset-0 bg-linear-to-t from-primary-container/5 to-transparent pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity"></div>
                </div>
            </div>

            <!-- Right Column: Execution Policy -->
            <div class="col-span-12 lg:col-span-4 space-y-6">
                <section class="glass-panel rounded-xl border border-outline-variant/10 overflow-hidden">
                    <div class="p-6 border-b border-outline-variant/10 bg-surface-container-low/50">
                        <h3 class="font-label text-xs font-bold uppercase tracking-[0.2em] text-primary flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">verified_user</span>
                            Execution Policy
                        </h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <!-- Toggle: Required -->
                        <div class="flex items-center justify-between group">
                            <div class="max-w-[70%]">
                                <label class="block text-sm font-semibold text-on-surface">Required</label>
                                <p class="text-[10px] text-outline mt-1 leading-tight">Must be completed before syllabus finalization.</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input class="sr-only peer" name="is_required" type="checkbox" @checked($section->is_required)>
                                <div class="w-11 h-6 bg-surface-container-highest rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-container"></div>
                            </label>
                        </div>

                        <div class="h-px bg-outline-variant/10"></div>

                        <!-- Toggle: Editable -->
                        <div class="flex items-center justify-between group">
                            <div class="max-w-[70%]">
                                <label class="block text-sm font-semibold text-on-surface">Editable</label>
                                <p class="text-[10px] text-outline mt-1 leading-tight">Allow faculty members to modify content in individual instances.</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input class="sr-only peer" name="is_editable" type="checkbox" @checked($section->is_editable)>
                                <div class="w-11 h-6 bg-surface-container-highest rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-container"></div>
                            </label>
                        </div>

                        <div class="h-px bg-outline-variant/10"></div>

                        <!-- Toggle: AI Synthesis -->
                        <div class="flex items-center justify-between group">
                            <div class="max-w-[70%]">
                                <label class="block text-sm font-semibold text-primary items-center gap-1.5">
                                    AI Synthesis
                                    <span class="material-symbols-outlined text-[14px]">auto_awesome</span>
                                </label>
                                <p class="text-[10px] text-outline mt-1 leading-tight">Enable automated generation based on course technical specs.</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input class="sr-only peer" name="is_ai_generatable" type="checkbox" @checked($section->is_ai_generatable)>
                                <div class="w-11 h-6 bg-surface-container-highest rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-container"></div>
                            </label>
                        </div>
                    </div>
                </section>

                <!-- Action Panel -->
                <div class="space-y-4">
                    <button class="w-full bg-primary-container text-on-primary-container font-label text-xs uppercase tracking-widest font-bold py-4 rounded-xl shadow-extruded hover:scale-[1.02] active:scale-100 transition-all flex items-center justify-center gap-3" type="submit">
                        Update Configuration
                        <span class="material-symbols-outlined text-sm">sync_alt</span>
                    </button>
                    <a href="{{ route('department.syllabus-templates.sections.index', $template->id) }}" class="w-full bg-transparent border border-outline-variant/20 text-on-surface-variant font-label text-[10px] uppercase tracking-widest font-bold py-3 rounded-xl hover:bg-surface-container transition-all text-center block">
                        Discard Changes
                    </a>
                </div>

                <!-- Informational Card -->
                <div class="p-6 rounded-xl bg-secondary-container/5 border border-secondary-container/10">
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-secondary text-lg mt-0.5">info</span>
                        <p class="text-[11px] text-on-surface-variant leading-relaxed">
                            Updating this configuration will immediately affect all <span class="text-secondary font-bold">In-Progress</span> syllabi using this template. Finalized syllabi will maintain their current state unless manually re-synced.
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</main>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const terminal = document.getElementById('terminal-cursor');
        const lines = [
            "[DATA] Validating display_sequence consistency...",
            "[INFO] Integrity check passed.",
            "[LAB] Awaiting manual commit."
        ];
        let i = 0;

        setInterval(() => {
            const p = document.createElement('p');
            p.className = 'text-on-surface/40 animate-in fade-in duration-500';
            const time = new Date().toLocaleTimeString('en-GB', { hour12: false });
            p.innerHTML = `<span class="text-outline/40 mr-2">[${time}]</span> ${lines[i % 3]}`;
            if (terminal && terminal.parentElement) {
                terminal.parentElement.insertBefore(p, terminal);
                i++;

                // Keep only last 8 lines
                const container = terminal.parentElement;
                if (container.children.length > 10) {
                    container.removeChild(container.children[1]);
                }
            }
        }, 5000);
    });
</script>
@endpush
