<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Synchronization Hub - SCM</title>
    <!-- Enhanced Success & Error Toast Notifications Pop-Up -->
    @if (session('success'))
        <div id="toast-success" class="fixed bottom-8 right-8 flex items-center w-full max-w-sm p-4 space-x-4 text-gray-700 bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.12)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.5)] dark:text-gray-200 dark:bg-gray-800 border-l-4 border-emerald-500 transform transition-all duration-500 translate-y-0 opacity-100 z-50 overflow-hidden" role="alert">
            <div class="absolute -right-4 -top-4 w-16 h-16 bg-emerald-500/10 dark:bg-emerald-500/20 rounded-full blur-xl"></div>
            
            <div class="inline-flex items-center justify-center flex-shrink-0 w-12 h-12 text-emerald-500 bg-emerald-100/50 rounded-xl dark:bg-emerald-900/40 dark:text-emerald-400 relative z-10">
                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            
            <div class="ml-3 flex-grow relative z-10">
                <p class="text-sm font-bold text-gray-900 dark:text-white">Sync Complete</p>
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mt-0.5">{{ session('success') }}</p>
            </div>
            
            <button type="button" class="relative z-10 ml-auto -mx-1.5 -my-1.5 bg-transparent text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-2 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:hover:text-white dark:hover:bg-gray-700 transition-colors" onclick="document.getElementById('toast-success').style.display='none'" aria-label="Close">
                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
        <script>
            setTimeout(function() {
                const toast = document.getElementById('toast-success');
                if (toast) {
                    toast.classList.remove('translate-y-0', 'opacity-100');
                    toast.classList.add('translate-y-10', 'opacity-0');
                    setTimeout(() => toast.remove(), 500); 
                }
            }, 5000); 
        </script>
    @endif

    <!-- NEW ERROR TOAST -->
    @if (session('error'))
        <div id="toast-error" class="fixed bottom-8 right-8 flex items-center w-full max-w-sm p-4 space-x-4 text-gray-700 bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.12)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.5)] dark:text-gray-200 dark:bg-gray-800 border-l-4 border-red-500 transform transition-all duration-500 translate-y-0 opacity-100 z-50 overflow-hidden" role="alert">
            <div class="absolute -right-4 -top-4 w-16 h-16 bg-red-500/10 dark:bg-red-500/20 rounded-full blur-xl"></div>
            
            <div class="inline-flex items-center justify-center flex-shrink-0 w-12 h-12 text-red-500 bg-red-100/50 rounded-xl dark:bg-red-900/40 dark:text-red-400 relative z-10">
                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            
            <div class="ml-3 flex-grow relative z-10">
                <p class="text-sm font-bold text-gray-900 dark:text-white">Import Failed</p>
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mt-0.5">{{ session('error') }}</p>
            </div>
            
            <button type="button" class="relative z-10 ml-auto -mx-1.5 -my-1.5 bg-transparent text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-2 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:hover:text-white dark:hover:bg-gray-700 transition-colors" onclick="document.getElementById('toast-error').style.display='none'" aria-label="Close">
                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
        <script>
            setTimeout(function() {
                const toastError = document.getElementById('toast-error');
                if (toastError) {
                    toastError.classList.remove('translate-y-0', 'opacity-100');
                    toastError.classList.add('translate-y-10', 'opacity-0');
                    setTimeout(() => toastError.remove(), 500); 
                }
            }, 8000); 
        </script>
    @endif
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 font-sans antialiased transition-colors duration-200">
    <div class="flex h-screen overflow-hidden">
        
        <!-- Professional Sidebar with Expand/Collapse Support -->
        <aside id="sidebar" class="relative hidden md:flex flex-col w-64 bg-slate-900 border-r border-slate-800 flex-shrink-0 transition-all duration-300 ease-in-out">
            
            <!-- Collapse / Expand Toggle Button -->
            <button onclick="toggleSidebar()" class="absolute -right-3.5 top-5 bg-indigo-600 hover:bg-indigo-500 text-white p-1 rounded-full shadow-md z-20 focus:outline-none transition-transform duration-300" id="sidebarToggleBtn" title="Toggle Sidebar">
                <svg id="toggleIcon" class="w-4 h-4 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
                </svg>
            </button>

            <!-- Sidebar Header / Logo -->
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

                <a href="#" class="flex items-center px-3 py-2.5 text-sm font-medium text-slate-300 rounded-lg hover:bg-slate-800 hover:text-white group transition-colors" title="Manpower">
                    <svg class="w-5 h-5 mr-3 text-slate-400 group-hover:text-indigo-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <span class="sidebar-text transition-opacity duration-300">Manpower</span>
                </a>

                <a href="#" class="flex items-center px-3 py-2.5 text-sm font-medium text-slate-300 rounded-lg hover:bg-slate-800 hover:text-white group transition-colors" title="Budgets">
                    <svg class="w-5 h-5 mr-3 text-slate-400 group-hover:text-indigo-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="sidebar-text transition-opacity duration-300">Budgets</span>
                </a>

                <a href="#" class="flex items-center px-3 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-lg group shadow-sm transition-colors" title="KPI">
                    <svg class="w-5 h-5 mr-3 text-indigo-200 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    <span class="sidebar-text transition-opacity duration-300">KPI Data Sync</span>
                </a>
            </div>

            <!-- Sidebar Footer / User Profile Summary -->
            <div class="p-4 bg-slate-950 border-t border-slate-800 overflow-hidden whitespace-nowrap">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center font-bold text-white text-sm flex-shrink-0">
                            {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                        </div>
                        <div class="sidebar-text overflow-hidden transition-opacity duration-300">
                            <p class="text-xs font-medium text-white truncate max-w-[120px]">{{ Auth::user()->name ?? 'Karl Winston Torres' }}</p>
                            <p class="text-[10px] text-slate-400 truncate max-w-[120px]">{{ Auth::user()->email ?? 'Inventory & Distribution Manager' }}</p>
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

        <!-- Main Content Scrollable Area Container -->
        <div class="flex-1 flex flex-col h-screen overflow-y-auto">
            
            <!-- Top Header Navbar -->
            <header class="bg-white dark:bg-gray-950 border-b border-gray-200 dark:border-gray-800 h-16 flex items-center justify-between px-6 z-10 transition-colors duration-200">
                <div class="flex items-center space-x-4 flex-1">
                    <!-- Mobile Menu Toggle Button -->
                    <button class="md:hidden text-gray-500 hover:text-indigo-600 dark:text-gray-400 focus:outline-none transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    
                    <h1 class="text-lg font-bold text-gray-800 dark:text-gray-100 tracking-tight">
                        Data Synchronization Hub
                    </h1>
                </div>

                <!-- Right Header Actions -->
                <div class="flex items-center space-x-4 ml-4">
                    
                    <!-- Dark/Light Mode Toggle -->
                    <button onclick="toggleDarkMode()" class="text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 p-2 rounded-lg bg-gray-100 dark:bg-gray-800/50 hover:bg-gray-200 dark:hover:bg-gray-800 transition-colors" title="Toggle Theme">
                        <svg id="theme-icon-sun" class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <svg id="theme-icon-moon" class="w-5 h-5 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    </button>

                    <!-- Back to Dashboard Button -->
                    <a href="{{ route('dashboard.unified') }}" class="hidden sm:inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium rounded-lg shadow-sm transition-colors duration-150 ease-in-out">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Control Tower
                    </a>
                </div>
            </header>

            <div class="w-full mx-auto py-8 px-6 sm:px-8 lg:px-12">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <!-- Main Upload Area -->
                    <div class="lg:col-span-2 flex flex-col gap-6">
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 dark:border-gray-700/60">
                            <div class="p-8 sm:p-10">
                                
                                <div class="mb-8 border-b border-gray-100 dark:border-gray-700 pb-5">
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                        <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                        Upload Network Data
                                    </h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                                        Securely ingest your latest warehouse inventory parameters and historical KPI metrics. 
                                    </p>
                                </div>

                                <form action="{{ route('admin.import.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                                    @csrf
                                    
                                    <!-- Stylized Drag & Drop Area -->
                                    <div class="relative group">
                                        <div class="absolute inset-0 bg-indigo-50 dark:bg-indigo-900/20 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                                        <div class="relative border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-10 flex flex-col items-center justify-center bg-gray-50 dark:bg-gray-800/50 transition-colors group-hover:border-indigo-400 dark:group-hover:border-indigo-500">
                                            
                                            <div class="p-4 bg-white dark:bg-gray-700 rounded-full shadow-sm mb-4 group-hover:scale-110 transition-transform duration-300">
                                                <svg class="w-10 h-10 text-indigo-500 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                            </div>
                                            
                                            <label class="block text-gray-800 dark:text-gray-200 text-base font-bold mb-1 text-center cursor-pointer">
                                                Click to select your Excel Workbook
                                            </label>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-6 text-center">
                                                Supported formats: .xlsx, .xls, .csv
                                            </p>
                                            
                                            <!-- Custom File Input -->
                                            <input type="file" name="inventory_file" accept=".xlsx,.xls,.csv" required 
                                                class="block w-full max-w-sm text-sm text-gray-500 dark:text-gray-400 
                                                file:mr-4 file:py-2.5 file:px-6 file:rounded-full file:border-0 
                                                file:text-sm file:font-bold file:bg-indigo-600 file:text-white 
                                                hover:file:bg-indigo-500 dark:file:bg-indigo-600 dark:hover:file:bg-indigo-500 
                                                file:transition-all cursor-pointer file:shadow-md file:cursor-pointer mx-auto">
                                        </div>
                                    </div>

                                    <div class="pt-6 border-t border-gray-100 dark:border-gray-700">
                                        <button type="submit" class="w-full sm:w-auto sm:ml-auto flex items-center justify-center gap-2 bg-indigo-600 dark:bg-indigo-600 text-white font-bold py-3 px-8 rounded-lg hover:bg-indigo-500 dark:hover:bg-indigo-500 shadow-lg shadow-indigo-200 dark:shadow-none transition-all duration-200 active:scale-95">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                            Execute Data Sync
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Guidelines Sidebar -->
                    <div class="lg:col-span-1 flex flex-col gap-6">
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 dark:border-gray-700/60 p-6 sm:p-8">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-700 pb-3 mb-5 flex items-center gap-2">
                                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                System Requirements
                            </h3>
                            
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-5">
                                To ensure successful processing, your uploaded workbook must contain the following exactly named worksheets:
                            </p>

                            <ul class="space-y-4">
                                <li class="flex items-start gap-3">
                                    <div class="flex-shrink-0 w-6 h-6 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center mt-0.5">
                                        <span class="text-blue-600 dark:text-blue-400 font-bold text-xs">1</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-800 dark:text-gray-200">Raw_Data</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Contains active inventory models, Pareto classifications (A, B, C), and stockout flags.</p>
                                    </div>
                                </li>
                                <li class="flex items-start gap-3">
                                    <div class="flex-shrink-0 w-6 h-6 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center mt-0.5">
                                        <span class="text-emerald-600 dark:text-emerald-400 font-bold text-xs">2</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-800 dark:text-gray-200">KPI_YTD_Input</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Monthly aggregate data for overall network line graphs.</p>
                                    </div>
                                </li>
                                <li class="flex items-start gap-3">
                                    <div class="flex-shrink-0 w-6 h-6 rounded-full bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center mt-0.5">
                                        <span class="text-purple-600 dark:text-purple-400 font-bold text-xs">3</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-800 dark:text-gray-200">KPI_WEEKLY_Input</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Granular weekly trends feeding the executive toggle view.</p>
                                    </div>
                                </li>
                            </ul>

                            <div class="mt-8 p-4 bg-amber-50 dark:bg-amber-900/20 rounded-xl border border-amber-100 dark:border-amber-800/30">
                                <p class="text-xs text-amber-800 dark:text-amber-300 font-medium">
                                    <strong class="font-bold">Note:</strong> Previous data is automatically purged and overwritten upon successful sync to prevent duplicate metrics.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Success Toast Notification Pop-Up -->
    @if (session('success'))
        <div id="toast-success" class="fixed bottom-8 right-8 flex items-center w-full max-w-sm p-4 space-x-4 text-gray-700 bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.12)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.5)] dark:text-gray-200 dark:bg-gray-800 border-l-4 border-emerald-500 transform transition-all duration-500 translate-y-0 opacity-100 z-50 overflow-hidden" role="alert">
            <div class="absolute -right-4 -top-4 w-16 h-16 bg-emerald-500/10 dark:bg-emerald-500/20 rounded-full blur-xl"></div>
            
            <div class="inline-flex items-center justify-center flex-shrink-0 w-12 h-12 text-emerald-500 bg-emerald-100/50 rounded-xl dark:bg-emerald-900/40 dark:text-emerald-400 relative z-10">
                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            
            <div class="ml-3 flex-grow relative z-10">
                <p class="text-sm font-bold text-gray-900 dark:text-white">Sync Complete</p>
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mt-0.5">{{ session('success') }}</p>
            </div>
            
            <button type="button" class="relative z-10 ml-auto -mx-1.5 -my-1.5 bg-transparent text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-2 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:hover:text-white dark:hover:bg-gray-700 transition-colors" onclick="document.getElementById('toast-success').style.display='none'" aria-label="Close">
                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>

        <script>
            setTimeout(function() {
                const toast = document.getElementById('toast-success');
                if (toast) {
                    toast.classList.remove('translate-y-0', 'opacity-100');
                    toast.classList.add('translate-y-10', 'opacity-0');
                    setTimeout(() => toast.remove(), 500); 
                }
            }, 5000); 
        </script>
    @endif

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
            } else {
                html.classList.add('dark');
                localStorage.setItem('theme', 'dark');
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

            // Restore Theme
            if (localStorage.getItem('theme') === 'light') {
                document.documentElement.classList.remove('dark');
            }
        });
    </script>
</body>
</html>