<!DOCTYPE html>
<html class="dark" lang="vi">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Authentication Protocol | Syllabus_System</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&amp;family=Space+Grotesk:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "surface-container": "#201f21",
                        "on-primary-fixed": "#000965",
                        "on-error-container": "#ffdad6",
                        "background": "#131315",
                        "surface-container-highest": "#353436",
                        "secondary": "#c0c3f2",
                        "on-tertiary-fixed": "#2b1700",
                        "on-error": "#690005",
                        "surface-bright": "#3a393a",
                        "on-primary-fixed-variant": "#2e3aa2",
                        "on-background": "#e5e1e3",
                        "on-secondary-fixed": "#13183d",
                        "inverse-surface": "#e5e1e3",
                        "on-surface-variant": "#c6c5d5",
                        "primary": "#bdc2ff",
                        "on-surface": "#e5e1e3",
                        "inverse-primary": "#4854bb",
                        "error-container": "#93000a",
                        "tertiary-container": "#a56500",
                        "surface": "#131315",
                        "secondary-fixed-dim": "#c0c3f2",
                        "primary-container": "#5e6ad2",
                        "primary-fixed": "#dfe0ff",
                        "on-secondary": "#292d53",
                        "surface-container-high": "#2a2a2b",
                        "on-tertiary-fixed-variant": "#673d00",
                        "error": "#ffb4ab",
                        "surface-variant": "#353436",
                        "tertiary-fixed": "#ffddbb",
                        "surface-tint": "#bdc2ff",
                        "outline-variant": "#454652",
                        "tertiary-fixed-dim": "#ffb867",
                        "outline": "#908f9e",
                        "on-primary-container": "#fdfaff",
                        "tertiary": "#ffb867",
                        "surface-container-lowest": "#0e0e0f",
                        "on-primary": "#121f8b",
                        "on-secondary-container": "#b1b5e3",
                        "secondary-container": "#42466e",
                        "primary-fixed-dim": "#bdc2ff",
                        "secondary-fixed": "#dfe0ff",
                        "on-secondary-fixed-variant": "#3f446b",
                        "surface-dim": "#131315",
                        "on-tertiary-container": "#fffaf8",
                        "inverse-on-surface": "#313032",
                        "on-tertiary": "#482900",
                        "surface-container-low": "#1c1b1d"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "fontFamily": {
                        "headline": ["Inter"],
                        "display": ["Inter"],
                        "body": ["Inter"],
                        "label": ["Space Grotesk"]
                    }
                }
            }
        }
    </script>

    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .shadow-extruded {
            box-shadow: 0 4px 0 0 rgba(94, 106, 210, 0.4);
        }

        .shadow-inset-soft {
            box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.3);
        }

        .bg-grid {
            background-image: radial-gradient(circle, #454652 1px, transparent 1px);
            background-size: 32px 32px;
            background-position: center;
        }

        .cursor-glow {
            position: fixed;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(94, 106, 210, 0.15), transparent 70%);
            border-radius: 50%;
            pointer-events: none;
            transform: translate(-50%, -50%);
            z-index: 1000;
            transition: transform 0.05s ease;
        }

        ::-webkit-scrollbar {
            width: 4px;
        }

        ::-webkit-scrollbar-track {
            background: #0e0e0f;
        }

        ::-webkit-scrollbar-thumb {
            background: #454652;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #bdc2ff;
        }

        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-in {
            animation: fade-in 0.3s ease-out;
        }
    </style>
