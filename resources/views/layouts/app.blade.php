<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SCM Dashboard') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Theme Initialization Script (Prevents FOUC) -->
    <script>
        if (localStorage.getItem('theme') === 'light') {
            document.documentElement.classList.remove('dark');
        } else if (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: light)').matches) {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Chart.js (Loaded globally for KPI Dashboards) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-200">
    <div class="flex h-screen overflow-hidden">
        
        <!-- Professional Collapsible Sidebar -->
        <aside id="sidebar" class="relative hidden md:flex flex-col w-64 bg-slate-900 border-r border-slate-800 flex-shrink-0 transition-all duration-300 ease-in-out z-20">
            
            <!-- Collapse / Expand Toggle Button -->
            <button onclick="toggleSidebar()" class="absolute -right-3.5 top-5 bg-indigo-600 hover:bg-indigo-500 text-white p-1 rounded-full shadow-md z-30 focus:outline-none transition-transform duration-300" id="sidebarToggleBtn" title="Toggle Sidebar">
                <svg id="toggleIcon" class="w-4 h-4 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
                </svg>
            </button>

            <!-- Brand Header -->
            <div class="flex items-center h-16 px-6 bg-slate-950 border-b border-slate-800 overflow-hidden whitespace-nowrap">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-indigo-600 rounded-lg text-white font-bold text-base shadow-md flex-shrink-0">SCM</div>
                    <span class="sidebar-text text-white font-semibold tracking-wide text-sm transition-opacity duration-300">Brilliant 4 Equity</span>
                </div>
            </div>

            <!-- Sidebar Navigation Links -->
            <div class="flex-1 flex flex-col overflow-y-auto overflow-x-hidden px-4 py-6 space-y-1.5 custom-scrollbar">
                <div class="sidebar-text text-xs font-semibold text-slate-500 uppercase tracking-wider px-3 mb-2 transition-opacity duration-300">Core Modules</div>

                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-colors group {{ request()->routeIs('dashboard*') ? 'bg-indigo-600 text-white shadow-md' : 'hover:bg-slate-800 text-slate-300 hover:text-white' }}" title="Dashboard">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0 {{ request()->routeIs('dashboard*') ? 'text-indigo-200' : 'text-slate-400 group-hover:text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    <span class="sidebar-text transition-opacity duration-300">Dashboard</span>
                </a>

                <!-- Procurement -->
                <a href="#" class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-colors hover:bg-slate-800 text-slate-300 hover:text-white group" title="Procurement">
                    <svg class="w-5 h-5 mr-3 text-slate-400 group-hover:text-indigo-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <span class="sidebar-text transition-opacity duration-300">Procurement</span>
                </a>

                <!-- Manpower -->
                <a href="#" class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-colors hover:bg-slate-800 text-slate-300 hover:text-white group" title="Manpower">
                    <svg class="w-5 h-5 mr-3 text-slate-400 group-hover:text-indigo-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span class="sidebar-text transition-opacity duration-300">Manpower</span>
                </a>

                <!-- Budgets -->
                <a href="#" class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-colors hover:bg-slate-800 text-slate-300 hover:text-white group" title="Budgets">
                    <svg class="w-5 h-5 mr-3 text-slate-400 group-hover:text-indigo-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="sidebar-text transition-opacity duration-300">Budgets</span>
                </a>
            </div>

            <!-- User Footer Profile Snippet -->
            <div class="p-4 bg-slate-950 border-t border-slate-800 overflow-hidden whitespace-nowrap">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center font-bold text-white text-sm flex-shrink-0">
                            {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                        </div>
                        <div class="sidebar-text overflow-hidden transition-opacity duration-300">
                            <p class="text-xs font-medium text-white truncate max-w-[120px]">{{ Auth::user()->name ?? 'Guest User' }}</p>
                            <p class="text-[10px] text-slate-400 truncate max-w-[120px]">{{ Auth::user()->email ?? 'System Role' }}</p>
                        </div>
                    </div>
                    
                    <form method="POST" action="{{ route('logout') }}" class="sidebar-text m-0 p-0 transition-opacity duration-300">
                        @csrf
                        <button type="submit" class="text-slate-400 hover:text-rose-400 p-1.5 rounded-lg hover:bg-slate-800 transition-colors" title="Log Out">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Content Wrapper -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            
            <!-- Top Header Navbar -->
            <header class="bg-white dark:bg-gray-950 border-b border-gray-200 dark:border-gray-800 h-16 flex items-center justify-between px-6 z-10 transition-colors duration-200">
                
                <div class="flex items-center space-x-4 flex-1">
                    <!-- Mobile Menu Toggle Button -->
                    <button class="md:hidden text-gray-500 hover:text-indigo-600 dark:text-gray-400 focus:outline-none transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    
                    <!-- Page Title (Injected via Slot) -->
                    @if (isset($header))
                        <div class="w-full">
                            {{ $header }}
                        </div>
                    @else
                        <h1 class="text-lg font-bold text-gray-800 dark:text-gray-100 tracking-tight">
                            Supply Chain Management Portal
                        </h1>
                    @endif
                </div>

                <!-- Right Header Actions -->
                <div class="flex items-center space-x-4 ml-4">
                    
                    <!-- Dark/Light Mode Toggle -->
                    <button onclick="toggleDarkMode()" class="text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 p-2 rounded-lg bg-gray-100 dark:bg-gray-800/50 hover:bg-gray-200 dark:hover:bg-gray-800 transition-colors" title="Toggle Theme">
                        <svg id="theme-icon-sun" class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <svg id="theme-icon-moon" class="w-5 h-5 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    </button>

                    <!-- System Status Badge -->
                    <span class="hidden sm:inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100/80 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/30">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5 animate-pulse"></span>
                        System Active
                    </span>
                </div>
            </header>

            <!-- Main Page Content Area ($slot) -->
            <main class="flex-1 overflow-y-auto bg-gray-50 dark:bg-gray-900 transition-colors duration-200">
                {{ $slot }}
            </main>
        </div>
    </div>

    <!-- Global Layout Scripts -->
    <script>
        // 1. Sidebar Expand/Collapse Logic
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const toggleIcon = document.getElementById('toggleIcon');
            const texts = sidebar.querySelectorAll('.sidebar-text');

            if (sidebar.classList.contains('w-64')) {
                sidebar.classList.remove('w-64');
                sidebar.classList.add('w-20');
                toggleIcon.classList.add('rotate-180');
                texts.forEach(el => {
                    el.style.opacity = '0';
                    el.style.pointerEvents = 'none';
                    setTimeout(() => el.classList.add('hidden'), 150);
                });
                localStorage.setItem('sidebarState', 'collapsed');
            } else {
                sidebar.classList.remove('w-20');
                sidebar.classList.add('w-64');
                toggleIcon.classList.remove('rotate-180');
                texts.forEach(el => {
                    el.classList.remove('hidden');
                    setTimeout(() => el.style.opacity = '1', 50);
                    el.style.pointerEvents = 'auto';
                });
                localStorage.setItem('sidebarState', 'expanded');
            }
        }

        // 2. Global Dark/Light Theme Logic
        function toggleDarkMode() {
            const html = document.documentElement;
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                localStorage.setItem('theme', 'light');
                if (typeof updateChartTheme === 'function') updateChartTheme(false); // Update charts if on dashboard
            } else {
                html.classList.add('dark');
                localStorage.setItem('theme', 'dark');
                if (typeof updateChartTheme === 'function') updateChartTheme(true); // Update charts if on dashboard
            }
        }

        // 3. Restore UI States on page load
        window.addEventListener('DOMContentLoaded', () => {
            // Restore Sidebar
            if (localStorage.getItem('sidebarState') === 'collapsed') {
                const sidebar = document.getElementById('sidebar');
                const toggleIcon = document.getElementById('toggleIcon');
                const texts = sidebar.querySelectorAll('.sidebar-text');
                
                if (sidebar) {
                    sidebar.classList.remove('w-64');
                    sidebar.classList.add('w-20');
                    if (toggleIcon) toggleIcon.classList.add('rotate-180');
                    texts.forEach(el => {
                        el.style.opacity = '0';
                        el.style.pointerEvents = 'none';
                        el.classList.add('hidden');
                    });
                }
            }
        });
    </script>
</body>
</html>