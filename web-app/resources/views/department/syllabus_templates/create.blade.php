@extends('layouts.department')

@section('title', 'Thêm khung đề cương | TechSyllabus')

@section('content')
<main class="ml-64 p-8 min-h-[calc(100vh-72px)] flex flex-col items-center">
    <!-- Breadcrumb / Back Link -->
    <div class="w-full max-w-2xl mb-8">
        <a href="{{ route('department.syllabus-templates.index') }}" class="inline-flex items-center gap-2 text-on-surface-variant hover:text-primary transition-colors group">
            <span class="material-symbols-outlined text-sm group-hover:-translate-x-1 transition-transform">arrow_back</span>
            <span class="font-label text-label-md tracking-widest uppercase">Back to Library</span>
        </a>
    </div>

    <!-- Focused Form Container -->
    <div class="w-full max-w-2xl glass-panel rounded-xl p-8 border border-outline-variant/10 relative overflow-hidden">
        <!-- Subtle Laboratory Detail -->
        <div class="absolute top-0 right-0 w-32 h-32 bg-primary-container/5 rounded-full -mr-16 -mt-16 blur-3xl"></div>

        <div class="mb-8">
            <h2 class="font-headline text-2xl font-bold tracking-tight text-on-surface">Thêm khung đề cương</h2>
            <div class="h-1 w-12 bg-primary mt-2"></div>
        </div>

        <!-- Error Block -->
        @if($errors->any())
        <div class="mb-8 p-4 bg-error-container/10 border-l-4 border-error rounded-r-lg flex items-start gap-3">
            <span class="material-symbols-outlined text-error" style="font-variation-settings: 'FILL' 1;">warning</span>
            <div class="space-y-1">
                <p class="font-label text-label-md text-error tracking-wide uppercase">Dữ liệu không hợp lệ</p>
                <ul class="text-body-md text-on-surface-variant/80 list-disc list-inside space-y-0.5">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        <form method="POST" action="{{ route('department.syllabus-templates.store') }}" class="space-y-6">
            @csrf

            <!-- Input: Tên khung -->
            <div class="space-y-2 group">
                <label class="font-label text-label-md text-on-surface-variant uppercase tracking-widest flex items-center gap-2 group-focus-within:text-primary transition-colors" for="template_name">
                    Tên khung
                    <span class="text-primary/50 text-[10px]">* REQUIRED</span>
                </label>
                <div class="relative">
                    <input class="w-full bg-surface-container-lowest border border-outline-variant/20 rounded-lg py-4 px-4 text-on-surface font-body shadow-inset-soft transition-all focus:ring-primary/20 focus:outline-none focus:border-primary"
                           id="template_name"
                           name="template_name"
                           placeholder="VD: Khung chương trình đào tạo kỹ sư phần mềm 2024"
                           type="text"
                           value="{{ old('template_name') }}">
                </div>
            </div>

            <!-- Textarea: Mô tả -->
            <div class="space-y-2 group">
                <label class="font-label text-label-md text-on-surface-variant uppercase tracking-widest flex items-center gap-2 group-focus-within:text-primary transition-colors" for="description">
                    Mô tả chi tiết
                </label>
                <textarea class="w-full bg-surface-container-lowest border border-outline-variant/20 rounded-lg py-4 px-4 text-on-surface font-body shadow-inset-soft transition-all focus:ring-primary/20 focus:outline-none focus:border-primary resize-none"
                          id="description"
                          name="description"
                          placeholder="Nhập thông tin mô tả chi tiết cho khung đề cương này..."
                          rows="5">{{ old('description') }}</textarea>
            </div>

            <!-- Checkbox/Toggle: Đang sử dụng -->
            <div class="flex items-center gap-3 pt-2">
                <div class="relative inline-block w-12 h-6 cursor-pointer">
                    <input class="sr-only peer"
                           id="is_active"
                           name="is_active"
                           type="checkbox"
                           {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                    <div class="w-full h-full bg-surface-container-highest rounded-full transition-colors peer-checked:bg-primary/40 border border-outline-variant/30"></div>
                    <div class="absolute left-1 top-1 w-4 h-4 bg-on-surface-variant rounded-full transition-all peer-checked:translate-x-6 peer-checked:bg-primary shadow-lg"></div>
                </div>
                <label class="font-label text-label-md text-on-surface-variant uppercase tracking-widest cursor-pointer select-none" for="is_active">
                    Đang sử dụng hệ thống
                </label>
            </div>

            <!-- Actions -->
            <div class="pt-8 flex items-center justify-end gap-4 border-t border-outline-variant/10">
                <a href="{{ route('department.syllabus-templates.index') }}" class="px-6 py-3 rounded-lg font-label text-label-md uppercase tracking-widest text-on-surface-variant hover:text-on-surface transition-colors">
                    Hủy bỏ
                </a>
                <button class="px-10 py-3 rounded-lg bg-primary-container text-on-primary-container font-bold shadow-extruded hover:brightness-110 active:scale-95 transition-all flex items-center gap-2 group" type="submit">
                    <span class="material-symbols-outlined text-sm transition-transform group-hover:rotate-12">save</span>
                    Lưu thiết lập
                </button>
            </div>
        </form>
    </div>

    <!-- Secondary Info Cards (Asymmetric Technical Layout) -->
    <div class="w-full max-w-2xl mt-8 grid grid-cols-3 gap-6">
        <div class="col-span-2 bg-surface-container-low rounded-xl p-6 border border-outline-variant/5">
            <div class="flex items-center gap-2 mb-3">
                <span class="material-symbols-outlined text-primary text-sm">info</span>
                <h4 class="font-label text-[10px] uppercase tracking-widest text-on-surface-variant">System Log</h4>
            </div>
            <p class="text-xs text-on-surface-variant/60 leading-relaxed font-label">
                Templates created will be immediately available for syllabus mapping across all departments. Ensure the CLO (Course Learning Outcomes) structure matches the accreditation standards.
            </p>
        </div>
        <div class="bg-surface-container-low rounded-xl p-6 border border-outline-variant/5 flex flex-col justify-center">
            <span class="text-3xl font-display font-bold text-primary/20 mb-1">v4.2</span>
            <span class="font-label text-[10px] uppercase tracking-widest text-on-surface-variant">Engine Version</span>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    // Toggle handling visuals
    const toggleInput = document.getElementById('is_active');
    const toggleLabel = toggleInput?.nextElementSibling?.nextElementSibling;

    if (toggleInput && toggleLabel) {
        const updateToggleStyle = () => {
            if(toggleInput.checked) {
                toggleLabel.classList.add('text-primary');
                toggleLabel.classList.remove('text-on-surface-variant');
            } else {
                toggleLabel.classList.remove('text-primary');
                toggleLabel.classList.add('text-on-surface-variant');
            }
        };

        toggleInput.addEventListener('change', updateToggleStyle);
        updateToggleStyle(); // Initialize on page load
    }
</script>
@endpush
