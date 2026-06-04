<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReserveIt Portal</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 font-sans text-slate-800 antialiased" x-data="{ sidebarOpen: true }">

    <div class="flex h-screen overflow-hidden">
        <aside class="bg-slate-900 text-slate-200 h-full flex flex-col justify-between transition-all duration-300 shadow-xl z-20" :class="sidebarOpen ? 'w-64' : 'w-20'">
            <div>
                <div class="h-16 flex items-center px-4 border-b border-slate-800 justify-between">
                    <div class="flex items-center gap-3 overflow-hidden" x-show="sidebarOpen">
                        <span class="p-2 bg-blue-600 rounded-lg text-white font-bold text-sm">📆</span>
                        <h1 class="font-bold text-sm text-white whitespace-nowrap">Library Management System</h1>
                    </div>
                    <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-lg bg-slate-800 hover:bg-slate-700">
                        <svg class="w-5 h-5 transition-transform" :class="{'rotate-180': !sidebarOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" /></svg>
                    </button>
                </div>

                <nav class="mt-6 px-3 space-y-1">
                    <a href="/dashboard" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all {{ request()->is('dashboard') ? 'bg-blue-600 text-white' : 'hover:bg-slate-800 text-slate-400' }}">
                        <span>📊</span>
                        <span x-show="sidebarOpen" class="text-sm font-medium">Dashboard</span>
                    </a>

                    @if(auth()->check() && auth()->user()->role === 'admin')
                        <a href="/admin/calendar" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all {{ request()->is('admin/calendar') ? 'bg-blue-600 text-white' : 'hover:bg-slate-800 text-slate-400' }}">
                            <span>📅</span>
                            <span x-show="sidebarOpen" class="text-sm font-medium">Weekly Calendar</span>
                        </a>
                    @endif

                    @if(auth()->check() && auth()->user()->role !== 'admin')
                        <a href="/appointments/book" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all {{ request()->is('appointments/book') ? 'bg-blue-600 text-white' : 'hover:bg-slate-800 text-slate-400' }}">
                            <span>💼</span>
                            <span x-show="sidebarOpen" class="text-sm font-medium">Borrow Book</span>
                        </a>
                    @endif
                </nav>
            </div>

            <div class="p-4 border-t border-slate-800 bg-slate-950/40">
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-4 p-2 text-slate-400 hover:text-rose-400 rounded-lg hover:bg-slate-800">
                        <span>🚪</span>
                        <span x-show="sidebarOpen" class="text-sm">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <header class="h-16 bg-white border-b border-slate-200 flex items-center px-6 shadow-sm">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">
                    {{ auth()->user()->role ?? 'Guest' }} Portal
                </span>
            </header>

            <main class="flex-1 overflow-y-auto p-6 bg-slate-50">
                @if(session('success'))
                    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm font-medium">
                        {{ session('success') }}
                    </div>
                @endif
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>