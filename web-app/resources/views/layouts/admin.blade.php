<!DOCTYPE html>
<html class="dark" lang="vi">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>@yield('title', 'Syllabus_System | Admin Dashboard')</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;family=Space+Grotesk:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "outline": "#908f9e",
                        "inverse-on-surface": "#313032",
                        "surface-container-lowest": "#0e0e0f",
                        "on-tertiary-fixed-variant": "#673d00",
                        "secondary-fixed-dim": "#c0c3f2",
                        "on-secondary-fixed": "#13183d",
                        "primary-fixed": "#dfe0ff",
                        "on-primary": "#121f8b",
                        "surface-tint": "#bdc2ff",
                        "secondary-container": "#42466e",
                        "on-surface": "#e5e1e3",
                        "surface-container-low": "#1c1b1d",
                        "error-container": "#93000a",
                        "surface-container": "#201f21",
                        "on-tertiary-container": "#fffaf8",
                        "surface": "#131315",
                        "on-background": "#e5e1e3",
                        "surface-container-highest": "#353436",
                        "on-error": "#690005",
                        "surface-bright": "#3a393a",
                        "secondary-fixed": "#dfe0ff",
                        "primary-fixed-dim": "#bdc2ff",
                        "tertiary": "#ffb867",
                        "outline-variant": "#454652",
                        "on-secondary": "#292d53",
                        "on-primary-fixed": "#000965",
                        "primary-container": "#5e6ad2",
                        "inverse-primary": "#4854bb",
                        "on-secondary-container": "#b1b5e3",
                        "on-surface-variant": "#c6c5d5",
                        "secondary": "#c0c3f2",
                        "primary": "#bdc2ff",
                        "on-error-container": "#ffdad6",
                        "inverse-surface": "#e5e1e3",
                        "tertiary-container": "#a56500",
                        "on-primary-fixed-variant": "#2e3aa2",
                        "tertiary-fixed": "#ffddbb",
                        "error": "#ffb4ab",
                        "surface-variant": "#353436",
                        "surface-dim": "#131315",
                        "on-primary-container": "#fdfaff",
                        "tertiary-fixed-dim": "#ffb867",
                        "on-secondary-fixed-variant": "#3f446b",
                        "surface-container-high": "#2a2a2b",
                        "on-tertiary": "#482900",
                        "background": "#131315",
                        "on-tertiary-fixed": "#2b1700"
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
                },
            },
        }
    </script>

    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .glass-panel {
            backdrop-filter: blur(12px);
            background: rgba(32, 31, 33, 0.7);
        }
        .shadow-extruded {
            box-shadow: 0 4px 0 0 rgba(0, 0, 0, 0.3);
        }
        .shadow-inset-soft {
            box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.2);
        }
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #131315;
        }
        ::-webkit-scrollbar-thumb {
            background: #353436;
            border-radius: 10px;
        }
    </style>

    @stack('styles')
