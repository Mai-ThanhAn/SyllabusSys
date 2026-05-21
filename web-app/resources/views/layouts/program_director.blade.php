<!DOCTYPE html>
<html class="dark" lang="vi">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>@yield('title', 'Syllabus Lab | Instructor Dashboard')</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&amp;family=Space+Grotesk:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "secondary-container": "#42466e",
                        "outline": "#908f9e",
                        "secondary-fixed-dim": "#c0c3f2",
                        "surface": "#131315",
                        "surface-container-lowest": "#0e0e0f",
                        "surface-variant": "#353436",
                        "on-tertiary-container": "#fffaf8",
                        "primary": "#bdc2ff",
                        "outline-variant": "#454652",
                        "surface-tint": "#bdc2ff",
                        "tertiary-fixed": "#ffddbb",
                        "on-primary-fixed-variant": "#2e3aa2",
                        "primary-fixed-dim": "#bdc2ff",
                        "on-tertiary-fixed-variant": "#673d00",
                        "surface-container-low": "#1c1b1d",
                        "secondary": "#c0c3f2",
                        "inverse-surface": "#e5e1e3",
                        "inverse-on-surface": "#313032",
                        "tertiary-fixed-dim": "#ffb867",
                        "on-background": "#e5e1e3",
                        "on-surface": "#e5e1e3",
                        "error-container": "#93000a",
                        "on-secondary": "#292d53",
                        "on-error-container": "#ffdad6",
                        "surface-container-high": "#2a2a2b",
                        "on-secondary-fixed": "#13183d",
                        "on-primary": "#121f8b",
                        "surface-dim": "#131315",
                        "on-primary-container": "#fdfaff",
                        "surface-container-highest": "#353436",
                        "on-tertiary": "#482900",
                        "on-error": "#690005",
                        "on-surface-variant": "#c6c5d5",
                        "error": "#ffb4ab",
                        "surface-container": "#201f21",
                        "on-primary-fixed": "#000965",
                        "primary-container": "#5e6ad2",
                        "background": "#131315",
                        "surface-bright": "#3a393a",
                        "secondary-fixed": "#dfe0ff",
                        "on-tertiary-fixed": "#2b1700",
                        "primary-fixed": "#dfe0ff",
                        "tertiary": "#ffb867",
                        "on-secondary-container": "#b1b5e3",
                        "tertiary-container": "#a56500",
                        "on-secondary-fixed-variant": "#3f446b"
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    fontFamily: {
                        "headline": ["Inter"],
                        "display": ["Inter"],
                        "body": ["Inter"],
                        "label": ["Space Grotesk"]
                    }
                },
            },
        }
    </script>

    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .technical-grid {
            background-image: radial-gradient(circle at 2px 2px, rgba(69, 70, 82, 0.15) 1px, transparent 0);
            background-size: 24px 24px;
        }
        .glass-panel {
            background: rgba(32, 31, 33, 0.6);
            backdrop-filter: blur(12px);
        }
        .shadow-extruded {
            box-shadow: 0 4px 0 0 rgba(18, 31, 139, 0.4);
        }
        .shadow-inset-soft {
            box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.3);
        }
        .glow-ambient {
            filter: blur(80px);
            opacity: 0.08;
            pointer-events: none;
        }
    </style>

    @stack('styles')
