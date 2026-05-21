<!DOCTYPE html>
<html class="dark" lang="vi">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>@yield('title', 'Syllabus Lab')</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&amp;family=Space+Grotesk:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "background": "#131315",
                        "surface": "#131315",
                        "surface-container": "#201f21",
                        "surface-container-low": "#1c1b1d",
                        "surface-container-lowest": "#0e0e0f",
                        "surface-container-high": "#2a2a2b",
                        "surface-container-highest": "#353436",
                        "surface-bright": "#3a393a",
                        "surface-dim": "#131315",
                        "surface-variant": "#353436",
                        "on-surface": "#e5e1e3",
                        "on-surface-variant": "#c6c5d5",
                        "primary": "#bdc2ff",
                        "primary-container": "#5e6ad2",
                        "on-primary": "#121f8b",
                        "on-primary-container": "#fdfaff",
                        "primary-fixed": "#dfe0ff",
                        "primary-fixed-dim": "#bdc2ff",
                        "secondary": "#c0c3f2",
                        "secondary-container": "#42466e",
                        "on-secondary": "#292d53",
                        "on-secondary-container": "#b1b5e3",
                        "tertiary": "#ffb867",
                        "tertiary-container": "#a56500",
                        "error": "#ffb4ab",
                        "error-container": "#93000a",
                        "outline": "#908f9e",
                        "outline-variant": "#454652"
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
        .shadow-extruded {
            box-shadow: 0 4px 0 0 rgba(94, 106, 210, 0.4);
        }
        .shadow-inset-soft {
            box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.3);
        }
        .shadow-inset-deep {
            box-shadow: inset 0 4px 8px 0 rgba(0, 0, 0, 0.5);
        }
        .glass-panel {
            backdrop-filter: blur(12px);
            background: rgba(32, 31, 33, 0.7);
        }
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #0e0e0f;
        }
        ::-webkit-scrollbar-thumb {
            background: #353436;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #5e6ad2;
        }
    </style>

    @stack('styles')
</head>
<body class="bg-background text-on-surface font-body selection:bg-primary selection:text-on-primary overflow-x-hidden">
    <!-- Ambient Background -->
    <div class="fixed top-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-primary-container/10 blur-[120px] pointer-events-none z-0"></div>
    <div class="fixed bottom-[-10%] right-[-10%] w-[30%] h-[30%] rounded-full bg-secondary-container/10 blur-[100px] pointer-events-none z-0"></div>

    <!-- Sidebar -->
    <aside class="fixed left-0 top-0 h-screen w-64 bg-surface-container-lowest flex flex-col py-8 gap-2 z-50">
        <div class="px-6 mb-8">
            <h1 class="font-label font-black text-primary tracking-tighter text-2xl">SYLLABUS LAB</h1>
            <p class="font-label text-label-md uppercase tracking-wider text-on-surface-variant opacity-60">V2.4 ORCHESTRATOR</p>
        </div>

        <nav class="flex-1 flex flex-col gap-2">
            <a class="flex items-center gap-3 {{ request()->routeIs('program-director.syllabus-shells.*') ? 'bg-primary-container/10 text-primary border-l-2 border-primary' : 'text-on-surface-variant' }} px-4 py-3 font-label text-label-md uppercase tracking-wider hover:bg-surface-container-low transition-colors group" href="{{ route('program_director.syllabus_shells.create') }}">
                <span class="material-symbols-outlined text-xl">science</span>
                <span>Laboratory</span>
            </a>
            <a class="flex items-center gap-3 text-on-surface-variant px-4 py-3 font-label text-label-md uppercase tracking-wider hover:bg-surface-container-low hover:text-on-surface transition-colors" href="#">
                <span class="material-symbols-outlined text-xl">library_books</span>
                <span>Syllabus Library</span>
            </a>
        </nav>

        <div class="mt-auto px-4 flex flex-col gap-2">
            <a class="flex items-center gap-3 text-on-surface-variant px-4 py-2 font-label text-label-sm uppercase tracking-wider hover:text-on-surface transition-colors" href="#">
                <span class="material-symbols-outlined text-lg">help</span>
                <span>Support</span>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="ml-64 min-h-screen relative overflow-y-auto">
        <!-- TopAppBar -->
        <header class="fixed top-0 right-0 w-[calc(100%-16rem)] z-50 bg-surface/80 backdrop-blur-xl flex justify-between items-center px-8 h-16">
            <div class="flex items-center gap-4">
                <div class="relative flex items-center">
                    <span class="material-symbols-outlined absolute left-3 text-outline text-lg">search</span>
                    <input class="bg-surface-container-lowest border-none shadow-inset-soft text-on-surface text-[10px] font-label uppercase tracking-widest pl-10 pr-4 py-2 rounded-full w-64 focus:ring-1 focus:ring-primary" placeholder="QUERY DATABASE..." type="text"/>
                </div>
            </div>
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-4">
                    <button class="text-on-surface-variant hover:text-primary transition-all active:opacity-80">
                        <span class="material-symbols-outlined">notifications</span>
                    </button>
                    <button class="text-on-surface-variant hover:text-primary transition-all active:opacity-80">
                        <span class="material-symbols-outlined">terminal</span>
                    </button>
                </div>
                <div class="h-8 w-px bg-outline-variant/20"></div>
                <div class="flex items-center gap-3 group cursor-pointer">
                    <div class="text-right">
                        <div class="text-[10px] font-label uppercase tracking-widest text-on-surface">PROGRAM DIRECTOR</div>
                        <div class="text-[8px] font-label text-primary opacity-70 uppercase tracking-widest">System Admin</div>
                    </div>
                    <span class="material-symbols-outlined text-3xl text-on-surface-variant group-hover:text-primary transition-colors">account_circle</span>
                </div>
            </div>
        </header>

        <!-- Canvas -->
        <div class="pt-24 pb-12 px-12">
            @yield('content')
        </div>
    </main>

    @stack('scripts')
</body>
</html>
