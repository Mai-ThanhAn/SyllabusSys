<!DOCTYPE html>

<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Syllabus_System | AI-Powered Academic Orchestration</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&amp;family=Space+Grotesk:wght@400;500;700&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "surface": "#131315",
                        "secondary-fixed": "#dfe0ff",
                        "inverse-primary": "#4854bb",
                        "on-primary": "#121f8b",
                        "on-tertiary-fixed": "#2b1700",
                        "surface-container-low": "#1c1b1d",
                        "on-error": "#690005",
                        "secondary": "#c0c3f2",
                        "on-background": "#e5e1e3",
                        "error": "#ffb4ab",
                        "tertiary": "#ffb867",
                        "primary-container": "#5e6ad2",
                        "surface-tint": "#bdc2ff",
                        "outline-variant": "#454652",
                        "outline": "#908f9e",
                        "on-error-container": "#ffdad6",
                        "inverse-on-surface": "#313032",
                        "tertiary-container": "#a56500",
                        "primary-fixed": "#dfe0ff",
                        "surface-dim": "#131315",
                        "on-secondary-fixed-variant": "#3f446b",
                        "surface-container-highest": "#353436",
                        "on-tertiary": "#482900",
                        "surface-container": "#201f21",
                        "primary-fixed-dim": "#bdc2ff",
                        "secondary-fixed-dim": "#c0c3f2",
                        "secondary-container": "#42466e",
                        "on-secondary": "#292d53",
                        "on-primary-fixed-variant": "#2e3aa2",
                        "on-primary-container": "#fdfaff",
                        "on-secondary-container": "#b1b5e3",
                        "on-primary-fixed": "#000965",
                        "error-container": "#93000a",
                        "surface-container-high": "#2a2a2b",
                        "tertiary-fixed-dim": "#ffb867",
                        "on-secondary-fixed": "#13183d",
                        "on-tertiary-fixed-variant": "#673d00",
                        "on-tertiary-container": "#fffaf8",
                        "inverse-surface": "#e5e1e3",
                        "primary": "#bdc2ff",
                        "on-surface": "#e5e1e3",
                        "surface-variant": "#353436",
                        "on-surface-variant": "#c6c5d5",
                        "background": "#131315",
                        "surface-container-lowest": "#0e0e0f",
                        "surface-bright": "#3a393a",
                        "tertiary-fixed": "#ffddbb"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "fontFamily": {
                        "headline": ["Inter"],
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

        .bg-grid-subtle {
            background-size: 64px 64px;
            background-image: linear-gradient(to right, rgba(69, 70, 82, 0.1) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(69, 70, 82, 0.1) 1px, transparent 1px);
        }

        .shadow-extruded {
            box-shadow: 0 4px 0 0 #5E6AD2, 0 8px 16px rgba(94, 106, 210, 0.2);
        }

        .shadow-inset-soft {
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .text-gradient-hero {
            background: linear-gradient(to bottom, #e5e1e3 0%, rgba(229, 225, 227, 0.2) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .bento-card-hover:hover {
            transform: translateY(-4px);
            border-color: rgba(189, 194, 255, 0.3);
        }
    </style>
</head>

<body class="bg-surface text-on-surface font-body selection:bg-primary-container/30">
    <!-- Global Navigation -->
    <nav class="fixed top-0 w-full z-50 bg-[#131315]/80 backdrop-blur-xl border-b border-[#454652]/20">
        <div class="flex justify-between items-center max-w-[1400px] mx-auto px-8 h-16">
            <div class="text-xl font-bold tracking-tighter text-[#e5e1e3] uppercase font-['Space_Grotesk']">
                SYLLABUS_SYSTEM
            </div>
            <div class="hidden md:flex items-center gap-8 font-['Inter'] tracking-tight text-sm font-medium">
                <a class="text-[#bdc2ff] font-semibold border-b-2 border-[#5E6AD2] pb-1" href="#">Trang Chủ</a>
                <a class="text-[#9a9a9a] hover:text-[#e5e1e3] transition-colors" href="#">Tính Năng</a>
                <a class="text-[#9a9a9a] hover:text-[#e5e1e3] transition-colors" href="#">Về Chúng Tôi</a>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('login') }}"
                    class="bg-primary-container text-on-primary-container
          px-4 py-2 rounded-lg text-sm font-semibold
          shadow-extruded hover:scale-95 active:scale-90
          transition-all inline-flex items-center gap-2">

                    <span class="material-symbols-outlined">
                        login
                    </span>

                    <span>Đăng Nhập</span>
                </a>
            </div>
        </div>
    </nav>
    <main class="relative min-h-screen pt-16 overflow-hidden bg-grid-subtle">
        <!-- Background Ambient Elements -->
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-primary-container/10 blur-[120px] rounded-full">
        </div>
        <div
            class="absolute bottom-[20%] right-[-5%] w-[30%] h-[50%] bg-secondary-container/10 blur-[100px] rounded-full">
        </div>
        <!-- Hero Section -->
        <section class="relative max-w-7xl mx-auto px-8 pt-24 pb-32 text-center">
            <div
                class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-surface-container border border-outline-variant/20 mb-8">
                <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                <span class="font-label text-[10px] uppercase tracking-widest text-on-surface-variant">System V0.5 Now
                    Live</span>
            </div>
            <h1 class="text-6xl md:text-8xl font-bold tracking-tighter text-gradient-hero mb-6 leading-[0.9]">
                Smart Academic Syllabus<br />System.
            </h1>
            <p class="max-w-2xl mx-auto text-lg text-on-surface-variant mb-12 font-medium tracking-tight">
                Một nền tảng công nghệ hỗ trợ bởi trí tuệ nhân tạo dành cho việc lập bản đồ khóa học, điều chỉnh chương
                trình giảng dạy và quản lý dữ liệu giáo trình với độ chính xác cao.
            </p>
            <div class="flex flex-col md:flex-row items-center justify-center gap-6">
                <button
                    class="bg-primary text-on-primary-fixed px-8 py-4 rounded-xl font-bold text-lg shadow-extruded transition-transform active:scale-95">
                    Get Started
                </button>
                <button
                    class="px-8 py-4 rounded-xl border border-outline-variant/30 font-bold text-lg hover:bg-surface-container transition-all">
                    View Demo
                </button>
            </div>
        </section>
        <!-- Bento Grid Feature Section -->
        <section class="max-w-7xl mx-auto px-8 pb-32">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                <!-- Large Card: AI Mapping Matrix -->
                <div
                    class="md:col-span-8 group relative rounded-xl bg-surface-container border border-outline-variant/10 p-8 bento-card-hover transition-all duration-500 overflow-hidden">
                    <div
                        class="absolute top-0 right-0 w-64 h-64 bg-primary/5 blur-[60px] group-hover:bg-primary/10 transition-colors">
                    </div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-6">
                            <span class="material-symbols-outlined text-primary"
                                style="font-variation-settings: 'FILL' 1;">hub</span>
                            <span class="font-label text-xs uppercase tracking-[0.2em] text-primary">Core
                                Intelligence</span>
                        </div>
                        <h3 class="text-3xl font-bold text-on-surface mb-4 tracking-tight">AI Mapping Matrix</h3>
                        <p class="text-on-surface-variant max-w-md mb-8 leading-relaxed">
                            Automatically align course learning outcomes with global accreditation standards using our
                            proprietary vector-mapping engine.
                        </p>
                        <div
                            class="bg-surface-container-lowest rounded-lg p-6 shadow-inset-soft border border-outline-variant/5">
                            <div class="flex items-center justify-between mb-4">
                                <span class="font-label text-[10px] text-outline">PROCESSING VECTOR_091</span>
                                <span class="text-xs text-primary font-mono">89.4% Match</span>
                            </div>
                            <div class="space-y-3">
                                <div class="h-1.5 w-full bg-surface-container rounded-full overflow-hidden">
                                    <div class="h-full bg-primary w-[89.4%]"></div>
                                </div>
                                <div class="h-1.5 w-full bg-surface-container rounded-full overflow-hidden">
                                    <div class="h-full bg-secondary-container w-[65.2%]"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Medium Card: Laravel Integration -->
                <div
                    class="md:col-span-4 group rounded-xl bg-surface-container border border-outline-variant/10 p-8 bento-card-hover transition-all duration-500">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="material-symbols-outlined text-secondary"
                            style="font-variation-settings: 'FILL' 1;">terminal</span>
                    </div>
                    <h3 class="text-xl font-bold text-on-surface mb-2 tracking-tight">Laravel Integration</h3>
                    <p class="text-sm text-on-surface-variant mb-8">
                        Native Blade components and Eloquent drivers for seamless orchestration.
                    </p>
                    <div
                        class="font-label text-[10px] bg-surface-container-lowest p-4 rounded-lg border-l-2 border-primary text-outline leading-tight">
                        &lt;x-syllabus-lab::matrix <br />
                        :course="$course_id" <br />
                        type="orchestration" /&gt;
                    </div>
                </div>
                <!-- Small Card: Neumorphism UI -->
                <div
                    class="md:col-span-4 group rounded-xl bg-surface-container border border-outline-variant/10 p-8 bento-card-hover transition-all duration-500">
                    <span class="material-symbols-outlined text-primary mb-6">layers</span>
                    <h3 class="text-lg font-bold text-on-surface mb-2">UI Utilities</h3>
                    <p class="text-xs text-on-surface-variant leading-relaxed">
                        Pre-baked shadow-extruded and inset-soft utility classes for academic depth.
                    </p>
                </div>
                <!-- Extra Feature: Performance Specs -->
                <div
                    class="md:col-span-8 group rounded-xl bg-surface-container-low border border-outline-variant/10 p-8 flex flex-col md:flex-row items-center gap-8 bento-card-hover transition-all">
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-on-surface mb-4">Laboratory Performance</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <div class="font-label text-[10px] text-outline mb-1 uppercase">Latency</div>
                                <div class="text-2xl font-bold text-on-surface">14ms</div>
                            </div>
                            <div>
                                <div class="font-label text-[10px] text-outline mb-1 uppercase">Concurrency</div>
                                <div class="text-2xl font-bold text-on-surface">1.2k/s</div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:w-1/2">
                        <img class="rounded-lg border border-outline-variant/20 shadow-2xl opacity-60"
                            data-alt="abstract 3d glass sphere with glowing purple core and technical grid data overlays in a dark void"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuA8n0x6RTPBZgPA0BBjN_2wg662aTJnCKD1eUu7lJY1knsBCpsdQYaI12TUnG74twp3UjwMlR9k6RDKkyQAWXyhhvl82cpu3Nq3M0BCJia7l6tOsppssZiqC5-WpQFTkDp6tUf0U29AuSAORsqbwOxmEHydKGcd2s84c8JvHVWJk0osDv8S5cPeK4Sr0k3pP5tI_GtTBHcJXmPiU6T9K8oYQ-YGmpHjJO2ZBNemQrENVYbYzSwIHda4enW9qtshckB56q50kF49xIIb" />
                    </div>
                </div>
            </div>
        </section>
        <!-- Social Proof / Logos -->
        <!-- Technical Specs Section -->
        <section class="max-w-4xl mx-auto px-8 pb-32">
            <div class="bg-surface-container-lowest rounded-2xl p-1 shadow-inset-soft">
                <div class="bg-surface-container rounded-2xl p-12 border border-outline-variant/10">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-8">
                        <div>
                            <h2 class="text-2xl font-bold text-on-surface mb-2 tracking-tight">System Specification</h2>
                            <p class="text-on-surface-variant text-sm">Orchestration engine build v2.4.0-stable</p>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <span
                                class="font-label text-[10px] py-1 px-3 bg-surface-container-high rounded-full border border-outline-variant/20">AES-256</span>
                            <span
                                class="font-label text-[10px] py-1 px-3 bg-surface-container-high rounded-full border border-outline-variant/20">LARAVEL_READY</span>
                            <span
                                class="font-label text-[10px] py-1 px-3 bg-surface-container-high rounded-full border border-outline-variant/20">VEC_CORE</span>
                            <span
                                class="font-label text-[10px] py-1 px-3 bg-primary/20 text-primary rounded-full border border-primary/30">ALPHA_STREAM</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- Footer -->
    <footer class="bg-[#0e0e0f] w-full py-12 px-8 border-t border-[#454652]/10">
        <div class="max-w-[1400px] mx-auto flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="text-[#e5e1e3] font-bold font-['Space_Grotesk'] tracking-tighter text-xl">
                SYLLABUS_SYSTEM
            </div>
            <div
                class="flex flex-wrap justify-center gap-8 font-['Space_Grotesk'] text-[10px] uppercase tracking-widest">
                <a class="text-[#454652] hover:text-[#5E6AD2] transition-colors" href="#">Privacy</a>
                <a class="text-[#454652] hover:text-[#5E6AD2] transition-colors" href="#">Terms</a>
                <a class="text-[#454652] hover:text-[#5E6AD2] transition-colors" href="#">API Status</a>
                <a class="text-[#454652] hover:text-[#5E6AD2] transition-colors" href="#">GitHub</a>
                <a class="text-[#454652] hover:text-[#5E6AD2] transition-colors" href="#">Support</a>
            </div>
            <div
                class="text-[#454652] font-['Space_Grotesk'] text-[10px] uppercase tracking-widest text-center md:text-right">
                © 2026 Syllabus System. All rights reserved - Anthony.
            </div>
        </div>
    </footer>
</body>

</html>
