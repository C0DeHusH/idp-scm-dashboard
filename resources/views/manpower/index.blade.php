<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manpower Registry - SCM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class' }
    </script>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 font-sans antialiased transition-colors duration-200">
    <div class="flex h-screen overflow-hidden">
        
        <!-- Professional Sidebar -->
        <aside id="sidebar" class="relative hidden md:flex flex-col w-64 bg-slate-900 border-r border-slate-800 flex-shrink-0 transition-all duration-300 ease-in-out">
            <button onclick="toggleSidebar()" class="absolute -right-3.5 top-5 bg-indigo-600 hover:bg-indigo-500 text-white p-1 rounded-full shadow-md z-20 focus:outline-none transition-transform duration-300" id="sidebarToggleBtn" title="Toggle Sidebar">
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

            <!-- Navigation Links -->
            <div class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto overflow-x-hidden">
                <div class="sidebar-text px-3 mb-2 text-xs font-semibold tracking-wider text-slate-400 uppercase transition-opacity duration-300">Core Modules</div>
                
                <a href="{{ route('dashboard.unified') }}" class="flex items-center px-3 py-2.5 text-sm font-medium text-slate-300 rounded-lg hover:bg-slate-800 hover:text-white group transition-colors" title="Dashboard Overview">
                    <svg class="w-5 h-5 mr-3 text-slate-400 group-hover:text-indigo-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    <span class="sidebar-text transition-opacity duration-300">Dashboard Overview</span>
                </a>
                
                <a href="#" class="flex items-center px-3 py-2.5 text-sm font-medium text-slate-300 rounded-lg hover:bg-slate-800 hover:text-white group transition-colors" title="Procurement">
                    <svg class="w-5 h-5 mr-3 text-slate-400 group-hover:text-indigo-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    <span class="sidebar-text transition-opacity duration-300">Procurement</span>
                </a>
                
                <!-- Active Manpower Link -->
                <a href="{{ route('manpower.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-lg group shadow-sm transition-colors" title="Manpower">
                    <svg class="w-5 h-5 mr-3 text-indigo-200 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <span class="sidebar-text transition-opacity duration-300">Manpower</span>
                </a>

                <a href="{{ route('admin.import') }}" class="flex items-center px-3 py-2.5 text-sm font-medium text-slate-300 rounded-lg hover:bg-slate-800 hover:text-white group transition-colors" title="KPI">
                    <svg class="w-5 h-5 mr-3 text-slate-400 group-hover:text-indigo-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    <span class="sidebar-text transition-opacity duration-300">KPI Data Sync</span>
                </a>
            </div>

            <!-- Profile Summary -->
            <div class="p-4 bg-slate-950 border-t border-slate-800 overflow-hidden whitespace-nowrap">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center font-bold text-white text-sm flex-shrink-0">
                            {{ substr(Auth::user()->name ?? 'K', 0, 1) }}
                        </div>
                        <div class="sidebar-text overflow-hidden transition-opacity duration-300">
                            <p class="text-xs font-medium text-white truncate max-w-[120px]">{{ Auth::user()->name ?? 'Karl Winston Torres' }}</p>
                            <p class="text-[10px] text-slate-400 truncate max-w-[120px]">Inventory & Distribution Manager</p>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col h-screen overflow-y-auto">
            
            <header class="bg-white dark:bg-gray-950 border-b border-gray-200 dark:border-gray-800 h-16 flex items-center justify-between px-6 z-10 transition-colors duration-200">
                <div class="flex items-center space-x-4 flex-1">
                    <button class="md:hidden text-gray-500 hover:text-indigo-600 dark:text-gray-400 focus:outline-none transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <h1 class="text-lg font-bold text-gray-800 dark:text-gray-100 tracking-tight">
                        Manpower & Personnel Registry
                    </h1>
                </div>
                
                <div class="flex items-center space-x-4 ml-4">
                    <button onclick="toggleDarkMode()" class="text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 p-2 rounded-lg bg-gray-100 dark:bg-gray-800/50 hover:bg-gray-200 dark:hover:bg-gray-800 transition-colors" title="Toggle Theme">
                        <svg id="theme-icon-sun" class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <svg id="theme-icon-moon" class="w-5 h-5 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    </button>
                </div>
            </header>

            <div class="w-full mx-auto py-8 px-6 sm:px-8 lg:px-12">
                
                <!-- Toolbar -->
                <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
                    <div class="relative w-full sm:w-72">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-100 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 p-2.5 shadow-sm" placeholder="Search personnel...">
                    </div>
                    <button class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-2 px-5 rounded-lg shadow-sm transition-colors duration-150 inline-flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Add Personnel
                    </button>
                </div>

                <!-- Manpower Table -->
                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-xl rounded-2xl overflow-hidden transition-all">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap">
                            <thead class="bg-gray-50/50 dark:bg-gray-900/50 text-gray-500 dark:text-gray-300 uppercase text-xs font-bold border-b border-gray-200 dark:border-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-4">Name</th>
                                    <th scope="col" class="px-6 py-4">Section / Department</th>
                                    <th scope="col" class="px-6 py-4">Position</th>
                                    <th scope="col" class="px-6 py-4 text-center">Status</th>
                                    <th scope="col" class="px-6 py-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700/60">
                                
                                <!-- Hardcoded Example Row (To be replaced with DB Loop later) -->
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center text-indigo-700 dark:text-indigo-300 font-bold">
                                                SD
                                            </div>
                                            <div class="font-semibold text-gray-900 dark:text-gray-100">Sheena Diane Uy</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">Supply Chain Management</td>
                                    <td class="px-6 py-4">Inventory Staff</td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400 px-3 py-1 rounded-full text-xs font-bold">Active</span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <button class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium text-sm">Edit</button>
                                    </td>
                                </tr>

                                @if(isset($personnel) && $personnel->count() > 0)
                                    @foreach($personnel as $person)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-600 dark:text-gray-300 font-bold">
                                                    {{ substr($person->name, 0, 2) }}
                                                </div>
                                                <div class="font-semibold text-gray-900 dark:text-gray-100">{{ $person->name }}</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">{{ $person->section }}</td>
                                        <td class="px-6 py-4">{{ $person->position }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400 px-3 py-1 rounded-full text-xs font-bold">Active</span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <a href="#" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium text-sm">Edit</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- UI Scripts -->
    <script>
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
                });
                localStorage.setItem('sidebarState', 'expanded');
            }
        }

        function toggleDarkMode() {
            const html = document.documentElement;
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                html.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
        }

        window.addEventListener('DOMContentLoaded', () => {
            if (localStorage.getItem('sidebarState') === 'collapsed') {
                const sidebar = document.getElementById('sidebar');
                sidebar.classList.remove('w-64');
                sidebar.classList.add('w-20');
                document.getElementById('toggleIcon').classList.add('rotate-180');
                sidebar.querySelectorAll('.sidebar-text').forEach(el => el.classList.add('hidden'));
            }
            if (localStorage.getItem('theme') === 'light') {
                document.documentElement.classList.remove('dark');
            }
        });
    </script>
</body>
</html>