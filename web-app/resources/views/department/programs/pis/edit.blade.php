@extends('layouts.department')

@section('title', 'Danh sách PI | Syllabus_System')

@section('content')

    <div class="max-w-7xl mx-auto">

        <!-- Left: Form Card -->
        <div class="lg:col-span-8">
            <div
                class="surface-container rounded-2xl p-8 border border-outline-variant/10 spotlight-reveal shadow-xl shadow-black/20">
                <!-- Error Block -->
                @if ($errors->any())
                    <div class="mb-8 p-4 bg-error-container/10 border-l-4 border-error rounded-r-xl flex items-start gap-4">
                        <span class="material-symbols-outlined text-error mt-0.5" data-icon="warning">warning</span>
                        <div>
                            <h4 class="font-label text-xs font-bold text-error uppercase tracking-widest mb-1">System
                                Warning: Validation Failed</h4>
                            <ul class="text-sm text-on-error-container/80 font-body list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('programs.plos.pis.update', [$program->id, $plo->id, $pi->id]) }}"
                    class="flex flex-col gap-8">
                    @csrf
                    @method('PUT')

                    <!-- Mã PI Field -->
                    <div class="flex flex-col gap-2">
                        <label
                            class="font-label text-xs uppercase tracking-widest text-outline flex items-center justify-between"
                            for="code">
                            <span>Mã PI</span>
                            <span class="text-[10px] opacity-50 font-normal">Technical Identifier</span>
                        </label>
                        <div class="relative">
                            <input
                                class="w-full bg-surface-container-lowest border-none shadow-inset-soft rounded-xl py-4 px-6 text-xl font-bold font-display tracking-tight text-primary focus:ring-2 focus:ring-primary/20 transition-all"
                                id="code" name="code" placeholder="Enter identifier..." type="text"
                                value="{{ old('code', $pi->code) }}" />
                            <span
                                class="absolute right-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline/30"
                                data-icon="fingerprint">fingerprint</span>
                        </div>
                    </div>

                    <!-- Mô tả Field -->
                    <div class="flex flex-col gap-2">
                        <label
                            class="font-label text-xs uppercase tracking-widest text-outline flex items-center justify-between"
                            for="description">
                            <span>Mô tả</span>
                            <span class="text-[10px] opacity-50 font-normal">Functional Specification</span>
                        </label>
                        <div class="relative">
                            <textarea
                                class="w-full bg-surface-container-lowest border-none shadow-inset-soft rounded-xl py-4 px-6 text-on-surface-variant font-body leading-relaxed focus:ring-2 focus:ring-primary/20 transition-all resize-none"
                                id="description" name="description" placeholder="Describe the performance indicator expectations..." rows="5">{{ old('description', $pi->description) }}</textarea>
                            <div class="absolute bottom-3 right-3 flex gap-2">
                                <button
                                    class="p-1.5 rounded-md hover:bg-surface-container-high text-outline transition-colors"
                                    title="AI Suggestion" type="button">
                                    <span class="material-symbols-outlined text-lg"
                                        data-icon="auto_awesome">auto_awesome</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between pt-4">
                        <a class="group flex items-center gap-2 text-on-surface-variant hover:text-on-surface transition-colors text-sm font-label uppercase tracking-widest"
                            href="{{ route('programs.plos.pis.index', [$program->id, $plo->id]) }}">
                            <span class="material-symbols-outlined group-hover:-translate-x-1 transition-transform"
                                data-icon="arrow_back">arrow_back</span>
                            Quay lại
                        </a>
                        <button
                            class="bg-primary-container text-on-primary-container px-10 py-3.5 rounded-xl font-bold font-headline tracking-tight shadow-extruded hover:scale-[1.02] active:scale-95 transition-all flex items-center gap-3 group"
                            type="submit">
                            Cập nhật
                            <span class="material-symbols-outlined text-lg group-hover:translate-x-1 transition-transform"
                                data-icon="upgrade">upgrade</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right: Contextual Stats / Metadata -->
        <div class="lg:col-span-4 flex flex-col gap-6">
            <!-- Context Info Card -->
            <div class="bg-surface-container-lowest rounded-2xl p-6 border-l-2 border-primary shadow-lg">
                <div class="flex items-center gap-3 mb-4">
                    <span class="material-symbols-outlined text-primary" data-icon="hub">hub</span>
                    <h3 class="font-label text-xs font-bold uppercase tracking-widest text-on-surface">Thông tin liên quan
                    </h3>
                </div>
                <div class="space-y-4">
                    <div class="p-3 rounded-xl bg-surface-container-high/50">
                        <p class="text-[10px] text-outline uppercase tracking-wider mb-1">Chương trình</p>
                        <p class="text-sm font-bold text-on-surface">{{ $program->name }}</p>
                    </div>
                    <div class="p-3 rounded-xl bg-surface-container-high/50">
                        <p class="text-[10px] text-outline uppercase tracking-wider mb-1">PLO</p>
                        <p class="text-sm font-bold text-on-surface">{{ $plo->code }}</p>
                    </div>
                </div>
            </div>

            <!-- Technical Spec Card -->
            <div class="bg-surface-container-low/50 rounded-2xl p-6 border border-outline-variant/10">
                <h3 class="font-label text-xs font-bold uppercase tracking-widest text-outline mb-4">Internal Meta</h3>
                <div class="space-y-3 font-label text-[11px]">
                    <div class="flex justify-between py-2 border-b border-outline-variant/10">
                        <span class="text-outline">Created</span>
                        <span
                            class="text-on-surface-variant">{{ $pi->created_at ? $pi->created_at->format('d M Y') : 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-outline-variant/10">
                        <span class="text-outline">Last Updated</span>
                        <span
                            class="text-on-surface-variant">{{ $pi->updated_at ? $pi->updated_at->format('d M Y') : 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-outline">Status</span>
                        <span class="flex items-center gap-1.5 text-tertiary">
                            <span class="w-1.5 h-1.5 rounded-full bg-tertiary animate-pulse"></span>
                            Active
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>


    <!-- Mouse Tracking Effect Script -->
    <script>
        document.addEventListener('mousemove', (e) => {
            const spotlights = document.querySelectorAll('.spotlight-reveal');
            spotlights.forEach(el => {
                const rect = el.getBoundingClientRect();
                const x = ((e.clientX - rect.left) / rect.width) * 100;
                const y = ((e.clientY - rect.top) / rect.height) * 100;
                el.style.setProperty('--x', `${x}%`);
                el.style.setProperty('--y', `${y}%`);
            });
        });
    </script>
@endsection