</head>
<body class="bg-background text-on-surface font-body selection:bg-primary-container selection:text-on-primary-container">
    <!-- SideNavBar Shell -->
    <aside class="h-screen w-64 fixed left-0 top-0 flex flex-col p-4 gap-6 bg-surface-container-lowest z-50">
        <div class="flex items-center gap-3 px-2">
            <div class="w-8 h-8 rounded-lg bg-primary-container flex items-center justify-center">
                <span class="material-symbols-outlined text-on-primary-container" style="font-variation-settings: 'FILL' 1;">auto_stories</span>
            </div>
            <div>
                <h1 class="font-headline text-xl font-bold tracking-tighter text-on-surface">Syllabus_System</h1>
                <p class="text-[10px] font-label uppercase tracking-widest text-on-surface-variant/60">Technical Orchestration</p>
            </div>
        </div>

        <nav class="flex flex-col gap-1 mt-4">
            <a class="flex items-center gap-3 px-3 py-2.5 hover:bg-surface-container-low transition-colors duration-200 text-on-surface-variant opacity-70 {{ request()->routeIs('admin.dashboard') ? 'text-primary bg-surface-container rounded-lg opacity-100' : '' }}"
               href="{{ route('admin.dashboard') }}">
                <span class="material-symbols-outlined text-xl">dashboard</span>
                <span class="font-label text-sm tracking-tight">Dashboard</span>
            </a>
            <a class="flex items-center gap-3 px-3 py-2.5 hover:bg-surface-container-low transition-colors duration-200 text-on-surface-variant opacity-70 {{ request()->routeIs('admin.requests.*') ? 'text-primary bg-surface-container rounded-lg opacity-100' : '' }}"
               href="{{ route('admin.requests.index') }}">
                <span class="material-symbols-outlined text-xl" style="font-variation-settings: 'FILL' 1;">inventory_2</span>
                <span class="font-label text-sm tracking-tight">Account Requests</span>
            </a>
            <a class="flex items-center gap-3 px-3 py-2.5 hover:bg-surface-container-low transition-colors duration-200 text-on-surface-variant opacity-70" href="#">
                <span class="material-symbols-outlined text-xl">hub</span>
                <span class="font-label text-sm tracking-tight">Mapping</span>
            </a>
            <a class="flex items-center gap-3 px-3 py-2.5 hover:bg-surface-container-low transition-colors duration-200 text-on-surface-variant opacity-70" href="#">
                <span class="material-symbols-outlined text-xl">query_stats</span>
                <span class="font-label text-sm tracking-tight">Analytics</span>
            </a>
            <a class="flex items-center gap-3 px-3 py-2.5 hover:bg-surface-container-low transition-colors duration-200 text-on-surface-variant opacity-70" href="#">
                <span class="material-symbols-outlined text-xl">description</span>
                <span class="font-label text-sm tracking-tight">Protocols</span>
            </a>
        </nav>

        <div class="mt-auto flex flex-col gap-1 border-t border-outline-variant/10 pt-4">
            <a class="flex items-center gap-3 px-3 py-2 hover:bg-surface-container-low transition-colors rounded-lg text-on-surface-variant" href="#">
                <span class="material-symbols-outlined text-xl">settings</span>
                <span class="font-label text-sm tracking-tight">Settings</span>
            </a>
            <a class="flex items-center gap-3 px-3 py-2 hover:bg-surface-container-low transition-colors rounded-lg text-on-surface-variant" href="#">
                <span class="material-symbols-outlined text-xl">help_outline</span>
                <span class="font-label text-sm tracking-tight">Support</span>
            </a>
        </div>
    </aside>

    <!-- TopNavBar Shell -->
    <header class="fixed top-0 right-0 w-[calc(100%-16rem)] z-40 flex justify-between items-center h-16 px-8 ml-64 bg-surface/80 backdrop-blur-xl">
        <div class="flex items-center gap-6">
            <div class="relative group">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-on-surface-variant/50">
                    <span class="material-symbols-outlined text-sm">search</span>
                </span>
                <input class="bg-surface-container-lowest border-none shadow-inset-soft text-sm rounded-full py-1.5 pl-10 pr-4 w-64 focus:ring-1 focus:ring-primary/30 transition-all font-body" placeholder="Search parameters..." type="text"/>
            </div>
            <nav class="hidden md:flex gap-6">
                <a class="text-on-surface-variant hover:text-on-surface transition-opacity text-label-md tracking-widest uppercase text-[10px]" href="#">Dashboard</a>
                <a class="text-primary border-b-2 border-primary pb-1 text-label-md tracking-widest uppercase text-[10px]" href="#">Faculty</a>
                <a class="text-on-surface-variant hover:text-on-surface transition-opacity text-label-md tracking-widest uppercase text-[10px]" href="#">Archive</a>
            </nav>
        </div>
        <div class="flex items-center gap-4">
            <button class="w-10 h-10 flex items-center justify-center rounded-full text-on-surface-variant hover:bg-surface-container transition-colors focus:ring-1 ring-outline-variant/20">
                <span class="material-symbols-outlined">notifications</span>
            </button>
            <div class="flex items-center gap-3 pl-4 border-l border-outline-variant/20">
                <div class="text-right hidden lg:block">
                    <p class="text-xs font-bold text-on-surface">Dr. Aris Thorne</p>
                    <p class="text-[10px] text-on-surface-variant font-label uppercase">Dean of Faculty</p>
                </div>
                <img alt="Profile" class="w-8 h-8 rounded-full bg-primary-container/20 border border-primary/20" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCfTpm1sGG2v0PpBSAh0xgt_0okBZ_sQ04tN-OZWfe75lZeglud967XnhdnmPuD0pwUDznWS3V_b5IH1JiIFt4gG1Js4DdnyD0gterdFxbCB0IyTTFEzuoQZweahmUXwMOE0_NfrHllKvHWytR0lYOV7ISwaFzlJXIE4zxhEfDLN2vo6ATWX02bD2OajwNNGsQ6wvUq8v4D4C9_aCqgrXmhAkpJlKa-ZQzNujFIydu0NoV2x2Ie-jr6F1haxgpKR0JqMO0o_pkFoakO"/>
            </div>
        </div>
    </header>

    <!-- Main Content Canvas -->
    <main class="ml-64 pt-24 p-8 min-h-screen">
        <!-- Ambient Instrumentation Effects -->
        <div class="fixed top-1/4 right-1/4 w-100 h-100 bg-primary-container/5 blur-[120px] rounded-full pointer-events-none -z-10"></div>
        <div class="fixed bottom-0 left-1/4 w-75 h-75 bg-secondary-container/5 blur-[100px] rounded-full pointer-events-none -z-10"></div>

        <div class="max-w-7xl mx-auto">
            @yield('content')
        </div>
    </main>

    <script>
        // Spotlight effect
        document.addEventListener('mousemove', (e) => {
            const cards = document.querySelectorAll('.bg-surface-container-lowest');
            cards.forEach(card => {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                card.style.setProperty('--mouse-x', `${x}px`);
                card.style.setProperty('--mouse-y', `${y}px`);
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