</head>
<body class="bg-surface text-on-surface font-body selection:bg-primary selection:text-on-primary overflow-x-hidden">
    <!-- Ambient Lighting Effects -->
    <div class="fixed top-[-10%] right-[-10%] w-125 h-125 bg-primary rounded-full glow-ambient"></div>
    <div class="fixed bottom-[-10%] left-[20%] w-150 h-150 bg-secondary-container rounded-full glow-ambient"></div>

    <!-- SideNavBar (Shared Component) -->
    <aside class="fixed left-0 top-0 flex flex-col h-screen w-64 bg-[#0e0e0f] border-r border-[#454652]/20 z-50">
        <div class="p-6 mb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-primary-container rounded-lg flex items-center justify-center shadow-lg">
                    <span class="material-symbols-outlined text-on-primary-container" style="font-variation-settings: 'FILL' 1;">science</span>
                </div>
                <div>
                    <h1 class="font-['Space_Grotesk'] font-bold text-[#e5e1e3] tracking-widest uppercase text-sm leading-tight">Syllabus Lab</h1>
                    <p class="text-[10px] text-outline uppercase tracking-tighter">Precision Orchestration</p>
                </div>
            </div>
        </div>

        <nav class="flex-1 px-3 space-y-1">
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('lecturer.dashboard') ? 'text-primary bg-primary-container/10 border-l-2 border-primary' : 'text-outline hover:text-on-surface hover:bg-surface-container' }} font-label font-medium tracking-tight text-sm uppercase transition-all duration-200"
               href="{{ route('lecturer.dashboard') }}">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">dashboard</span>
                <span>Dashboard</span>
            </a>

            <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-outline hover:text-on-surface hover:bg-surface-container font-label font-medium tracking-tight text-sm uppercase transition-all duration-200" href="#">
                <span class="material-symbols-outlined">library_books</span>
                <span>Syllabus Library</span>
            </a>

            <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-outline hover:text-on-surface hover:bg-surface-container font-label font-medium tracking-tight text-sm uppercase transition-all duration-200" href="#">
                <span class="material-symbols-outlined">auto_awesome</span>
                <span>AI Mapping</span>
            </a>

            <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-outline hover:text-on-surface hover:bg-surface-container font-label font-medium tracking-tight text-sm uppercase transition-all duration-200" href="#">
                <span class="material-symbols-outlined">settings_ethernet</span>
                <span>Technical Specs</span>
            </a>
        </nav>

        <div class="mt-auto p-4 border-t border-outline-variant/10">
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-outline hover:text-on-surface hover:bg-surface-container font-label font-medium tracking-tight text-sm uppercase transition-all duration-200" href="#">
                <span class="material-symbols-outlined">settings</span>
                <span>Cài đặt</span>
            </a>
        </div>
    </aside>

    <!-- Main Content Canvas -->
    <main class="ml-64 min-h-screen technical-grid">
        <!-- TopAppBar (Shared Component) -->
        <header class="fixed top-0 right-0 left-64 h-16 bg-[#131315]/80 backdrop-blur-xl border-b border-outline-variant/10 flex items-center justify-between px-8 z-40">
            <div class="flex items-center flex-1 max-w-xl">
                <div class="relative w-full">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-lg">search</span>
                    <input class="w-full bg-surface-container-lowest border-none rounded-lg pl-10 pr-4 py-2 text-sm text-on-surface placeholder:text-outline/50 focus:ring-1 focus:ring-primary-container/30 shadow-inset-soft"
                           placeholder="Tìm kiếm tài liệu học thuật..."
                           type="text"/>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <button class="w-10 h-10 flex items-center justify-center rounded-full text-outline hover:bg-[#353436]/40 transition-colors">
                    <span class="material-symbols-outlined">notifications</span>
                </button>
                <button class="w-10 h-10 flex items-center justify-center rounded-full text-outline hover:bg-[#353436]/40 transition-colors">
                    <span class="material-symbols-outlined">help_outline</span>
                </button>
                <div class="h-8 w-px bg-outline-variant/20 mx-2"></div>
                <div class="flex items-center gap-3 pl-2">
                    <div class="text-right hidden sm:block">
                        <p class="text-xs font-semibold text-on-surface leading-none">{{ Auth::user()->full_name ?? 'Nguyễn Giảng Viên' }}</p>
                        <p class="text-[10px] text-outline font-label uppercase tracking-widest mt-1">Giảng viên</p>
                    </div>
                    <img alt="Profile" class="w-8 h-8 rounded-full border border-outline-variant/30 object-cover"
                         src="https://lh3.googleusercontent.com/aida-public/AB6AXuADoqwzkaotYRoNfBvQOVUzFkpQM2c4QnP0LFxbgkyfZSNMW5c_Fdbkwrfhi_RyotLPmr_3ZXqw29r07f6aR6eI9drrdSi6-WmuhHMtVGO8q-WQ6IaGuOLun9D0wGDNbCJkgtwmiBoGc_TjN4L2rmwpWPXo6NcHs-Da6zpliBCw88gRsscrCVjPU9-Cn3QfdCnJZrZCkqMC4LX5Tf2dHk7eL712wNRUmH9oeik5awhRWQwRXns2Rfzq97PhtVl_S6clSJTsw6AUdOxp"/>
                </div>
            </div>
        </header>

        <div class="pt-24 px-8 pb-12">
            @yield('content')
        </div>
    </main>

    <script>
        document.addEventListener('mousemove', (e) => {
            const panels = document.querySelectorAll('.glass-panel, .bg-surface-container');
            panels.forEach(panel => {
                const rect = panel.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                panel.style.setProperty('--mouse-x', `${x}px`);
                panel.style.setProperty('--mouse-y', `${y}px`);
            });
        });

        window.addEventListener('DOMContentLoaded', () => {
            console.log("Syllabus Lab System Initialized...");
        });
    </script>

    @stack('scripts')
</body>
</html>
