<!DOCTYPE html>
<html class="dark" lang="vi">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>@yield('title', 'TechSyllabus | Academic Lab Admin')</title>

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

        .glass-panel {
            backdrop-filter: blur(12px);
            background: rgba(32, 31, 33, 0.7);
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

        @keyframes spotlight {
            from {
                background-position: 0% 0%;
            }
            to {
                background-position: var(--x) var(--y);
            }
        }

        .animate-in {
            animation: fade-in 0.3s ease-out;
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

        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .max-w-xs {
            max-width: 20rem;
        }
    </style>

    @stack('styles')
</head>
<body class="text-on-surface font-body overflow-x-hidden selection:bg-primary/30">
    <!-- Laboratory Ambient Background Effects -->
    <div class="fixed inset-0 pointer-events-none z-0">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-primary-container/10 blur-[120px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[30%] h-[30%] rounded-full bg-secondary-container/10 blur-[100px]"></div>
    </div>

    <!-- Side Navigation Shell -->
    <aside class="bg-surface-container-lowest dark:bg-surface-container-lowest h-screen w-64 flex flex-col fixed left-0 top-0 py-6 px-4 z-50">
        <div class="mb-10 px-2">
            <h1 class="font-display text-headline-sm font-bold text-on-surface tracking-tighter">TechSyllabus</h1>
            <p class="font-label text-[10px] tracking-widest uppercase text-outline mt-1">Academic Lab Admin</p>
        </div>

        <nav class="flex-1 space-y-1">
            <a class="flex items-center gap-3 px-3 py-2 rounded-lg transition-all duration-200 text-on-surface-variant font-medium hover:bg-surface-container hover:text-on-surface {{ request()->routeIs('laboratory*') ? 'text-primary font-bold border-r-2 border-primary bg-surface-container-low' : '' }}" href="#">
                <span class="material-symbols-outlined text-[20px]">biotech</span>
                <span class="font-label text-label-md tracking-widest uppercase">Laboratory</span>
            </a>

            <a class="flex items-center gap-3 px-3 py-2 rounded-lg transition-all duration-150 active:scale-95 {{ request()->routeIs('department.syllabus-templates*') ? 'text-primary font-bold border-r-2 border-primary bg-surface-container-low' : 'text-on-surface-variant' }} hover:bg-surface-container hover:text-on-surface" href="{{ route('department.syllabus-templates.index') }}">
                <span class="material-symbols-outlined text-[20px]">library_books</span>
                <span class="font-label text-label-md tracking-widest uppercase">Syllabus Library</span>
            </a>

            <a class="flex items-center gap-3 px-3 py-2 rounded-lg transition-all duration-200 text-on-surface-variant font-medium hover:bg-surface-container hover:text-on-surface {{ request()->routeIs('ai-mapping*') ? 'text-primary font-bold border-r-2 border-primary bg-surface-container-low' : '' }}" href="#">
                <span class="material-symbols-outlined text-[20px]">hub</span>
                <span class="font-label text-label-md tracking-widest uppercase">AI Mapping</span>
            </a>

            <a class="flex items-center gap-3 px-3 py-2 rounded-lg transition-all duration-200 text-on-surface-variant font-medium hover:bg-surface-container hover:text-on-surface {{ request()->routeIs('technical-specs*') ? 'text-primary font-bold border-r-2 border-primary bg-surface-container-low' : '' }}" href="#">
                <span class="material-symbols-outlined text-[20px]">settings_input_component</span>
                <span class="font-label text-label-md tracking-widest uppercase">Technical Specs</span>
            </a>
        </nav>

        <div class="mt-auto pt-6 border-t border-outline-variant/10 space-y-1">
            <button class="w-full flex items-center justify-center gap-2 py-3 mb-4 bg-primary-container text-on-primary-container rounded-lg font-bold text-sm shadow-extruded hover:brightness-110 transition-all">
                <span class="material-symbols-outlined">add</span>
                Create New Template
            </button>

            <a class="flex items-center gap-3 px-3 py-2 rounded-lg text-on-surface-variant font-medium hover:bg-surface-container transition-colors" href="#">
                <span class="material-symbols-outlined text-[20px]">description</span>
                <span class="font-label text-label-md tracking-widest uppercase">Docs</span>
            </a>

            <a class="flex items-center gap-3 px-3 py-2 rounded-lg text-on-surface-variant font-medium hover:bg-surface-container transition-colors" href="#">
                <span class="material-symbols-outlined text-[20px]">help_outline</span>
                <span class="font-label text-label-md tracking-widest uppercase">Support</span>
            </a>
        </div>
    </aside>

    <!-- Top Navigation Shell -->
    <header class="bg-surface/80 backdrop-blur-xl flex justify-between items-center ml-64 px-8 py-4 w-[calc(100%-16rem)] sticky top-0 z-40">
        <div class="flex items-center gap-4 flex-1">
            <div class="relative w-full max-w-md">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]">search</span>
                <input class="w-full bg-surface-container-lowest border-none rounded-lg pl-10 pr-4 py-2 font-label text-label-md focus:ring-1 focus:ring-outline-variant text-on-surface placeholder:text-outline/50 shadow-inset-soft" placeholder="Search syllabus parameters..." type="text">
            </div>
        </div>

        <div class="flex items-center gap-6">
            <div class="flex items-center gap-4 text-on-surface-variant">
                <button class="hover:text-primary transition-opacity relative">
                    <span class="material-symbols-outlined">notifications</span>
                    <span class="absolute top-0 right-0 w-2 h-2 bg-primary rounded-full border-2 border-surface"></span>
                </button>
                <button class="hover:text-primary transition-opacity">
                    <span class="material-symbols-outlined">settings</span>
                </button>
            </div>
            <div class="h-8 w-px bg-outline-variant/20 mx-2"></div>
            <div class="flex items-center gap-3">
                <div class="text-right">
                    <p class="text-sm font-bold text-on-surface leading-tight">Admin User</p>
                    <p class="text-[10px] font-label text-outline uppercase tracking-wider">System Architect</p>
                </div>
                <img alt="Administrator" class="w-10 h-10 rounded-full border border-outline-variant/30 object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA9nZequUGLZ7Jo61iANU5M7-jnRc61QGrMooJjcHDVyttvFY4_RxC1UMolRmKW-PTmeQ3E_qH0hVPsRqw2KmWsG4MWIEqIUXZxjKBOxcoVlgvM9VR2-vZw-OAFXRb1ruBGAtjWzEHUadl50ebERh3EFcFZGquBUXJtwvRGsqDpbs-ulrAPv83wA6pQxceHeqpSC-vlUDiSFBnDOXuCBaI_4LrfzFE4zMFThziHB9QUBK7j1LqO5iXMRaWLiMT89E4ssGcXCZBvD_uV">
            </div>
        </div>
    </header>

    <!-- Main Content Canvas -->
    <main class="ml-64 p-8 min-h-[calc(100vh-72px)] relative z-10" id="main-canvas">
        @yield('content')
    </main>

    @stack('scripts')

    <script>
        // Micro-interaction: Mouse Tracking Spotlight
        const canvas = document.getElementById('main-canvas');
        if (canvas) {
            canvas.addEventListener('mousemove', e => {
                const rect = canvas.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                canvas.style.setProperty('--x', `${x}px`);
                canvas.style.setProperty('--y', `${y}px`);
            });
        }
    </script>
</body>
</html>
