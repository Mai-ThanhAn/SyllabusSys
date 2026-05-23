@extends('layouts.university_admin')

@section('title', 'Quản lý tài khoản và phân quyền | Syllabus Lab')

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <span class="w-2 h-2 bg-primary rounded-full animate-pulse"></span>
                    <span class="text-label-md font-label uppercase tracking-widest text-primary-fixed-dim">User
                        Management</span>
                </div>
                <h1 class="text-4xl font-display font-bold tracking-tighter text-on-surface">Quản lý tài khoản và phân quyền
                </h1>
                <p class="text-on-surface-variant/70 mt-2 font-body max-w-2xl">
                    Quản lý người dùng hệ thống và phân quyền truy cập cho các vai trò khác nhau trong Syllabus Lab.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <div
                    class="px-4 py-2 bg-surface-container rounded-lg border border-outline-variant/10 flex items-center gap-3">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="font-label text-xs uppercase tracking-widest">Active Users: {{ $users->count() }}</span>
                </div>
            </div>
        </div>
        <div class="mt-8">
            <a href="{{ route('university-admin.dashboard') }}"
                class="inline-flex items-center gap-2 text-on-surface-variant hover:text-primary transition-colors group">
                <span
                    class="material-symbols-outlined text-sm group-hover:-translate-x-1 transition-transform">arrow_back</span>
                <span class="font-label text-xs uppercase tracking-widest">Quay lại dashboard</span>
            </a>
        </div>
        <br>
        <!-- Session Feedback Messages -->
        @if (session('success'))
            <div
                class="mb-6 p-4 bg-primary-container/10 border-l-4 border-primary rounded-r-xl flex items-center gap-4 animate-in fade-in slide-in-from-top-4 duration-500">
                <span class="material-symbols-outlined text-primary"
                    style="font-variation-settings: 'FILL' 1;">check_circle</span>
                <p class="text-on-primary-container text-sm font-medium">{{ session('success') }}</p>
                <button class="ml-auto text-on-surface-variant hover:text-on-surface transition-colors"
                    onclick="this.closest('.mb-6').remove()">
                    <span class="material-symbols-outlined text-sm">close</span>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div
                class="mb-6 p-4 bg-error-container/10 border-l-4 border-error rounded-r-xl flex items-center gap-4 animate-in fade-in slide-in-from-top-4 duration-500">
                <span class="material-symbols-outlined text-error" style="font-variation-settings: 'FILL' 1;">error</span>
                <p class="text-on-error-container text-sm font-medium">{{ session('error') }}</p>
                <button class="ml-auto text-on-surface-variant hover:text-on-surface transition-colors"
                    onclick="this.closest('.mb-6').remove()">
                    <span class="material-symbols-outlined text-sm">close</span>
                </button>
            </div>
        @endif

        <!-- Data Table Container -->
        <div class="bg-surface-container-lowest rounded-xl border border-outline-variant/10 overflow-hidden shadow-2xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-surface-container/50 border-b border-outline-variant/10">
                            <th
                                class="px-6 py-4 font-label text-[10px] uppercase tracking-[0.2em] text-on-surface-variant/60">
                                ID</th>
                            <th
                                class="px-6 py-4 font-label text-[10px] uppercase tracking-[0.2em] text-on-surface-variant/60">
                                Họ tên</th>
                            <th
                                class="px-6 py-4 font-label text-[10px] uppercase tracking-[0.2em] text-on-surface-variant/60">
                                Email</th>
                            <th
                                class="px-6 py-4 font-label text-[10px] uppercase tracking-[0.2em] text-on-surface-variant/60">
                                Role hiện tại</th>
                            <th
                                class="px-6 py-4 font-label text-[10px] uppercase tracking-[0.2em] text-on-surface-variant/60">
                                Thay đổi phân quyền</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/10">
                        @foreach ($users as $user)
                            <tr class="group hover:bg-surface-container/30 transition-colors">
                                <td class="px-6 py-5 font-label text-xs text-on-surface-variant">#{{ $user->id }}</td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-full bg-outline-variant/20 flex items-center justify-center text-[10px] font-bold text-primary group-hover:bg-primary group-hover:text-on-primary transition-all duration-300">
                                            {{ substr($user->full_name, 0, 1) }}
                                        </div>
                                        <span class="text-sm font-semibold text-on-surface">{{ $user->full_name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-sm text-on-surface-variant">{{ $user->email }}</td>
                                <td class="px-6 py-5">
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach ($user->roles as $role)
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 rounded-full bg-secondary-container/40 text-on-secondary-container text-[10px] font-label uppercase tracking-wider">
                                                {{ $role->role_name }}
                                            </span>
                                        @endforeach
                                        @if ($user->roles->count() == 0)
                                            <span class="text-xs text-on-surface-variant/50 italic">Chưa có role</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <form method="POST"
                                        action="{{ route('university-admin.users.assignRole', $user->id) }}"
                                        class="flex items-center gap-3">
                                        @csrf
                                        <div class="relative flex-1 min-w-[160px]">
                                            <select name="role_id"
                                                class="w-full bg-surface-container-lowest border-none shadow-inset-soft rounded-lg px-3 py-2 text-sm text-on-surface focus:ring-1 focus:ring-primary/50 transition-all appearance-none cursor-pointer">
                                                <option value="">-- Chọn role --</option>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}">
                                                        {{ $role->role_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span
                                                class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline text-sm pointer-events-none">
                                                expand_more
                                            </span>
                                        </div>
                                        <button type="submit"
                                            class="px-4 py-2 bg-primary-container text-on-primary-container rounded-lg font-label text-[11px] font-bold uppercase tracking-widest shadow-extruded hover:-translate-y-0.5 transition-all">
                                            Thay đổi
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Technical Footer Metadata -->
            <div
                class="px-6 py-3 bg-surface-container/30 border-t border-outline-variant/10 flex justify-between items-center">
                <div class="flex gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-primary/40"></span>
                    <span class="w-1.5 h-1.5 rounded-full bg-primary/40"></span>
                    <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
                </div>
            </div>
        </div>

        <!-- Quick Actions & Stats -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-8">
            <div class="lg:col-span-2 bg-surface-container-low rounded-xl p-6 border border-outline-variant/5">
                <div class="flex items-center gap-3 mb-4">
                    <span class="material-symbols-outlined text-primary">admin_panel_settings</span>
                    <h4 class="font-label text-[10px] uppercase tracking-widest text-primary">Role Distribution</h4>
                </div>
                <div class="space-y-3">
                    @foreach ($roles as $role)
                        <div>
                            <div class="flex justify-between text-xs text-on-surface-variant mb-1">
                                <span class="font-label uppercase tracking-wider">{{ $role->role_name }}</span>
                                <span>{{ $role->users->count() }} users</span>
                            </div>
                            <div class="w-full bg-surface-variant/30 rounded-full h-1.5 overflow-hidden">
                                <div class="bg-primary h-full rounded-full"
                                    style="width: {{ $users->count() > 0 ? ($role->users->count() / $users->count()) * 100 : 0 }}%">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div
                class="bg-primary-container/10 rounded-xl p-6 border border-primary/20 flex flex-col justify-center text-center">
                <div
                    class="w-12 h-12 rounded-xl bg-primary-container/20 flex items-center justify-center text-primary mx-auto mb-3">
                    <span class="material-symbols-outlined text-3xl">groups</span>
                </div>
                <p class="text-3xl font-bold text-on-surface">{{ $users->count() }}</p>
                <p class="text-xs text-on-surface-variant mt-1">Total System Users</p>
            </div>
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #0e0e0f;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #353436;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #5e6ad2;
        }

        .shadow-extruded {
            box-shadow: 0 2px 0 0 rgba(94, 106, 210, 0.4);
        }
    </style>

    <script>
        // Auto-close alerts after 5 seconds
        setTimeout(() => {
            document.querySelectorAll('.bg-primary-container\\/10, .bg-error-container\\/10').forEach(alert => {
                if (alert) {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-10px)';
                    setTimeout(() => alert.remove(), 300);
                }
            });
        }, 5000);
    </script>
@endsection
