<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SCM Unified Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    <!-- Core Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Chart.js DataLabels Plugin for intuitive numbers above points -->
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
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
                
                <a href="#" class="flex items-center px-3 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-lg group shadow-sm transition-colors" title="Dashboard Overview">
                    <svg class="w-5 h-5 mr-3 text-indigo-200 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
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

                <a href="#" class="flex items-center px-3 py-2.5 text-sm font-medium text-slate-300 rounded-lg hover:bg-slate-800 hover:text-white group transition-colors" title="KPI">
                    <svg class="w-5 h-5 mr-3 text-slate-400 group-hover:text-indigo-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    <span class="sidebar-text transition-opacity duration-300">KPI</span>
                </a>
            </div>

            <!-- Sidebar Footer / User Profile Summary -->
            <div class="p-4 bg-slate-950 border-t border-slate-800 overflow-hidden whitespace-nowrap">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center text-white font-bold text-xs flex-shrink-0">
                        KW
                    </div>
                    <div class="sidebar-text overflow-hidden transition-opacity duration-300">
                        <p class="text-xs font-medium text-white truncate">Karl Winston Torres</p>
                        <p class="text-[10px] text-slate-400 truncate">Inventory & Distribution Manager</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content Scrollable Area Container -->
        <div class="flex-1 flex flex-col h-screen overflow-y-auto">
            <div class="w-full mx-auto py-8 px-6 sm:px-8 lg:px-12">
                
                <!-- Header & Auth Controls -->
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4 border-b border-gray-200 dark:border-gray-800 pb-6">
                    <div>
                        <h1 class="text-3xl font-extrabold tracking-tight">IDP SCM Executive Control Tower</h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Real-time inventory visibility, Pareto classifications, and network stockout analytics.</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <!-- Toggle View Mode Button -->
                        <button onclick="toggleBranchView()" id="viewToggleBtn" class="bg-slate-700 hover:bg-slate-600 text-white font-medium px-4 py-2.5 rounded-lg shadow-sm transition text-sm flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <span id="viewToggleText">Hide Branch Level</span>
                        </button>

                        <!-- Dark/Light Mode Toggle Button -->
                        <button onclick="toggleDarkMode()" class="bg-gray-200 dark:bg-gray-800 hover:bg-gray-300 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 font-medium p-2.5 rounded-lg shadow-sm transition flex items-center justify-center w-10 h-10" title="Toggle Theme">
                            <svg id="theme-icon-sun" class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            <svg id="theme-icon-moon" class="w-5 h-5 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                        </button>

                        @auth
                            <a href="{{ route('admin.import') }}" class="bg-indigo-600 hover:bg-indigo-500 text-white font-semibold px-4 py-2.5 rounded-lg shadow-md transition duration-150 ease-in-out inline-flex items-center gap-2 text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                Data
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="inline m-0 p-0">
                                @csrf
                                <button type="submit" class="bg-red-600 hover:bg-red-500 text-white font-semibold px-4 py-2.5 rounded-lg shadow-md transition duration-150 ease-in-out inline-flex items-center gap-2 text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    Logout
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline font-medium text-sm ml-2">Admin Login</a>
                        @endauth
                    </div>
                </div>
                
                <!-- Filters Form -->
                <form method="GET" action="{{ route('dashboard.unified') }}" class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 p-5 rounded-xl shadow-lg mb-8 flex flex-wrap items-center gap-4">
                    <div class="flex items-center gap-2">
                        <label for="areaSelect" class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Area:</label>
                        <select name="area" id="areaSelect" onchange="handleAreaChange()" class="bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-200 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-2.5">
                            <option value="All">All Areas</option>
                            @foreach($areas as $a)
                                <option value="{{ $a }}" {{ $areaFilter == $a ? 'selected' : '' }}>{{ $a }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="flex items-center gap-2" id="branchFilterContainer">
                        <label for="branchSelect" class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Branch:</label>
                        <select name="branch" id="branchSelect" onchange="this.form.submit()" class="bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-200 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-2.5">
                            <option value="All">All Branches</option>
                            @foreach($branches as $b)
                                @php
                                    $branchArea = \App\Models\InventoryRecord::where('branch', $b)->value('area');
                                @endphp
                                <option value="{{ $b }}" data-area="{{ $branchArea }}" {{ $branchFilter == $b ? 'selected' : '' }}>{{ $b }}</option>
                            @endforeach
                        </select>
                    </div>

                    @if($areaFilter !== 'All' || $branchFilter !== 'All')
                        <div class="ml-auto">
                            <a href="{{ route('dashboard.unified') }}" class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline">Reset Filters</a>
                        </div>
                    @endif
                </form>

                <!-- WIDGET SECTION 1: AREA STOCK OUT & AVERAGE RATES -->
                <div class="mb-6">
                    <h2 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-3 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span> Area-Level Stockout Performance ({{ $areaFilter }})
                    </h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 shadow-xl rounded-xl p-6 border-t-4 border-red-500">
                            <h3 class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Area Class A Rate</h3>
                            <p class="text-3xl font-black text-gray-900 dark:text-white mt-3">{{ $areaRateA }}%</p>
                            <span class="text-xs text-red-500 dark:text-red-400 mt-1 block">High Priority Stockout Risk</span>
                        </div>
                        
                        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 shadow-xl rounded-xl p-6 border-t-4 border-amber-500">
                            <h3 class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Area Class B Rate</h3>
                            <p class="text-3xl font-black text-gray-900 dark:text-white mt-3">{{ $areaRateB }}%</p>
                            <span class="text-xs text-amber-500 dark:text-amber-400 mt-1 block">Medium Priority Risk</span>
                        </div>

                        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 shadow-xl rounded-xl p-6 border-t-4 border-yellow-400">
                            <h3 class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Area Class C Rate</h3>
                            <p class="text-3xl font-black text-gray-900 dark:text-white mt-3">{{ $areaRateC }}%</p>
                            <span class="text-xs text-yellow-600 dark:text-yellow-400 mt-1 block">Low Priority Risk</span>
                        </div>

                        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 shadow-xl rounded-xl p-6 border-t-4 border-blue-500">
                            <h3 class="text-xs font-bold text-blue-600 dark:text-blue-300 uppercase tracking-wider">Area Average Rate</h3>
                            <p class="text-3xl font-black text-gray-900 dark:text-white mt-3">{{ $areaAverageRate }}%</p>
                            <span class="text-xs text-gray-500 dark:text-gray-400 mt-1 block">Overall Performance Index</span>
                        </div>
                    </div>
                </div>

                <!-- WIDGET SECTION 2: BRANCH STOCK OUT & AVERAGE RATES (Toggled) -->
                <div id="branchSectionWidget" class="mb-8">
                    <h2 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-3 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-indigo-500"></span> Branch-Level Stockout Performance ({{ $branchFilter }})
                    </h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 shadow-xl rounded-xl p-6 border-t-4 border-rose-500">
                            <h3 class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Branch Class A Rate</h3>
                            <p class="text-3xl font-black text-gray-900 dark:text-white mt-3">{{ $branchRateA }}%</p>
                            <span class="text-xs text-rose-500 dark:text-rose-400 mt-1 block">Branch High Priority Risk</span>
                        </div>
                        
                        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 shadow-xl rounded-xl p-6 border-t-4 border-orange-400">
                            <h3 class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Branch Class B Rate</h3>
                            <p class="text-3xl font-black text-gray-900 dark:text-white mt-3">{{ $branchRateB }}%</p>
                            <span class="text-xs text-orange-500 dark:text-orange-400 mt-1 block">Branch Medium Priority Risk</span>
                        </div>

                        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 shadow-xl rounded-xl p-6 border-t-4 border-amber-400">
                            <h3 class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Branch Class C Rate</h3>
                            <p class="text-3xl font-black text-gray-900 dark:text-white mt-3">{{ $branchRateC }}%</p>
                            <span class="text-xs text-amber-600 dark:text-amber-400 mt-1 block">Branch Low Priority Risk</span>
                        </div>

                        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 shadow-xl rounded-xl p-6 border-t-4 border-indigo-600">
                            <h3 class="text-xs font-bold text-indigo-600 dark:text-indigo-300 uppercase tracking-wider">Branch Average Rate</h3>
                            <p class="text-3xl font-black text-gray-900 dark:text-white mt-3">{{ $branchAverageRate }}%</p>
                            <span class="text-xs text-gray-500 dark:text-gray-400 mt-1 block">Branch Performance Index</span>
                        </div>
                    </div>
                </div>

                <!-- WIDGET SECTION 3: EXECUTIVE KPI TRENDS -->
                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 shadow-xl rounded-xl p-6 mb-8">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 border-b border-gray-200 dark:border-gray-700 pb-4">
                        <div>
                            <h2 class="text-lg font-bold text-gray-900 dark:text-white">Executive KPI Trends</h2>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Historical performance metrics mapping DoI and Stock Out Rates.</p>
                        </div>
                        <select id="timeframeToggle" class="mt-3 md:mt-0 bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-200 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-2 font-semibold" onchange="toggleTimeframe(this.value)">
                            <option value="ytd">Year-to-Date (YTD)</option>
                            <option value="weekly">Weekly View</option>
                        </select>
                    </div>

                    <!-- RESTRUCTURED TO 2 COLUMNS FOR READABILITY -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        
                        <!-- Line Graph Widgets -->
                        <div class="border border-gray-100 dark:border-gray-700/60 rounded-xl p-5 shadow-sm flex flex-col h-80 hover:shadow-md transition-shadow bg-gray-50/50 dark:bg-gray-800/30">
                            <h4 class="text-sm font-bold text-center mb-1 text-gray-800 dark:text-gray-200">Overall After PO</h4>
                            <p class="text-[10px] text-center text-gray-500 mb-3 uppercase tracking-wider">Stockout %</p>
                            <div class="relative flex-grow"><canvas id="chartAfterPO"></canvas></div>
                        </div>
                        
                        <div class="border border-gray-100 dark:border-gray-700/60 rounded-xl p-5 shadow-sm flex flex-col h-80 hover:shadow-md transition-shadow bg-gray-50/50 dark:bg-gray-800/30">
                            <h4 class="text-sm font-bold text-center mb-1 text-gray-800 dark:text-gray-200">Overall Before PO</h4>
                            <p class="text-[10px] text-center text-gray-500 mb-3 uppercase tracking-wider">Stockout %</p>
                            <div class="relative flex-grow"><canvas id="chartBeforePO"></canvas></div>
                        </div>
                        
                        <!-- Transferred Below: -->
                        <div class="border border-gray-100 dark:border-gray-700/60 rounded-xl p-5 shadow-sm flex flex-col h-80 hover:shadow-md transition-shadow bg-gray-50/50 dark:bg-gray-800/30">
                            <h4 class="text-sm font-bold text-center mb-1 text-gray-800 dark:text-gray-200">Per Branch OOS</h4>
                            <p class="text-[10px] text-center text-gray-500 mb-3 uppercase tracking-wider">Stockout %</p>
                            <div class="relative flex-grow"><canvas id="chartPerBranch"></canvas></div>
                        </div>
                        
                        <div class="border border-gray-100 dark:border-gray-700/60 rounded-xl p-5 shadow-sm flex flex-col h-80 hover:shadow-md transition-shadow bg-gray-50/50 dark:bg-gray-800/30">
                            <h4 class="text-sm font-bold text-center mb-1 text-gray-800 dark:text-gray-200">Days of Inventory</h4>
                            <p class="text-[10px] text-center text-gray-500 mb-3 uppercase tracking-wider">DoI Ratio</p>
                            <div class="relative flex-grow"><canvas id="chartDoI"></canvas></div>
                        </div>
                        
                        <!-- Full width final graph -->
                        <div class="lg:col-span-2 border border-gray-100 dark:border-gray-700/60 rounded-xl p-5 shadow-sm flex flex-col h-80 hover:shadow-md transition-shadow bg-gray-50/50 dark:bg-gray-800/30">
                            <h4 class="text-base font-bold text-center mb-1 text-gray-800 dark:text-gray-200">Per Branch Class A Stock Out Rate</h4>
                            <p class="text-[10px] text-center text-gray-500 mb-3 uppercase tracking-wider">Network Priority Risk %</p>
                            <div class="relative flex-grow"><canvas id="chartClassA"></canvas></div>
                        </div>
                    </div>
                </div>

                <!-- Chart and Watchlist Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                    <!-- Stock Out Rate Bar Chart (Summary of Average Stock Out Rate Per Area) -->
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 shadow-xl rounded-xl p-6 flex flex-col">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Average Stock Out Rate by Area</h2>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">Comparative network average stockout trends across operating areas.</p>
                        <div class="relative flex-grow h-72">
                            <canvas id="stockoutChart"></canvas>
                        </div>
                    </div>
                    
                    <!-- Network Watchlist -->
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 shadow-xl rounded-xl p-6 flex flex-col">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Network Watchlist (Class A Stockouts)</h2>
                        <div class="overflow-y-auto max-h-72 flex-grow pr-1">
                            <table class="w-full text-left border-collapse text-sm">
                                <thead class="sticky top-0 bg-gray-100 dark:bg-gray-900 text-gray-600 dark:text-gray-400 uppercase text-xs">
                                    <tr>
                                        <th class="p-3">Model</th>
                                        <th class="p-3 text-center">Inventory</th>
                                        <th class="p-3 text-center">Suggested Transfer</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700/50">
                                    @forelse($classA->where('stock_status', 'Stockout')->take(10) as $item)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                                        <td class="p-3 font-semibold text-red-600 dark:text-red-400">{{ $item->model }}</td>
                                        <td class="p-3 text-center text-gray-700 dark:text-gray-300">{{ $item->remaining_inventory }}</td>
                                        <td class="p-3 text-center text-indigo-600 dark:text-indigo-400 font-bold">{{ $item->suggested_transfer }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="p-4 text-center text-gray-500">No active Class A stockouts found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Pareto Action Lists -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <!-- Class A Actions -->
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 shadow-xl rounded-xl p-6 flex flex-col">
                        <h3 class="font-bold text-base text-red-600 dark:text-red-400 border-b border-gray-200 dark:border-gray-700 pb-3 mb-4 flex items-center justify-between">
                            <span>Class A Actions</span>
                            <span class="text-xs bg-red-100 dark:bg-red-500/20 text-red-600 dark:text-red-300 px-2.5 py-1 rounded-full font-semibold">{{ $classA->count() }} items</span>
                        </h3>
                        <div class="overflow-x-auto overflow-y-auto max-h-[34rem] pr-1">
                            <table class="w-full text-left border-collapse text-sm whitespace-nowrap">
                                <thead class="sticky top-0 bg-gray-100 dark:bg-gray-900 text-gray-600 dark:text-gray-400 text-xs uppercase">
                                    <tr>
                                        <th class="p-2.5">Model</th>
                                        <th class="p-2.5 text-center">Inv</th>
                                        <th class="p-2.5 text-center">Trnsf</th>
                                        <th class="p-2.5 text-center">DOI</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700/40">
                                    @foreach($classA as $item)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                                        <td class="p-2.5 {{ $item->stock_status == 'Stockout' ? 'text-red-600 dark:text-red-400 font-bold' : 'text-gray-700 dark:text-gray-300' }}">
                                            {{ $item->model }}
                                        </td>
                                        <td class="p-2.5 text-center text-gray-700 dark:text-gray-300">{{ $item->remaining_inventory }}</td>
                                        <td class="p-2.5 text-center text-indigo-600 dark:text-indigo-400 font-semibold">{{ $item->suggested_transfer }}</td>
                                        <td class="p-2.5 text-center text-gray-500 dark:text-gray-400">{{ $item->doi }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Class B Actions -->
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 shadow-xl rounded-xl p-6 flex flex-col">
                        <h3 class="font-bold text-base text-amber-600 dark:text-amber-400 border-b border-gray-200 dark:border-gray-700 pb-3 mb-4 flex items-center justify-between">
                            <span>Class B Actions</span>
                            <span class="text-xs bg-amber-100 dark:bg-amber-500/20 text-amber-600 dark:text-amber-300 px-2.5 py-1 rounded-full font-semibold">{{ $classB->count() }} items</span>
                        </h3>
                        <div class="overflow-x-auto overflow-y-auto max-h-[34rem] pr-1">
                            <table class="w-full text-left border-collapse text-sm whitespace-nowrap">
                                <thead class="sticky top-0 bg-gray-100 dark:bg-gray-900 text-gray-600 dark:text-gray-400 text-xs uppercase">
                                    <tr>
                                        <th class="p-2.5">Model</th>
                                        <th class="p-2.5 text-center">Inv</th>
                                        <th class="p-2.5 text-center">Trnsf</th>
                                        <th class="p-2.5 text-center">DOI</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700/40">
                                    @foreach($classB as $item)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                                        <td class="p-2.5 {{ $item->stock_status == 'Stockout' ? 'text-amber-600 dark:text-amber-400 font-bold' : 'text-gray-700 dark:text-gray-300' }}">
                                            {{ $item->model }}
                                        </td>
                                        <td class="p-2.5 text-center text-gray-700 dark:text-gray-300">{{ $item->remaining_inventory }}</td>
                                        <td class="p-2.5 text-center text-indigo-600 dark:text-indigo-400 font-semibold">{{ $item->suggested_transfer }}</td>
                                        <td class="p-2.5 text-center text-gray-500 dark:text-gray-400">{{ $item->doi }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Class C Actions -->
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 shadow-xl rounded-xl p-6 flex flex-col">
                        <h3 class="font-bold text-base text-yellow-600 dark:text-yellow-400 border-b border-gray-200 dark:border-gray-700 pb-3 mb-4 flex items-center justify-between">
                            <span>Class C Actions</span>
                            <span class="text-xs bg-yellow-100 dark:bg-yellow-500/20 text-yellow-700 dark:text-yellow-300 px-2.5 py-1 rounded-full font-semibold">{{ $classC->count() }} items</span>
                        </h3>
                        <div class="overflow-x-auto overflow-y-auto max-h-[34rem] pr-1">
                            <table class="w-full text-left border-collapse text-sm whitespace-nowrap">
                                <thead class="sticky top-0 bg-gray-100 dark:bg-gray-900 text-gray-600 dark:text-gray-400 text-xs uppercase">
                                    <tr>
                                        <th class="p-2.5">Model</th>
                                        <th class="p-2.5 text-center">Inv</th>
                                        <th class="p-2.5 text-center">Trnsf</th>
                                        <th class="p-2.5 text-center">DOI</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700/40">
                                    @foreach($classC as $item)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                                        <td class="p-2.5 {{ $item->stock_status == 'Stockout' ? 'text-yellow-600 dark:text-yellow-400 font-bold' : 'text-gray-700 dark:text-gray-300' }}">
                                            {{ $item->model }}
                                        </td>
                                        <td class="p-2.5 text-center text-gray-700 dark:text-gray-300">{{ $item->remaining_inventory }}</td>
                                        <td class="p-2.5 text-center text-indigo-600 dark:text-indigo-400 font-semibold">{{ $item->suggested_transfer }}</td>
                                        <td class="p-2.5 text-center text-gray-500 dark:text-gray-400">{{ $item->doi }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Script Suite: Theme Toggle, Sidebar Expand/Collapse, Branch Show/Hide Toggle & Line Charts -->
    <script>
        // Ensure the DataLabels plugin is globally registered before drawing charts
        Chart.register(ChartDataLabels);

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

        // 2. Show/Hide Branch View Toggle Logic
        function toggleBranchView() {
            const branchWidget = document.getElementById('branchSectionWidget');
            const branchFilterContainer = document.getElementById('branchFilterContainer');
            const viewToggleText = document.getElementById('viewToggleText');

            if (branchWidget.classList.contains('hidden')) {
                branchWidget.classList.remove('hidden');
                branchFilterContainer.classList.remove('hidden');
                viewToggleText.textContent = 'Hide Branch Level';
                localStorage.setItem('viewMode', 'full');
            } else {
                branchWidget.classList.add('hidden');
                branchFilterContainer.classList.add('hidden');
                viewToggleText.textContent = 'Show Branch Level';
                localStorage.setItem('viewMode', 'area-only');
            }
        }

        // 3. Theme Toggle Logic with LocalStorage persistence
        function toggleDarkMode() {
            const html = document.documentElement;
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                localStorage.setItem('theme', 'light');
                updateChartTheme(false);
            } else {
                html.classList.add('dark');
                localStorage.setItem('theme', 'dark');
                updateChartTheme(true);
            }
        }

        // Restore UI States on Load
        window.addEventListener('DOMContentLoaded', () => {
            if (localStorage.getItem('sidebarState') === 'collapsed') {
                const sidebar = document.getElementById('sidebar');
                const toggleIcon = document.getElementById('toggleIcon');
                const texts = sidebar.querySelectorAll('.sidebar-text');
                
                sidebar.classList.remove('w-64');
                sidebar.classList.add('w-20');
                toggleIcon.classList.add('rotate-180');
                texts.forEach(el => {
                    el.style.opacity = '0';
                    el.style.pointerEvents = 'none';
                    el.classList.add('hidden');
                });
            }

            if (localStorage.getItem('viewMode') === 'area-only') {
                document.getElementById('branchSectionWidget').classList.add('hidden');
                document.getElementById('branchFilterContainer').classList.add('hidden');
                document.getElementById('viewToggleText').textContent = 'Show Branch Level';
            }

            if (localStorage.getItem('theme') === 'light') {
                document.documentElement.classList.remove('dark');
            }

            filterBranches();
        });

        // 4. Cascading Dependent Branch Filtering Logic
        function filterBranches() {
            const selectedArea = document.getElementById('areaSelect').value;
            const branchSelect = document.getElementById('branchSelect');
            const options = branchSelect.options;

            let currentBranchValid = false;

            for (let i = 0; i < options.length; i++) {
                const opt = options[i];
                const optArea = opt.getAttribute('data-area');

                if (opt.value === 'All' || selectedArea === 'All' || optArea === selectedArea) {
                    opt.style.display = '';
                    if (opt.value === branchSelect.value) {
                        currentBranchValid = true;
                    }
                } else {
                    opt.style.display = 'none';
                }
            }

            if (!currentBranchValid) {
                branchSelect.value = 'All';
            }
        }

        function handleAreaChange() {
            document.getElementById('branchSelect').value = 'All';
            filterBranches();
            document.getElementById('areaSelect').form.submit();
        }

        // 5. INTUITIVE LINE CHART INITIALIZATION
        let stockoutChart;
        window.kpiCharts = {};

        // Ingest Data from Controller
        const chartData = {!! isset($stockOutRates) ? json_encode($stockOutRates) : '[]' !!};
        const kpiYtd = {!! isset($kpiYtd) ? json_encode($kpiYtd) : '{"labels":[],"afterPO":[],"perBranch":[],"beforePO":[],"doi":[],"classA":[]}' !!};
        const kpiWeekly = {!! isset($kpiWeekly) ? json_encode($kpiWeekly) : '{"labels":[],"afterPO":[],"perBranch":[],"beforePO":[],"doi":[],"classA":[]}' !!};
        
        let currentKpiData = kpiYtd;

        // Reusable function to create the highly intuitive KPI charts
        function createKpiChart(ctxId, label, dataKey, colorStr, isDark, isPercentage = true) {
            const ctx = document.getElementById(ctxId).getContext('2d');
            const gridColor = isDark ? '#374151' : '#e5e7eb';
            const fontColor = isDark ? '#9ca3af' : '#6b7280';
            
            // Generate some top headroom so labels don't get chopped off at the top border
            const dataMax = Math.max(...currentKpiData[dataKey]);
            const suggestedMax = dataMax + (dataMax * 0.15); 

            return new Chart(ctx, {
                type: 'line',
                data: {
                    labels: currentKpiData.labels,
                    datasets: [{
                        label: label,
                        data: currentKpiData[dataKey],
                        borderColor: colorStr,
                        backgroundColor: colorStr + '20', // Opacity fill below the line
                        borderWidth: 3, 
                        tension: 0.4, // Smooth curvy lines
                        fill: true,
                        pointBackgroundColor: isDark ? '#1f2937' : '#ffffff',
                        pointBorderColor: colorStr,
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: {
                        padding: { top: 30, right: 15, left: 10, bottom: 5 } // Padding ensures data labels fit inside the canvas
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            mode: 'index', 
                            intersect: false,
                            backgroundColor: isDark ? 'rgba(31, 41, 55, 0.9)' : 'rgba(255, 255, 255, 0.9)',
                            titleColor: isDark ? '#f3f4f6' : '#111827',
                            bodyColor: isDark ? '#d1d5db' : '#374151',
                            borderColor: isDark ? '#4b5563' : '#e5e7eb',
                            borderWidth: 1,
                            callbacks: {
                                label: function(context) {
                                    let val = context.parsed.y;
                                    return context.dataset.label + ': ' + val + (isPercentage ? '%' : '');
                                }
                            }
                        },
                        // INTUITIVE DATALABELS CONFIGURATION
                        datalabels: {
                            display: true,
                            
                            // Smart Align: If the point is dangerously close to the max scale limit, move the label Below the point
                            align: function(context) {
                                const value = context.dataset.data[context.dataIndex];
                                const currentMax = context.chart.scales.y.max;
                                return value > (currentMax * 0.85) ? 'bottom' : 'top';
                            },
                            anchor: 'center',
                            offset: 8,
                            
                            // Frosted Background Pill so gridlines don't cross through text
                            backgroundColor: isDark ? 'rgba(17, 24, 39, 0.7)' : 'rgba(255, 255, 255, 0.8)',
                            borderRadius: 4,
                            padding: { top: 2, bottom: 2, left: 4, right: 4 },
                            color: isDark ? '#f3f4f6' : '#111827',
                            font: {
                                weight: 'bold',
                                size: 10
                            },
                            formatter: function(value) {
                                return isPercentage ? value + '%' : Math.round(value);
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            suggestedMax: suggestedMax,
                            grid: { color: gridColor, borderDash: [5, 5] }, 
                            ticks: { 
                                color: fontColor,
                                font: { size: 10 },
                                callback: function(value) { return value + (isPercentage ? '%' : ''); }
                            },
                            border: { display: false } 
                        },
                        x: {
                            grid: { display: false }, 
                            ticks: { color: fontColor, font: { size: 11, weight: '500' } },
                            border: { color: gridColor }
                        }
                    }
                }
            });
        }

        function initChart(isDark) {
            if (stockoutChart) stockoutChart.destroy();
            if (window.kpiCharts.afterPO) window.kpiCharts.afterPO.destroy();
            if (window.kpiCharts.perBranch) window.kpiCharts.perBranch.destroy();
            if (window.kpiCharts.beforePO) window.kpiCharts.beforePO.destroy();
            if (window.kpiCharts.doi) window.kpiCharts.doi.destroy();
            if (window.kpiCharts.classA) window.kpiCharts.classA.destroy();

            Chart.defaults.color = isDark ? '#9ca3af' : '#4b5563';

            const labels = [...new Set(chartData.map(d => d.area))];
            const areaAverageData = labels.map(label => {
                const recordA = chartData.find(d => d.area === label && d.pareto_class === 'Class A');
                const recordB = chartData.find(d => d.area === label && d.pareto_class === 'Class B');
                const recordC = chartData.find(d => d.area === label && d.pareto_class === 'Class C');

                const rateA = recordA ? (recordA.stockouts / recordA.total) * 100 : 0;
                const rateB = recordB ? (recordB.stockouts / recordB.total) * 100 : 0;
                const rateC = recordC ? (recordC.stockouts / recordC.total) * 100 : 0;
                return Number(((rateA + rateB + rateC) / 3).toFixed(2));
            });

            stockoutChart = new Chart(document.getElementById('stockoutChart').getContext('2d'), {
                type: 'bar', // Better for comparative categorical Area Data
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Average Stock Out Rate %',
                        data: areaAverageData,
                        backgroundColor: isDark ? 'rgba(99, 102, 241, 0.8)' : 'rgba(99, 102, 241, 0.9)',
                        borderRadius: 6,
                        borderSkipped: false
                    }]
                },
                options: { 
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: { padding: { top: 25 } },
                    plugins: {
                        legend: { display: false },
                        datalabels: {
                            display: true,
                            align: 'top',
                            anchor: 'end',
                            offset: 4,
                            color: isDark ? '#f3f4f6' : '#111827',
                            font: { weight: 'bold', size: 11 },
                            formatter: function(value) { return value + '%'; }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: isDark ? '#374151' : '#e5e7eb', borderDash: [5, 5] },
                            ticks: { color: isDark ? '#9ca3af' : '#6b7280', callback: function(value) { return value + '%'; } },
                            border: { display: false }
                        },
                        x: { 
                            grid: { display: false },
                            ticks: { color: isDark ? '#9ca3af' : '#4b5563', font: { weight: 'bold' } },
                            border: { color: isDark ? '#4b5563' : '#d1d5db' }
                        }
                    }
                }
            });

            window.kpiCharts.afterPO = createKpiChart('chartAfterPO', 'After PO OOS', 'afterPO', '#10b981', isDark, true);
            window.kpiCharts.beforePO = createKpiChart('chartBeforePO', 'Before PO OOS', 'beforePO', '#f59e0b', isDark, true);
            window.kpiCharts.perBranch = createKpiChart('chartPerBranch', 'Per Branch OOS', 'perBranch', '#3b82f6', isDark, true);
            window.kpiCharts.doi = createKpiChart('chartDoI', 'Days of Inventory', 'doi', '#8b5cf6', isDark, false);
            window.kpiCharts.classA = createKpiChart('chartClassA', 'Class A Stock Out', 'classA', '#ef4444', isDark, true);
        }

        window.toggleTimeframe = function(timeframe) {
            currentKpiData = timeframe === 'weekly' ? kpiWeekly : kpiYtd;
            
            const updateChartData = (chartObj, dataKey) => {
                if(chartObj) {
                    chartObj.data.labels = currentKpiData.labels;
                    chartObj.data.datasets[0].data = currentKpiData[dataKey];
                    
                    const maxVal = Math.max(...currentKpiData[dataKey]);
                    chartObj.options.scales.y.suggestedMax = maxVal + (maxVal * 0.15);
                    
                    chartObj.update();
                }
            };

            updateChartData(window.kpiCharts.afterPO, 'afterPO');
            updateChartData(window.kpiCharts.beforePO, 'beforePO');
            updateChartData(window.kpiCharts.perBranch, 'perBranch');
            updateChartData(window.kpiCharts.doi, 'doi');
            updateChartData(window.kpiCharts.classA, 'classA');
        };

        function updateChartTheme(isDark) {
            initChart(isDark);
        }

        const initialDarkState = localStorage.getItem('theme') === 'dark' || 
                                 (!localStorage.getItem('theme') && document.documentElement.classList.contains('dark'));
        initChart(initialDarkState);

    </script>
</body>
</html>