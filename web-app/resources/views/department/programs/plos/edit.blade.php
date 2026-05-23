@extends('layouts.department')

@section('title', 'Sửa PLO | Syllabus_System')

@section('content')
<!-- Main Canvas -->
<main class="pl-64 pt-16 min-h-screen relative z-10">
    <div class="p-8 max-w-350 mx-auto grid grid-cols-12 gap-8">
        <!-- Left: Primary Content -->
        <div class="col-span-8 space-y-8">
            <!-- Page Header -->
            <section class="flex flex-col gap-2">
                <div class="flex items-center gap-3 text-primary">
                    <span class="material-symbols-outlined text-sm">edit_note</span>
                    <span class="font-label text-xs tracking-widest uppercase">Entity Modification Protocol</span>
                </div>
                <h2 class="text-3xl font-display font-bold tracking-tight text-transparent bg-clip-text bg-linear-to-r from-on-surface to-on-surface-variant">
                    Sửa Program Learning Outcome (PLO)
                </h2>
                <div class="flex items-center gap-2 text-on-surface-variant">
                    <span class="text-sm font-medium">Chương trình:</span>
                    <code class="bg-surface-container px-2 py-0.5 rounded text-primary text-xs font-label">{{ $program->name }}</code>
                </div>
            </section>

            <!-- Validation Block (Laravel logic preserved) -->
            @if($errors->any())
                <div class="bg-error-container/10 border-l-2 border-error p-4 rounded-r-xl glass-panel animate-pulse">
                    <div class="flex items-center gap-3 mb-2 text-error">
                        <span class="material-symbols-outlined text-lg">warning</span>
                        <h3 class="font-label font-bold text-sm tracking-tighter uppercase">Cảnh báo: Lỗi xác thực dữ liệu</h3>
                    </div>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li class="text-error/80 text-xs font-body">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Technical Form Container -->
            <div class="surface-container rounded-xl border border-outline-variant/10 overflow-hidden shadow-2xl relative">
                <div class="absolute top-0 right-0 p-4 opacity-5 pointer-events-none">
                    <span class="material-symbols-outlined text-6xl">account_tree</span>
                </div>
                <form action="{{ route('programs.plos.update', [$program->id, $plo->id]) }}" class="p-8 space-y-8" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-8">
                        <!-- PLO Code -->
                        <div class="space-y-3">
                            <label class="flex items-center gap-2 font-label text-[10px] uppercase tracking-widest text-on-surface-variant/80" for="code">
                                <span class="material-symbols-outlined text-xs">tag</span>
                                Mã PLO
                            </label>
                            <div class="relative group">
                                <input class="w-full bg-surface-container-lowest border-0 rounded-lg py-4 px-5 text-on-surface font-body shadow-inset-soft focus:ring-1 focus:ring-primary/50 transition-all placeholder:text-on-surface-variant/30"
                                       id="code"
                                       name="code"
                                       placeholder="Ví dụ: PLO1.1"
                                       type="text"
                                       value="{{ old('code', $plo->code) }}"/>
                                <div class="absolute inset-0 rounded-lg pointer-events-none border border-outline-variant/5 group-hover:border-primary/20 transition-colors"></div>
                            </div>
                        </div>

                        <!-- PLO Description -->
                        <div class="space-y-3">
                            <label class="flex items-center gap-2 font-label text-[10px] uppercase tracking-widest text-on-surface-variant/80" for="description">
                                <span class="material-symbols-outlined text-xs">subject</span>
                                Mô tả
                            </label>
                            <div class="relative group">
                                <textarea class="w-full bg-surface-container-lowest border-0 rounded-lg py-4 px-5 text-on-surface font-body shadow-inset-soft focus:ring-1 focus:ring-primary/50 transition-all placeholder:text-on-surface-variant/30 resize-none"
                                          id="description"
                                          name="description"
                                          rows="6">{{ old('description', $plo->description) }}</textarea>
                                <div class="absolute inset-0 rounded-lg pointer-events-none border border-outline-variant/5 group-hover:border-primary/20 transition-colors"></div>
                            </div>
                            <p class="text-[10px] text-on-surface-variant/50 italic px-2">Mô tả kỹ thuật chi tiết về kết quả học tập dự kiến.</p>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-between pt-6 border-t border-outline-variant/10">
                        <a class="flex items-center gap-2 text-on-surface-variant hover:text-on-surface text-sm font-medium transition-colors"
                           href="{{ route('department.programs.plos.index', $program->id) }}">
                            <span class="material-symbols-outlined text-lg">arrow_back</span>
                            Quay lại
                        </a>
                        <button class="bg-linear-to-br from-primary to-primary-container text-on-primary-fixed px-8 py-3 rounded-lg font-bold text-sm shadow-extruded active:translate-y-0.5 active:shadow-none transition-all flex items-center gap-2"
                                type="submit">
                            <span class="material-symbols-outlined text-lg">save</span>
                            Cập nhật
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right: Technical Sidebar -->
        <div class="col-span-4 space-y-6">
            <!-- Metrics Card -->
            <div class="surface-container-low rounded-xl border border-outline-variant/10 p-6 space-y-6">
                <div class="flex items-center gap-2 text-primary">
                    <span class="material-symbols-outlined text-sm">monitoring</span>
                    <h3 class="font-label text-xs uppercase tracking-widest font-bold">Thông số tác động PLO</h3>
                </div>
                <div class="space-y-4">
                    <div class="flex justify-between items-end p-3 rounded-lg bg-surface-container-lowest border border-outline-variant/5">
                        <div>
                            <p class="text-[10px] text-on-surface-variant/70 uppercase font-label">Số lượng PI</p>
                            <p class="text-xl font-display font-bold text-on-surface">{{ $plo->pis_count ?? $plo->pis->count() ?? 0 }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] text-primary font-label uppercase">Đang hoạt động</p>
                            <div class="flex gap-0.5 mt-1">
                                <div class="w-1 h-3 bg-primary/20 rounded-full"></div>
                                <div class="w-1 h-3 bg-primary/40 rounded-full"></div>
                                <div class="w-1 h-3 bg-primary/60 rounded-full"></div>
                                <div class="w-1 h-3 bg-primary/80 rounded-full"></div>
                                <div class="w-1 h-3 bg-primary rounded-full"></div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between items-end p-3 rounded-lg bg-surface-container-lowest border border-outline-variant/5">
                        <div>
                            <p class="text-[10px] text-on-surface-variant/70 uppercase font-label">Độ phủ môn học</p>
                            <p class="text-xl font-display font-bold text-on-surface">85%</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] text-tertiary font-label uppercase">Tối ưu</p>
                            <div class="w-16 h-1 bg-surface-container-highest rounded-full mt-2 relative overflow-hidden">
                                <div class="absolute left-0 top-0 h-full w-[85%] bg-tertiary"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Internal Meta Card -->
            <div class="surface-container-lowest rounded-xl border border-outline-variant/10 p-6 space-y-4 shadow-inset-soft">
                <div class="flex items-center gap-2 text-on-surface-variant">
                    <span class="material-symbols-outlined text-sm">info</span>
                    <h3 class="font-label text-xs uppercase tracking-widest font-bold">Thông tin nội bộ</h3>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between text-[11px] font-label">
                        <span class="text-on-surface-variant/60">PHIÊN BẢN</span>
                        <span class="text-primary font-bold">V2.4.0</span>
                    </div>
                    <div class="flex justify-between text-[11px] font-label">
                        <span class="text-on-surface-variant/60">NGÀY TẠO</span>
                        <span class="text-on-surface/80">{{ $plo->created_at ? $plo->created_at->format('d M Y') : 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between text-[11px] font-label">
                        <span class="text-on-surface-variant/60">TÁC GIẢ</span>
                        <span class="text-on-surface/80">{{ $plo->author ?? 'System.Operator' }}</span>
                    </div>
                    <div class="flex justify-between text-[11px] font-label">
                        <span class="text-on-surface-variant/60">CẬP NHẬT LẦN CUỐI</span>
                        <span class="text-on-surface/80">{{ $plo->updated_at ? $plo->updated_at->diffForHumans() : 'Just now' }}</span>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-outline-variant/5 text-center">
                    <span class="inline-block px-3 py-1 bg-primary/10 rounded-full text-[9px] text-primary font-bold uppercase tracking-widest">
                        Giao dịch được ủy quyền
                    </span>
                </div>
            </div>

            <!-- Technical Diagram (Stylized) -->
            <div class="rounded-xl overflow-hidden grayscale opacity-30 hover:opacity-100 transition-opacity">
                <img class="w-full h-auto"
                     alt="Sơ đồ kỹ thuật mạng lưới dữ liệu"
                     src="https://lh3.googleusercontent.com/aida-public/AB6AXuDEqYiMPdObIlDijs2JgVChCLvhpoljI9unmYryWPj6kVOgepuYExxETxOEBx2hso3UprGlwLMzyiklJ-XlTDghj_vc4fhDXhtO1lpwfKBQowY97C3M8740A7lT7gO-hdGz3jAkj5ql7Gc-xiJuo5_9BpsgS-kbVkPuepqSfxo9l0j2SbfzvJXRtttzeWze6Fn9kA0GTJh4BevBo0SPH1qMpVDUBGTkE-UdLQFhZ4tq3iOsyu7szBlXc4V4twY21wyElfMA2EZOTe_-"/>
            </div>
        </div>
    </div>
</main>

<script>
    // Micro-interaction for form focus
    document.querySelectorAll('input, textarea').forEach(el => {
        el.addEventListener('focus', () => {
            const borderDiv = el.parentElement.querySelector('div');
            if (borderDiv) {
                borderDiv.classList.replace('border-outline-variant/5', 'border-primary/40');
            }
        });
        el.addEventListener('blur', () => {
            const borderDiv = el.parentElement.querySelector('div');
            if (borderDiv) {
                borderDiv.classList.replace('border-primary/40', 'border-outline-variant/5');
            }
        });
    });

    // Mouse-tracking spotlight effect for the form container
    const formContainer = document.querySelector('.surface-container');
    if (formContainer) {
        formContainer.addEventListener('mousemove', (e) => {
            const rect = formContainer.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            formContainer.style.background = `radial-gradient(circle at ${x}px ${y}px, rgba(94, 106, 210, 0.05) 0%, rgba(32, 31, 33, 1) 50%)`;
        });
        formContainer.addEventListener('mouseleave', () => {
            formContainer.style.background = `rgba(32, 31, 33, 0.7)`;
        });
    }
</script>
@endsection