</head>
<body class="bg-background text-on-surface font-body selection:bg-primary-container selection:text-on-primary-container overflow-hidden">
    <div class="cursor-glow" id="glow"></div>

    <main class="relative min-h-screen flex items-center justify-center p-6">
        <!-- Ambient Grid & Laboratory Atmosphere -->
        <div class="absolute inset-0 bg-grid pointer-events-none"></div>
        <div class="absolute top-0 left-1/4 w-125 h-125 bg-primary-container/5 blur-[120px] rounded-full pointer-events-none"></div>

        <!-- Login Container -->
        <div class="relative w-full max-w-md z-10">
            <!-- Technical Watermark / Logo -->
            <div class="flex flex-col items-center mb-10">
                <div class="w-16 h-16 mb-6 rounded-xl bg-surface-container border border-outline-variant/20 flex items-center justify-center relative overflow-hidden group">
                    <div class="absolute inset-0 bg-linear-to-br from-primary/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <span class="material-symbols-outlined text-primary-fixed-dim text-3xl" style="font-variation-settings: 'FILL' 1;">auto_stories</span>
                    <div class="absolute top-0 left-0 w-2 h-2 border-t border-l border-primary/40"></div>
                    <div class="absolute bottom-0 right-0 w-2 h-2 border-b border-r border-primary/40"></div>
                </div>
                <h2 class="font-label text-[10px] uppercase tracking-[0.3em] text-primary mb-2">Syllabus System</h2>
                <h1 class="text-3xl font-display font-bold tracking-tighter text-on-surface">Đăng Nhập Hệ Thống</h1>
                <p class="text-on-surface-variant text-sm mt-2 font-medium">Vui Lòng Đăng Nhập Để Tiếp Tục Sử Dụng Hệ Thống</p>
            </div>

            <!-- Error Handling -->
            @if(session('error'))
            <div class="mb-6 p-4 rounded-lg bg-error-container/20 border-l-4 border-error flex items-start gap-3 animate-in fade-in slide-in-from-top-2 duration-300" id="error-alert">
                <span class="material-symbols-outlined text-error" style="font-variation-settings: 'FILL' 1;">warning</span>
                <div>
                    <h4 class="font-label text-[10px] uppercase tracking-wider text-error font-bold">Protocol Failure</h4>
                    <p class="text-xs text-on-error-container mt-1">{{ session('error') }}</p>
                </div>
            </div>
            @endif

            <!-- Auth Card -->
            <div class="bg-surface-container-low/80 backdrop-blur-xl rounded-2xl border border-outline-variant/10 p-8 shadow-2xl overflow-hidden relative">
                <div class="absolute top-0 left-0 w-full h-px bg-linear-to-r from-transparent via-outline-variant/30 to-transparent"></div>

                <form action="{{ route('login.post') }}" class="space-y-6" method="POST">
                    @csrf

                    <!-- Email Field -->
                    <div class="space-y-2">
                        <div class="flex justify-between items-center px-1">
                            <label class="font-label text-[10px] uppercase tracking-widest text-on-surface-variant font-bold" for="email">Email Address</label>
                        </div>
                        <div class="relative group">
                            <input class="w-full bg-surface-container-lowest border-0 rounded-lg py-3 px-4 text-on-surface placeholder:text-outline/30 focus:ring-2 focus:ring-primary/50 transition-all shadow-inset-soft font-body text-sm @error('email') ring-2 ring-error/50 @enderror"
                                   id="email"
                                   name="email"
                                   placeholder="name@syllabus-lab.edu"
                                   required
                                   type="email"
                                   value="{{ old('email') }}">
                            <div class="absolute inset-0 rounded-lg pointer-events-none border border-outline-variant/20 group-focus-within:border-primary/50 transition-colors"></div>
                        </div>
                        @error('email')
                        <p class="text-xs text-error mt-1 px-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="space-y-2">
                        <div class="flex justify-between items-center px-1">
                            <label class="font-label text-[10px] uppercase tracking-widest text-on-surface-variant font-bold" for="password">Mật Khẩu</label>
                        </div>
                        <div class="relative group">
                            <input class="w-full bg-surface-container-lowest border-0 rounded-lg py-3 px-4 text-on-surface placeholder:text-outline/30 focus:ring-2 focus:ring-primary/50 transition-all shadow-inset-soft font-body text-sm @error('password') ring-2 ring-error/50 @enderror"
                                   id="password"
                                   name="password"
                                   placeholder="••••••••••••"
                                   required
                                   type="password">
                            <div class="absolute inset-0 rounded-lg pointer-events-none border border-outline-variant/20 group-focus-within:border-primary/50 transition-colors"></div>
                        </div>
                        @error('password')
                        <p class="text-xs text-error mt-1 px-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Form Utilities -->
                    <div class="flex items-center justify-between px-1">
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <div class="relative w-4 h-4 bg-surface-container-lowest rounded shadow-inset-soft border border-outline-variant/20 group-hover:border-primary/50 transition-colors">
                                <input class="absolute inset-0 opacity-0 cursor-pointer peer" type="checkbox" name="remember">
                                <span class="material-symbols-outlined text-primary scale-0 peer-checked:scale-100 transition-transform text-xs flex items-center justify-center h-full w-full">check</span>
                            </div>
                            <span class="text-xs text-on-surface-variant group-hover:text-on-surface transition-colors">Ghi Nhớ Mật Khẩu</span>
                        </label>
                        <a class="text-xs text-primary/80 hover:text-primary transition-colors font-medium" href="#">Quên Mật Khẩu</a>
                    </div>

                    <!-- Action Button -->
                    <div class="pt-4">
                        <button class="w-full py-4 rounded-xl bg-primary-container text-on-primary-container font-label uppercase tracking-[0.2em] text-xs font-bold shadow-extruded transition-all flex items-center justify-center gap-3 group relative overflow-hidden" type="submit">
                            <span class="relative z-10">Đăng Nhập</span>
                            <span class="material-symbols-outlined text-sm relative z-10 group-hover:translate-x-1 transition-transform">arrow_forward_ios</span>
                            <div class="absolute inset-0 bg-linear-to-r from-white/0 via-white/10 to-white/0 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                        </button>
                    </div>
                </form>

                <!-- Lab Metadata Footer -->
                <div class="mt-8 pt-6 border-t border-outline-variant/10 flex justify-between items-center opacity-40">
                    <div class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span>
                        <span class="font-label text-[8px] uppercase tracking-tighter">System: Stable</span>
                    </div>
                    <span class="font-label text-[8px] uppercase tracking-tighter">V2.4.08-ACADEMIC</span>
                </div>
            </div>

            <!-- Footer Links -->
            <div class="mt-8 flex justify-center gap-8">
                <a class="font-label text-[10px] uppercase tracking-widest text-outline hover:text-primary transition-colors" href="#">Documentation</a>
                <a class="font-label text-[10px] uppercase tracking-widest text-outline hover:text-primary transition-colors" href="#">API Status</a>
                <a class="font-label text-[10px] uppercase tracking-widest text-outline hover:text-primary transition-colors" href="#">Security</a>
            </div>
        </div>
    </main>

    <!-- Visual Polish: Floating Lab Equipment Shadows -->
    <div class="fixed bottom-10 right-10 opacity-10 pointer-events-none transform rotate-12 scale-150">
        <span class="material-symbols-outlined text-[300px] text-primary">auto_stories</span>
    </div>
    <div class="fixed top-20 left-10 opacity-10 pointer-events-none transform -rotate-12 scale-110">
        <span class="material-symbols-outlined text-[150px] text-secondary">database</span>
    </div>

    <script>
        // Mouse follow effect for the laboratory glow
        const glow = document.getElementById('glow');
        if (glow) {
            document.addEventListener('mousemove', (e) => {
                glow.style.left = e.clientX + 'px';
                glow.style.top = e.clientY + 'px';
            });
        }

        // Add subtle focus animation to inputs
        const inputs = document.querySelectorAll('input:not([type="checkbox"])');
        inputs.forEach(input => {
            input.addEventListener('focus', () => {
                const label = input.closest('.space-y-2')?.querySelector('.font-label');
                if (label) label.classList.add('text-primary');
            });
            input.addEventListener('blur', () => {
                const label = input.closest('.space-y-2')?.querySelector('.font-label');
                if (label) label.classList.remove('text-primary');
            });
        });
    </script>
</body>
</html>
