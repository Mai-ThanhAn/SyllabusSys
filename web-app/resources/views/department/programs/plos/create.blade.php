@extends('layouts.department')

@section('title', 'Tạo Mới PLO | Syllabus Lab')

@section('content')
<!-- Main Content Canvas -->
<main class="ml-64 mt-16 p-10 h-[calc(100vh-4rem)] overflow-y-auto z-10 relative">
    <div class="max-w-5xl mx-auto">
        <!-- Breadcrumb & Header -->
        <div class="mb-8">
            <div class="flex items-center gap-2 text-xs font-['Space_Grotesk'] text-outline mb-2 uppercase tracking-widest">
                <span>Chương trình</span>
                <span class="material-symbols-outlined text-[10px]">chevron_right</span>
                <span>{{ $program->name }}</span>
                <span class="material-symbols-outlined text-[10px]">chevron_right</span>
                <span class="text-primary">Program Learning Outcomes</span>
            </div>
            <h2 class="text-4xl font-bold tracking-tighter font-display mb-2">Thêm PLO</h2>
            <p class="text-on-surface-variant max-w-2xl">Khởi tạo một Program Learning Outcome (PLO) mới để ánh xạ với các năng lực cốt lõi của chương trình đào tạo.</p>
        </div>

        <!-- Dashboard/Form Grid Layout -->
        <div class="grid grid-cols-12 gap-8">
            <!-- Main Form Column -->
            <div class="col-span-12 lg:col-span-8">
                <section class="bg-surface-container rounded-xl p-8 border border-outline-variant/10 shadow-sm">
                    <!-- Error Notification -->
                    @if($errors->any())
                        <div class="mb-8 terminal-accent bg-error-container/10 p-4 rounded-r-lg border-l-2 border-error">
                            <div class="flex items-start gap-3">
                                <span class="material-symbols-outlined text-error" style="font-variation-settings: 'FILL' 1;">warning</span>
                                <div>
                                    <h4 class="text-sm font-semibold text-error uppercase tracking-wider font-label">Cảnh báo: Lỗi xác thực</h4>
                                    <ul class="text-xs text-on-surface-variant mt-1 space-y-1">
                                        @foreach($errors->all() as $error)
                                            <li>• {{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('department.programs.plos.store', $program->id) }}" class="space-y-8" method="POST">
                        @csrf

                        <!-- PLO Code Field -->
                        <div class="space-y-2">
                            <label class="block font-label text-[10px] uppercase tracking-widest text-outline font-bold" for="code">
                                Mã định danh PLO
                            </label>
                            <input class="w-full bg-surface-container-lowest border-0 rounded-lg p-4 text-on-surface shadow-inset-soft focus:ring-1 focus:ring-primary-container transition-all outline-none font-['Space_Grotesk']"
                                   id="code"
                                   name="code"
                                   placeholder="Ví dụ: PLO-101"
                                   type="text"
                                   value="{{ old('code') }}"/>
                        </div>

                        <!-- Description Field -->
                        <div class="space-y-2">
                            <label class="block font-label text-[10px] uppercase tracking-widest text-outline font-bold" for="description">
                                Mô tả chi tiết
                            </label>
                            <textarea class="w-full bg-surface-container-lowest border-0 rounded-lg p-4 text-on-surface shadow-inset-soft focus:ring-1 focus:ring-primary-container transition-all outline-none resize-none"
                                      id="description"
                                      name="description"
                                      placeholder="Mô tả năng lực mà sinh viên sẽ đạt được sau khi hoàn thành chương trình..."
                                      rows="6">{{ old('description') }}</textarea>
                            <div class="flex justify-between items-center px-1">
                                <span class="text-[10px] text-outline italic">Khuyến nghị phân tích mật độ ngữ nghĩa.</span>
                                <span class="text-[10px] text-outline">{{ strlen(old('description', '')) }} / 500 ký tự</span>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="pt-6 flex items-center gap-4">
                            <button class="bg-primary-container text-on-primary-container px-8 py-3 rounded-lg font-bold shadow-extruded flex items-center gap-2 hover:scale-[1.02] transition-transform"
                                    type="submit">
                                <span class="material-symbols-outlined text-sm">save</span>
                                Lưu PLO
                            </button>
                            <a href="{{ route('programs.plos.index', $program->id) }}"
                               class="px-6 py-3 border border-outline-variant/30 rounded-lg text-on-surface-variant hover:bg-surface-container-high transition-colors font-medium">
                                Hủy bỏ
                            </a>
                        </div>
                    </form>
                </section>
            </div>

            <!-- Technical Specs / Metadata Column -->
            <div class="col-span-12 lg:col-span-4 space-y-6">
                <!-- AI Insight Card -->
                <div class="bg-surface-container-high rounded-xl p-6 border border-primary-container/20 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-30 transition-opacity">
                        <span class="material-symbols-outlined text-5xl">auto_awesome</span>
                    </div>
                    <h3 class="font-label text-xs uppercase tracking-widest text-primary mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">memory</span>
                        Trợ lý AI
                    </h3>
                    <p class="text-sm text-on-surface-variant leading-relaxed">
                        Tôi đã phân tích cấu trúc chương trình hiện tại của bạn. Với chương trình <span class="text-secondary font-mono">{{ $program->name }}</span>,
                        hầu hết các PLO đều tập trung vào <span class="italic">kiến thức nền tảng</span>.
                        Hãy cân nhắc thêm PLO liên quan đến <span class="text-on-surface underline decoration-primary/50">kỹ năng thực hành và ứng dụng thực tế</span>.
                    </p>
                    <button class="mt-4 text-xs font-bold text-primary flex items-center gap-1 hover:underline">
                        Tạo gợi ý
                        <span class="material-symbols-outlined text-xs">arrow_forward</span>
                    </button>
                </div>

                <!-- Quality Parameters Card -->
                <div class="bg-surface-container-lowest rounded-xl p-6 border border-outline-variant/10 shadow-sm">
                    <h3 class="font-label text-[10px] uppercase tracking-widest text-outline font-bold mb-4">Thông số chất lượng</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-on-surface-variant">Phân loại Bloom</span>
                            <span class="text-[10px] bg-secondary-container/30 text-on-secondary-container px-2 py-0.5 rounded font-mono">Cấp độ 4: Phân tích</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-on-surface-variant">Trọng số tín chỉ</span>
                            <span class="text-[10px] text-on-surface font-mono">3.0 đơn vị</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-on-surface-variant">Trạng thái ánh xạ</span>
                            <div class="flex items-center gap-1.5">
                                <div class="w-2 h-2 rounded-full bg-error animate-pulse"></div>
                                <span class="text-[10px] text-on-surface font-mono uppercase">Chưa ánh xạ</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Visual Reference Card -->
                <div class="bg-surface-container rounded-xl overflow-hidden border border-outline-variant/10">
                    <div class="h-40 bg-surface-container-high relative">
                        <img class="w-full h-full object-cover opacity-40 mix-blend-luminosity"
                             alt="Sơ đồ kiến trúc học thuật"
                             src="https://lh3.googleusercontent.com/aida-public/AB6AXuCdnoUfmvhD8pTC9AFmlzdR6y2tGeP2tqYxhrNq08VTLgdbMY72Zx-1QaIa6_3MdNj2fkImAYbZo-0TwXYVf250DeDgMyZl7OEN0J3JoMKG2tXaQz00UitXaiZ6zhPjxeXFrlonMuaJY6KJvQtC6vC6CawZ21u7XqTCS2BTejnLz-cdAuhKleLQWja3V2CQeIwXjrXm09tOEipzjr15H573ezqcrvbNonGGDo_qbx8cp_8ZQpjt-rnFkJsYitBcfxN20JoO3qBcZK3R"/>
                        <div class="absolute inset-0 bg-linear-to-t from-surface-container to-transparent"></div>
                        <div class="absolute bottom-4 left-4">
                            <span class="text-[10px] font-label uppercase tracking-widest text-primary font-bold">{{ $program->name }} - Blueprint</span>
                        </div>
                    </div>
                    <div class="p-4">
                        <p class="text-xs text-on-surface-variant italic leading-snug">
                            "Việc ánh xạ giữa kết quả đầu ra và đánh giá là kết nối đầu cuối của kiến trúc học thuật."
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Custom Cursor Glow Micro-interaction -->
<div class="fixed w-64 h-64 bg-primary-container/10 rounded-full blur-[80px] pointer-events-none z-50 transition-opacity duration-300 opacity-0" id="cursor-glow"></div>

<script>
    // Micro-interaction: Mouse tracking spotlight
    const glow = document.getElementById('cursor-glow');
    if (glow) {
        document.addEventListener('mousemove', (e) => {
            glow.style.opacity = '1';
            glow.style.left = `${e.clientX - 128}px`;
            glow.style.top = `${e.clientY - 128}px`;
        });
    }

    // Toggle focus on inputs
    const inputs = document.querySelectorAll('input, textarea');
    inputs.forEach(input => {
        input.addEventListener('focus', () => {
            const label = input.closest('.space-y-2')?.querySelector('label');
            if (label) label.style.color = '#bdc2ff';
        });
        input.addEventListener('blur', () => {
            const label = input.closest('.space-y-2')?.querySelector('label');
            if (label) label.style.color = '';
        });

        // Character counter for description
        if (input.id === 'description') {
            input.addEventListener('input', (e) => {
                const counter = input.closest('.space-y-2')?.querySelector('.flex.justify-between.items-center .text-outline:last-child');
                if (counter) {
                    counter.textContent = `${e.target.value.length} / 500 ký tự`;
                }
            });
        }
    });
</script>
@endsection
