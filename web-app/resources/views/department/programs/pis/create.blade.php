@extends('layouts.department')

@section('title', 'Tạo Mới PI | Syllabus Lab')

@section('content')
<!-- Main Workspace -->
<main class="ml-64 pt-16 h-screen overflow-y-auto technical-grid">
    <div class="max-w-350 mx-auto p-8 lg:p-12">
        <!-- Header Context & Breadcrumbs -->
        <div class="mb-10 animate-in fade-in slide-in-from-top duration-700">
            <div class="flex items-center gap-2 mb-2">
                <a class="text-primary hover:underline font-label text-xs uppercase tracking-widest flex items-center gap-1"
                   href="{{ route('programs.plos.pis.index', [$program->id, $plo->id]) }}">
                    <span class="material-symbols-outlined text-sm">arrow_back</span> Quay lại
                </a>
            </div>
            <h2 class="font-display text-4xl font-bold tracking-tighter text-on-surface mb-3">
                Thêm Performance Indicator (PI)
            </h2>
            <div class="flex flex-wrap items-center gap-4">
                <div class="bg-surface-container px-3 py-1.5 rounded-lg border border-outline-variant/10 flex items-center gap-2">
                    <span class="font-label text-[10px] text-outline uppercase tracking-wider">Chương trình:</span>
                    <span class="font-body text-sm font-semibold text-primary">{{ $program->name ?? 'Computer Science' }}</span>
                </div>
                <div class="bg-surface-container px-3 py-1.5 rounded-lg border border-outline-variant/10 flex items-center gap-2">
                    <span class="font-label text-[10px] text-outline uppercase tracking-wider">PLO:</span>
                    <span class="font-body text-sm font-semibold text-secondary">{{ $plo->code ?? 'PLO3' }}</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <!-- Left: Form Editor -->
            <div class="lg:col-span-8 space-y-6">
                <!-- Validation Protocol Component -->
                @if($errors->any())
                <div class="bg-error-container/10 border-l-4 border-error p-6 rounded-xl animate-in slide-in-from-left duration-500">
                    <div class="flex items-start gap-4">
                        <span class="material-symbols-outlined text-error" style="font-variation-settings: 'FILL' 1;">warning</span>
                        <div>
                            <h4 class="font-label text-error uppercase tracking-widest text-xs font-bold mb-2">Cảnh báo: Lỗi xác thực dữ liệu</h4>
                            <ul class="text-on-error-container text-sm space-y-1 opacity-90">
                                @foreach($errors->all() as $error)
                                    <li>• {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Technical Editor Form -->
                <div class="bg-surface-container-low rounded-2xl border border-outline-variant/10 p-8 shadow-2xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10">
                        <span class="material-symbols-outlined text-9xl">terminal</span>
                    </div>
                    <form action="{{ route('department.programs.plos.pis.store', [$program->id, $plo->id]) }}" class="space-y-8 relative z-10" method="POST">
                        @csrf

                        <!-- Field 1: Mã PI -->
                        <div class="space-y-3">
                            <label class="flex justify-between items-center">
                                <span class="font-label text-xs uppercase tracking-widest text-on-surface-variant font-bold">MÃ PI</span>
                                <span class="text-[10px] font-label text-outline uppercase">Mã định danh</span>
                            </label>
                            <input class="w-full bg-surface-container-lowest border-0 rounded-xl px-4 py-4 text-primary font-label text-lg tracking-wider placeholder:text-outline/30 focus:ring-2 focus:ring-primary/40 shadow-inset-soft transition-all"
                                   name="code"
                                   placeholder="Ví dụ: PI3.1"
                                   type="text"
                                   value="{{ old('code') }}"/>
                        </div>

                        <!-- Field 2: Mô tả -->
                        <div class="space-y-3">
                            <label class="flex justify-between items-center">
                                <span class="font-label text-xs uppercase tracking-widest text-on-surface-variant font-bold">MÔ TẢ</span>
                                <span class="text-[10px] font-label text-outline uppercase">Đặc tả kỹ thuật</span>
                            </label>
                            <textarea class="w-full bg-surface-container-lowest border-0 rounded-xl px-4 py-4 text-on-surface font-body text-body-md leading-relaxed placeholder:text-outline/30 focus:ring-2 focus:ring-primary/40 shadow-inset-soft transition-all"
                                      name="description"
                                      placeholder="Nhập mô tả chi tiết cho Performance Indicator này..."
                                      rows="5">{{ old('description') }}</textarea>
                        </div>

                        <div class="pt-4 flex items-center gap-4">
                            <button class="bg-primary-container text-on-primary-container px-8 py-4 rounded-xl font-label text-sm uppercase tracking-widest font-black shadow-extruded hover:scale-[1.02] active:scale-95 transition-all flex items-center gap-2"
                                    type="submit">
                                <span class="material-symbols-outlined text-sm">save</span> Lưu PI
                            </button>
                            <a class="px-8 py-4 rounded-xl border border-outline-variant/30 text-on-surface-variant font-label text-sm uppercase tracking-widest hover:bg-surface-container-high transition-all"
                               href="{{ route('programs.plos.pis.index', [$program->id, $plo->id]) }}">
                                Hủy bỏ
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right: Information Architecture / Side Panel -->
            <div class="lg:col-span-4 space-y-6">
                <div class="bg-surface-container-high/50 glass-panel rounded-2xl p-6 border border-outline-variant/10">
                    <h3 class="font-label text-xs uppercase tracking-[0.2em] text-primary font-bold mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">analytics</span> Chiến lược ánh xạ
                    </h3>
                    <div class="space-y-6">
                        <div class="p-4 bg-surface-container-lowest rounded-xl border-l-2 border-primary">
                            <p class="font-label text-[10px] text-outline uppercase mb-1">Độ tương thích mục tiêu</p>
                            <div class="flex items-end gap-2">
                                <span class="text-3xl font-display font-black text-on-surface">100%</span>
                                <span class="text-[10px] font-label text-primary mb-1">ĐÃ ĐỒNG BỘ</span>
                            </div>
                        </div>
                        <div class="p-4 bg-surface-container-lowest rounded-xl border-l-2 border-secondary">
                            <p class="font-label text-[10px] text-outline uppercase mb-1">Tác động phủ PLO</p>
                            <div class="flex items-end gap-2">
                                <span class="text-3xl font-display font-black text-on-surface">0.85</span>
                                <span class="text-[10px] font-label text-secondary mb-1">MẬT ĐỘ</span>
                            </div>
                        </div>
                        <div class="pt-4">
                            <h4 class="font-label text-[10px] text-outline uppercase tracking-widest mb-4">Nút kiến trúc</h4>
                            <div class="space-y-2">
                                <div class="flex items-center justify-between text-xs font-label uppercase tracking-wider text-on-surface-variant">
                                    <span>Lõi chương trình</span>
                                    <span class="text-primary">Hoạt động</span>
                                </div>
                                <div class="h-1 bg-surface-container-lowest rounded-full overflow-hidden">
                                    <div class="h-full bg-primary w-2/3"></div>
                                </div>
                                <div class="flex items-center justify-between text-xs font-label uppercase tracking-wider text-on-surface-variant pt-2">
                                    <span>Ma trận đánh giá</span>
                                    <span class="text-secondary">Sẵn sàng</span>
                                </div>
                                <div class="h-1 bg-surface-container-lowest rounded-full overflow-hidden">
                                    <div class="h-full bg-secondary w-1/2"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- AI Assistant Card -->
                <div class="bg-primary-container/10 border border-primary/20 rounded-2xl p-6 relative group overflow-hidden">
                    <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:scale-110 transition-transform duration-700">
                        <span class="material-symbols-outlined text-8xl text-primary" style="font-variation-settings: 'FILL' 1;">auto_awesome</span>
                    </div>
                    <h4 class="font-label text-xs uppercase tracking-widest text-primary font-bold mb-2">Gợi ý từ AI</h4>
                    <p class="text-xs text-on-surface-variant font-body leading-relaxed mb-4">
                        "Dựa trên mã PLO {{ $plo->code ?? 'hiện tại' }}, tôi gợi ý PI nên tập trung vào khả năng thiết kế hệ thống có tính mở rộng cao."
                    </p>
                    <button class="text-[10px] font-label uppercase tracking-widest text-primary font-bold hover:underline flex items-center gap-1">
                        Áp dụng gợi ý <span class="material-symbols-outlined text-xs">chevron_right</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    // Micro-interaction for mouse tracking glow
    document.addEventListener('mousemove', (e) => {
        const x = e.clientX;
        const y = e.clientY;

        const forms = document.querySelectorAll('.bg-surface-container-low');
        forms.forEach(form => {
            const rect = form.getBoundingClientRect();
            const localX = x - rect.left;
            const localY = y - rect.top;
            form.style.background = `radial-gradient(circle at ${localX}px ${localY}px, rgba(94, 106, 210, 0.03) 0%, rgba(28, 27, 29, 1) 70%)`;
        });
    });
</script>
@endsection
