@extends('layouts.department')

@section('title', 'Quản lý section | TechSyllabus')

@section('content')
<main class="pl-64 min-h-screen relative z-10 technical-grid">
    <!-- Top App Bar Shell -->
    <header class="fixed top-0 right-0 left-64 flex items-center justify-between px-8 z-40 bg-[#131315]/80 backdrop-blur-xl border-b border-[#454652]/10 w-auto h-16">
        <div class="flex items-center gap-4">
            <div class="relative group">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-sm group-focus-within:text-primary transition-colors">search</span>
                <input class="bg-surface-container-lowest border-none rounded-full pl-10 pr-4 py-1.5 text-xs w-64 focus:ring-1 focus:ring-primary-container transition-all placeholder:text-outline/50 font-label" placeholder="Scan protocols..." type="text"/>
            </div>
        </div>
        <div class="flex items-center gap-6">
            <button class="text-on-surface-variant hover:text-primary transition-colors relative">
                <span class="material-symbols-outlined text-xl">notifications</span>
                <span class="absolute top-0 right-0 w-2 h-2 bg-error rounded-full border-2 border-surface"></span>
            </button>
            <button class="text-on-surface-variant hover:text-primary transition-colors">
                <span class="material-symbols-outlined text-xl">help_outline</span>
            </button>
            <div class="h-6 w-px bg-outline-variant/20 mx-2"></div>
            <div class="flex items-center gap-2">
                <span class="text-[10px] font-label uppercase tracking-widest text-on-surface-variant">Node: Lab-04</span>
                <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
            </div>
        </div>
    </header>

    <div class="pt-24 pb-12 px-12 max-w-7xl mx-auto">
        <!-- Breadcrumbs & Status -->
        <nav class="flex items-center gap-2 mb-4 text-[10px] font-label uppercase tracking-widest text-on-surface-variant">
            <a class="hover:text-primary transition-colors" href="{{ route('department.syllabus-templates.index') }}">Infrastructure</a>
            <span class="material-symbols-outlined text-[10px]">chevron_right</span>
            <a class="hover:text-primary transition-colors" href="{{ route('department.syllabus-templates.index') }}">Templates</a>
            <span class="material-symbols-outlined text-[10px]">chevron_right</span>
            <span class="text-primary-fixed-dim">Section Orchestration</span>
        </nav>

        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
            <div class="space-y-1">
                <h1 class="text-4xl font-extrabold tracking-tighter text-on-surface">Quản lý section</h1>
                <p class="text-on-surface-variant/80 font-body flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm text-primary">analytics</span>
                    Template: <span class="text-on-surface font-semibold">{{ $template->template_name }}</span>
                </p>
            </div>
            <div class="flex items-center gap-4">
                <a class="flex items-center gap-2 px-4 py-2.5 rounded-lg border border-outline-variant/20 hover:bg-surface-container transition-all text-sm font-medium" href="{{ route('department.syllabus-templates.index') }}">
                    <span class="material-symbols-outlined text-sm">arrow_back</span>
                    Quay lại template
                </a>
                <a href="{{ route('department.syllabus-templates.sections.create', $template->id) }}" class="glow-button flex items-center gap-2 px-6 py-2.5 rounded-lg bg-primary-container text-on-primary-container font-semibold text-sm">
                    <span class="material-symbols-outlined">add_circle</span>
                    Thêm section
                </a>
            </div>
        </div>

        <!-- Notification Area (Blade Integrated) -->
        @if(session('success'))
        <div class="mb-8 p-4 rounded-xl bg-primary-container/10 border border-primary-container/30 flex items-center gap-4 animate-in fade-in slide-in-from-top duration-500" id="status-toast">
            <div class="w-10 h-10 rounded-lg bg-primary-container/20 flex items-center justify-center text-primary">
                <span class="material-symbols-outlined">check_circle</span>
            </div>
            <div class="flex-1">
                <p class="text-sm font-semibold text-on-surface">Operation Successful</p>
                <p class="text-xs text-on-surface-variant">{{ session('success') }}</p>
            </div>
            <button class="text-on-surface-variant hover:text-on-surface" onclick="document.getElementById('status-toast').remove()">
                <span class="material-symbols-outlined text-sm">close</span>
            </button>
        </div>
        @endif

        <!-- Table Container -->
        <div class="glass-panel border border-outline-variant/10 rounded-2xl overflow-hidden shadow-2xl relative">
            <div class="absolute inset-0 bg-gradient-to-br from-primary-container/5 via-transparent to-transparent pointer-events-none"></div>
            <div class="overflow-x-auto no-scrollbar">
                <table class="w-full border-collapse text-left">
                    <thead>
                        <tr class="bg-surface-container-lowest/50 border-b border-outline-variant/10">
                            <th class="px-6 py-5 text-[10px] font-label uppercase tracking-widest text-on-surface-variant">Order</th>
                            <th class="px-6 py-5 text-[10px] font-label uppercase tracking-widest text-on-surface-variant">Section Title</th>
                            <th class="px-6 py-5 text-[10px] font-label uppercase tracking-widest text-on-surface-variant">Code ID</th>
                            <th class="px-6 py-5 text-[10px] font-label uppercase tracking-widest text-on-surface-variant">Input Model</th>
                            <th class="px-6 py-5 text-[10px] font-label uppercase tracking-widest text-on-surface-variant text-center">Status Matrix</th>
                            <th class="px-6 py-5 text-[10px] font-label uppercase tracking-widest text-on-surface-variant text-right">Operations</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/5">
                        @forelse($sections as $section)
                        <tr class="group hover:bg-surface-container/50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="font-label text-sm text-primary-fixed-dim tabular-nums">#{{ str_pad($section->display_order, 2, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-sm font-semibold text-on-surface group-hover:text-primary transition-colors">{{ $section->title }}</span>
                                    <span class="text-[10px] font-label text-on-surface-variant/60 uppercase">Revision 1.0.4</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <code class="px-2 py-1 rounded bg-surface-container-lowest text-[11px] font-label text-secondary border border-outline-variant/10">
                                    {{ $section->section_code }}
                                </code>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-sm text-on-surface-variant">terminal</span>
                                    <span class="text-xs text-on-surface-variant capitalize">{{ $section->input_type }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-3">
                                    <!-- Editable Badge -->
                                    <div class="group/tip relative">
                                        <div class="flex h-5 w-5 items-center justify-center rounded-full {{ $section->is_editable ? 'bg-emerald-500/10 text-emerald-400' : 'bg-error/10 text-error' }} border {{ $section->is_editable ? 'border-emerald-500/20' : 'border-error/20' }}">
                                            <span class="material-symbols-outlined text-[12px] font-bold">{{ $section->is_editable ? 'edit' : 'edit_off' }}</span>
                                        </div>
                                        <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 bg-surface-container-highest text-[10px] text-white rounded opacity-0 group-hover/tip:opacity-100 transition-opacity pointer-events-none whitespace-nowrap">Editable</div>
                                    </div>
                                    <!-- AI Support Badge -->
                                    <div class="group/tip relative">
                                        <div class="flex h-5 w-5 items-center justify-center rounded-full {{ $section->is_ai_generatable ? 'bg-primary-container/20 text-primary' : 'bg-surface-variant text-on-surface-variant/40' }} border border-primary-container/10">
                                            <span class="material-symbols-outlined text-[12px] font-bold">auto_awesome</span>
                                        </div>
                                        <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 bg-surface-container-highest text-[10px] text-white rounded opacity-0 group-hover/tip:opacity-100 transition-opacity pointer-events-none whitespace-nowrap">AI Enabled</div>
                                    </div>
                                    <!-- Required Badge -->
                                    <div class="group/tip relative">
                                        <div class="flex h-5 w-5 items-center justify-center rounded-full {{ $section->is_required ? 'bg-amber-500/10 text-amber-400' : 'bg-surface-variant text-on-surface-variant/40' }} border border-amber-500/10">
                                            <span class="material-symbols-outlined text-[12px] font-bold">priority_high</span>
                                        </div>
                                        <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 bg-surface-container-highest text-[10px] text-white rounded opacity-0 group-hover/tip:opacity-100 transition-opacity pointer-events-none whitespace-nowrap">Required</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('department.syllabus-templates.sections.edit', [$template->id, $section->id]) }}" class="p-2 rounded-lg hover:bg-primary-container/10 hover:text-primary transition-all group/btn">
                                        <span class="material-symbols-outlined text-sm">edit</span>
                                    </a>
                                    <form method="POST" action="{{ route('department.syllabus-templates.sections.destroy', [$template->id, $section->id]) }}" class="inline delete-form" data-id="{{ $section->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="delete-btn p-2 rounded-lg hover:bg-error/10 hover:text-error transition-all group/btn">
                                            <span class="material-symbols-outlined text-sm">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="px-6 py-20 text-center" colspan="6">
                                <div class="flex flex-col items-center gap-4 opacity-40">
                                    <span class="material-symbols-outlined text-6xl">layers_clear</span>
                                    <div class="space-y-1">
                                        <p class="text-sm font-semibold">No Sections Detected</p>
                                        <p class="text-xs font-label uppercase tracking-widest">Initialize your first module using the laboratory controls</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Footer Infrastructure -->
            <div class="px-6 py-4 bg-surface-container-lowest/30 border-t border-outline-variant/10 flex items-center justify-between">
                <p class="text-[10px] font-label text-on-surface-variant uppercase tracking-widest">
                    Total Modules: <span class="text-primary font-bold">{{ $sections->count() }}</span>
                </p>
                <div class="flex items-center gap-1">
                    <button class="p-1 hover:text-primary transition-colors"><span class="material-symbols-outlined text-lg">first_page</span></button>
                    <button class="p-1 hover:text-primary transition-colors"><span class="material-symbols-outlined text-lg">chevron_left</span></button>
                    <div class="px-3 text-[10px] font-label text-on-surface-variant">PAGINATION: 01 / 01</div>
                    <button class="p-1 hover:text-primary transition-colors"><span class="material-symbols-outlined text-lg">chevron_right</span></button>
                    <button class="p-1 hover:text-primary transition-colors"><span class="material-symbols-outlined text-lg">last_page</span></button>
                </div>
            </div>
        </div>

        <!-- Technical Metadata Footer -->
        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="p-4 rounded-xl bg-surface-container-low border border-outline-variant/5">
                <div class="flex items-center gap-3 mb-2">
                    <span class="material-symbols-outlined text-primary text-sm">hub</span>
                    <h4 class="text-[10px] font-label uppercase tracking-widest text-on-surface-variant">System Integrity</h4>
                </div>
                <div class="h-1.5 w-full bg-surface-variant rounded-full overflow-hidden">
                    <div class="h-full bg-primary w-[94%] shadow-[0_0_8px_rgba(189,194,255,0.4)]"></div>
                </div>
                <p class="mt-2 text-[10px] font-label text-right opacity-60">STABLE: 94% OPTIMIZED</p>
            </div>
            <div class="p-4 rounded-xl bg-surface-container-low border border-outline-variant/5">
                <div class="flex items-center gap-3 mb-2">
                    <span class="material-symbols-outlined text-secondary text-sm">memory</span>
                    <h4 class="text-[10px] font-label uppercase tracking-widest text-on-surface-variant">Compute Cycles</h4>
                </div>
                <div class="flex items-end gap-1 h-6">
                    <div class="w-2 bg-secondary/20 h-2 rounded-t-sm"></div>
                    <div class="w-2 bg-secondary/40 h-4 rounded-t-sm"></div>
                    <div class="w-2 bg-secondary/60 h-3 rounded-t-sm"></div>
                    <div class="w-2 bg-secondary h-6 rounded-t-sm animate-pulse"></div>
                    <div class="w-2 bg-secondary/50 h-2 rounded-t-sm"></div>
                </div>
                <p class="mt-2 text-[10px] font-label text-right opacity-60">ACTIVE: 12ms RESPONSE</p>
            </div>
            <div class="p-4 rounded-xl bg-surface-container-low border border-outline-variant/5">
                <div class="flex items-center gap-3 mb-2">
                    <span class="material-symbols-outlined text-error text-sm">verified_user</span>
                    <h4 class="text-[10px] font-label uppercase tracking-widest text-on-surface-variant">Access Logs</h4>
                </div>
                <div class="flex -space-x-2">
                    <div class="w-6 h-6 rounded-full border-2 border-surface bg-surface-variant flex items-center justify-center text-[8px]">JD</div>
                    <div class="w-6 h-6 rounded-full border-2 border-surface bg-primary flex items-center justify-center text-[8px]">AM</div>
                    <div class="w-6 h-6 rounded-full border-2 border-surface bg-secondary flex items-center justify-center text-[8px]">+3</div>
                </div>
                <p class="mt-2 text-[10px] font-label text-right opacity-60">LAST EDIT: 2 MINS AGO</p>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    // Micro-interactions for digital laboratory feel
    document.querySelectorAll('tr').forEach(row => {
        row.addEventListener('mousemove', (e) => {
            const rect = row.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            row.style.setProperty('--mouse-x', `${x}px`);
            row.style.setProperty('--mouse-y', `${y}px`);
        });
    });

    // Initialize success message timeout
    const toast = document.getElementById('status-toast');
    if (toast) {
        setTimeout(() => {
            toast.classList.add('opacity-0', 'translate-y-[-10px]', 'transition-all', 'duration-500');
            setTimeout(() => toast.remove(), 500);
        }, 5000);
    }

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
</script>
@endpush
