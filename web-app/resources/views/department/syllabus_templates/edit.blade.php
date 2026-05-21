@extends('layouts.department')

@section('title', 'Sửa khung đề cương | TechSyllabus')

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

    body, main {
        background: #0a0a0c;
    }
</style>
<section class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
    <div class="w-full max-w-2xl">
        <!-- Breadcrumbs -->
        <div class="flex items-center gap-2 mb-4 text-on-surface-variant">
            <a class="text-xs font-label uppercase tracking-widest hover:text-primary transition-colors" href="{{ route('department.syllabus-templates.index') }}">Library</a>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <span class="text-xs font-label uppercase tracking-widest text-primary">Sửa khung đề cương</span>
        </div>

        <div class="mb-8 flex items-center justify-between">
            <div>
                <h2 class="text-display-lg font-bold tracking-tighter text-on-surface mb-1" style="font-size: 2.5rem; line-height: 1.1;">Sửa khung đề cương</h2>
                <p class="text-on-surface-variant font-body text-sm">Hiệu chỉnh cấu trúc và thông số kỹ thuật của đề cương môn học.</p>
            </div>
            <a href="{{ route('department.syllabus-templates.index') }}" class="flex items-center gap-2 px-4 py-2 text-on-surface-variant hover:text-on-surface transition-all font-label text-xs uppercase tracking-widest bg-surface-container-low rounded-lg border border-outline-variant/10">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                Quay lại
            </a>
        </div>

        <!-- Error Alerts -->
        @if($errors->any())
        <div class="mb-6 p-4 rounded-xl bg-error-container/20 border-l-4 border-error flex gap-4 animate-in fade-in slide-in-from-top-4 duration-300">
            <span class="material-symbols-outlined text-error" style="font-variation-settings: 'FILL' 1;">error</span>
            <div class="space-y-1">
                <p class="text-on-error-container font-bold text-sm">Có lỗi xảy ra trong quá trình xử lý:</p>
                <ul class="text-xs text-on-error-container/80 list-disc list-inside">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        <!-- Form Container -->
        <div class="bg-surface-container border border-outline-variant/10 rounded-xl p-8 relative overflow-hidden shadow-2xl">
            <!-- Decorative AI Grid Line -->
            <div class="absolute top-0 left-0 w-1 h-full bg-primary-container"></div>

            <form action="{{ route('department.syllabus-templates.update', $template->id) }}" class="space-y-8" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Template Name Input -->
                    <div class="group">
                        <label class="block font-label text-[10px] uppercase tracking-[0.15em] text-on-surface-variant mb-2 transition-colors group-focus-within:text-primary">
                            Tên khung đề cương
                        </label>
                        <div class="relative">
                            <input class="w-full bg-surface-container-lowest border-outline-variant/20 rounded-lg px-4 py-3.5 font-body text-on-surface focus:ring-2 focus:ring-primary-container/50 focus:border-primary-container transition-all shadow-inset-soft"
                                   name="template_name"
                                   placeholder="VD: Khung chuẩn đào tạo 2024 - Khối Kỹ thuật"
                                   type="text"
                                   value="{{ old('template_name', $template->template_name) }}"/>
                            <div class="absolute right-4 top-1/2 -translate-y-1/2 opacity-20 pointer-events-none">
                                <span class="material-symbols-outlined text-lg">format_italic</span>
                            </div>
                        </div>
                    </div>

                    <!-- Description Textarea -->
                    <div class="group">
                        <label class="block font-label text-[10px] uppercase tracking-[0.15em] text-on-surface-variant mb-2 transition-colors group-focus-within:text-primary">
                            Mô tả chi tiết
                        </label>
                        <textarea class="w-full bg-surface-container-lowest border-outline-variant/20 rounded-lg px-4 py-3.5 font-body text-on-surface focus:ring-2 focus:ring-primary-container/50 focus:border-primary-container transition-all shadow-inset-soft resize-none"
                                  name="description"
                                  placeholder="Mô tả mục tiêu, phạm vi áp dụng và các phiên bản kỹ thuật..."
                                  rows="5">{{ old('description', $template->description) }}</textarea>
                    </div>

                    <!-- Status Toggle -->
                    <div class="flex items-center justify-between p-4 bg-surface-container-low rounded-lg border border-outline-variant/10">
                        <div class="flex gap-3 items-center">
                            <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                                <span class="material-symbols-outlined">verified_user</span>
                            </div>
                            <div>
                                <p class="font-bold text-sm text-on-surface">Trạng thái sử dụng</p>
                                <p class="text-xs text-on-surface-variant">Kích hoạt để áp dụng ngay cho các chương trình đào tạo thuộc viện.</p>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input class="sr-only peer" name="is_active" type="checkbox" @checked($template->is_active)>
                            <div class="w-11 h-6 bg-surface-container-highest peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-0.5 after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-container shadow-inset-soft"></div>
                        </label>
                    </div>
                </div>

                <!-- Actions -->
                <div class="pt-6 border-t border-outline-variant/10 flex items-center justify-end gap-4">
                    <a href="{{ route('department.syllabus-templates.index') }}" class="px-6 py-2.5 rounded-lg font-label text-xs uppercase tracking-widest text-on-surface-variant hover:text-on-surface transition-colors">
                        Hủy bỏ
                    </a>
                    <button class="px-8 py-3.5 bg-primary-container text-on-primary-container rounded-lg font-bold flex items-center gap-2 shadow-extruded hover:brightness-110 active:scale-95 transition-all" type="submit">
                        <span class="material-symbols-outlined">save</span>
                        Cập nhật hệ thống
                    </button>
                </div>
            </form>
        </div>

        <!-- Meta Information Card -->
        <div class="mt-6 grid grid-cols-3 gap-4">
            <div class="bg-surface-container-low p-4 rounded-xl border border-outline-variant/5">
                <p class="font-label text-[9px] uppercase tracking-widest text-on-surface-variant mb-1">Mã Khung Đề Cương</p>
                <p class="text-xs font-mono text-primary">ID: {{ str_pad($template->id, 4, '0', STR_PAD_LEFT) }}</p>
            </div>
            <div class="bg-surface-container-low p-4 rounded-xl border border-outline-variant/5">
                <p class="font-label text-[9px] uppercase tracking-widest text-on-surface-variant mb-1">Cập nhật cuối</p>
                <p class="text-xs font-body text-on-surface">{{ $template->updated_at ? $template->updated_at->format('d/m/Y') : date('d/m/Y') }}</p>
            </div>
            <div class="bg-surface-container-low p-4 rounded-xl border border-outline-variant/5">
                <p class="font-label text-[9px] uppercase tracking-widest text-on-surface-variant mb-1">Người thực hiện</p>
                <p class="text-xs font-body text-on-surface">Admin_Lab_01</p>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    // Micro-interactions for form focus effects
    document.querySelectorAll('input, textarea').forEach(el => {
        el.addEventListener('focus', () => {
            el.parentElement.classList.add('scale-[1.01]');
        });
        el.addEventListener('blur', () => {
            el.parentElement.classList.remove('scale-[1.01]');
        });
    });

    // Spotlight effect
    const mainCard = document.querySelector('.bg-surface-container');
    if (mainCard) {
        mainCard.addEventListener('mousemove', (e) => {
            const rect = mainCard.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            mainCard.style.backgroundImage = `radial-gradient(400px circle at ${x}px ${y}px, rgba(94, 106, 210, 0.05), transparent 80%)`;
        });
        mainCard.addEventListener('mouseleave', () => {
            mainCard.style.backgroundImage = 'none';
        });
    }
</script>
@endpush
