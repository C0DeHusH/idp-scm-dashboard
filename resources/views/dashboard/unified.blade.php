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
    <!-- Chart.js DataLabels Plugin -->
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 font-sans antialiased transition-colors duration-200">
    <div class="flex h-screen overflow-hidden">
        
        <!-- Main Application Wrapper -->
        <div class="flex-1 flex flex-col h-screen w-full relative">
            
            <!-- ========================================== -->
            <!-- FROZEN HEADER -->
            <!-- ========================================== -->
            <header class="flex-shrink-0 z-40 bg-white/95 dark:bg-gray-950/95 backdrop-blur-md border-b border-gray-200 dark:border-gray-800 transition-colors duration-200 shadow-sm w-full">
                <div class="py-5 px-6 sm:px-8 lg:px-12 mx-auto flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight">IDP SCM Executive Control Tower</h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Real-time inventory visibility, Pareto classifications, and network stockout analytics.</p>
                    </div>
                    <div class="flex items-center gap-3">
                        
                        <!-- Dark/Light Mode Toggle Button -->
                        <button onclick="toggleDarkMode()" class="bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 font-medium p-2.5 rounded-lg shadow-sm transition flex items-center justify-center w-10 h-10 border border-gray-200 dark:border-gray-700/50" title="Toggle Theme">
                            <svg id="theme-icon-sun" class="w-5 h-5 hidden dark:block text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            <svg id="theme-icon-moon" class="w-5 h-5 block dark:hidden text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                        </button>

                        @auth
                            <!-- Dropdown List Button for Import/Export -->
                            <div class="relative inline-block text-left" id="dataDropdownContainer">
                                <button onclick="toggleDropdown('dataDropdownMenu')" class="bg-indigo-600 hover:bg-indigo-500 text-white font-semibold px-4 py-2.5 rounded-lg shadow-md transition duration-150 ease-in-out inline-flex items-center gap-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/></svg>
                                    Data Sync
                                    <svg class="w-4 h-4 ml-1 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                                </button>

                                <!-- Dropdown Menu Popup -->
                                <div id="dataDropdownMenu" class="origin-top-right absolute right-0 mt-2 w-64 rounded-xl shadow-lg bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 ring-1 ring-black ring-opacity-5 hidden z-50 transition-all divide-y divide-gray-100 dark:divide-gray-700">
                                    <div class="p-1.5" role="menu" aria-orientation="vertical">
                                        <!-- Import Option -->
                                        <a href="{{ route('admin.import') }}" class="group flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-500/10 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors" role="menuitem">
                                            <svg class="mr-3 h-5 w-5 text-indigo-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                            </svg>
                                            Import Workbooks
                                        </a>
                                   
                                    </div>
                                    <div class="p-1.5" role="menu" aria-orientation="vertical">
                                        <p class="px-3 py-1.5 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Presentation Exports</p>
                                        <!-- PDF Export Option -->
                                        <a href="#" class="group flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 rounded-lg hover:bg-rose-50 dark:hover:bg-rose-500/10 hover:text-rose-600 dark:hover:text-rose-400 transition-colors" role="menuitem">
                                            <svg class="mr-3 h-5 w-5 text-rose-400 group-hover:text-rose-600 dark:group-hover:text-rose-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                            Export as PDF Report
                                        </a>
                                        <!-- PPT Export Option -->
                                        <a href="#" class="group flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 rounded-lg hover:bg-orange-50 dark:hover:bg-orange-500/10 hover:text-orange-600 dark:hover:text-orange-400 transition-colors" role="menuitem">
                                            <svg class="mr-3 h-5 w-5 text-orange-400 group-hover:text-orange-600 dark:group-hover:text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                            </svg>
                                            Export as PowerPoint
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('logout') }}" class="inline m-0 p-0">
                                @csrf
                                <button type="submit" class="bg-red-600 hover:bg-red-500 text-white font-semibold px-4 py-2.5 rounded-lg shadow-md transition duration-150 ease-in-out inline-flex items-center gap-2 text-sm border border-red-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    Logout
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline font-medium text-sm ml-2">Admin Login</a>
                        @endauth
                    </div>
                </div>
            </header>

            <!-- ========================================== -->
            <!-- SCROLLABLE DASHBOARD CONTENT -->
            <!-- ========================================== -->
            <main class="flex-1 overflow-y-auto bg-gray-50 dark:bg-gray-900 w-full relative">
                <div class="w-full mx-auto py-8 px-6 sm:px-8 lg:px-12">
                    
                    <!-- Unified Form for all filtering (AJAX Intercepted) -->
                    <form method="GET" action="{{ route('dashboard.unified') }}" id="dashboardForm" class="space-y-8">
                        
                        <!-- Hidden Container storing encoded PHP payload for Charts -->
                        <div id="chartDataContainer" class="hidden" 
                            data-chart="{{ isset($stockOutRates) ? json_encode($stockOutRates) : '[]' }}" 
                            data-kpi-ytd="{{ isset($kpiYtd) ? json_encode($kpiYtd) : '{"labels":[],"afterPO":[],"perBranch":[],"beforePO":[],"doi":[],"classA":[],"classADoI":[]}' }}" data-kpi-weekly="{{ isset($kpiWeekly) ? json_encode($kpiWeekly) : '{"labels":[],"afterPO":[],"perBranch":[],"beforePO":[],"doi":[],"classA":[],"classADoI":[]}' }}">
                        </div>

                        <!-- SECTION 1: AREA-LEVEL PRESENTATION -->
                        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 p-6 rounded-xl shadow-xl transition-all">
                            
                            <!-- Area Header & Filters -->
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 border-b border-gray-200 dark:border-gray-700 pb-4 gap-4">
                                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span> Area-Level Stockout Performance ({{ $areaFilter }})
                                </h2>
                                <div class="flex items-center gap-3 w-full md:w-auto">
                                    <label for="areaSelect" class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider whitespace-nowrap">Area:</label>
                                    <select name="area" id="areaSelect" onchange="handleAreaChange()" class="bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-200 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-2 w-full md:w-48">
                                        <option value="All">All Areas</option>
                                        @foreach($areas as $a)
                                            <option value="{{ $a }}" {{ $areaFilter == $a ? 'selected' : '' }}>{{ $a }}</option>
                                        @endforeach
                                    </select>
                                    @if($areaFilter !== 'All' || $branchFilter !== 'All')
                                        <a href="{{ route('dashboard.unified') }}" class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline whitespace-nowrap">Reset Filters</a>
                                    @endif
                                </div>
                            </div>

                            <!-- Area Rate Cards -->
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-10">
                                <div class="bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 shadow-sm rounded-xl p-5 border-t-4 border-red-500">
                                    <h3 class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Area Class A Rate</h3>
                                    <p class="text-3xl font-black text-gray-900 dark:text-white mt-3">{{ round($areaRateA) }}%</p>
                                    <span class="text-xs text-red-500 dark:text-red-400 mt-1 block">High Priority Stockout Risk</span>
                                </div>
                                
                                <div class="bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 shadow-sm rounded-xl p-5 border-t-4 border-amber-500">
                                    <h3 class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Area Class B Rate</h3>
                                    <p class="text-3xl font-black text-gray-900 dark:text-white mt-3">{{ round($areaRateB) }}%</p>
                                    <span class="text-xs text-amber-500 dark:text-amber-400 mt-1 block">Medium Priority Risk</span>
                                </div>

                                <div class="bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 shadow-sm rounded-xl p-5 border-t-4 border-yellow-400">
                                    <h3 class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Area Class C Rate</h3>
                                    <p class="text-3xl font-black text-gray-900 dark:text-white mt-3">{{ round($areaRateC) }}%</p>
                                    <span class="text-xs text-yellow-600 dark:text-yellow-400 mt-1 block">Low Priority Risk</span>
                                </div>

                                <div class="bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 shadow-sm rounded-xl p-5 border-t-4 border-blue-500">
                                    <h3 class="text-xs font-bold text-blue-600 dark:text-blue-300 uppercase tracking-wider">Area Average Rate</h3>
                                    <p class="text-3xl font-black text-gray-900 dark:text-white mt-3">{{ round($areaAverageRate) }}%</p>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 mt-1 block">Overall Performance Index</span>
                                </div>
                            </div>
                            
                            <div class="lg:col-span-2 border border-gray-100 dark:border-gray-700/60 rounded-xl p-5 shadow-sm flex flex-col h-80 hover:shadow-md transition-shadow bg-gray-50/50 dark:bg-gray-800/30">
                                <h4 class="text-sm font-bold text-center mb-1 text-gray-800 dark:text-gray-200">Average Stock Out Rate by Area</h4>
                                <p class="text-[10px] text-center text-gray-500 mb-3 uppercase tracking-wider">Network Comparison</p>
                                <div class="relative flex-grow"><canvas id="stockoutChart"></canvas></div>
                            </div>

                            <!-- Area Line Graphs (Trends) -->
                            <div> <br>
                                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 border-b border-gray-200 dark:border-gray-700 pb-4">
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Area KPI Trends</h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Historical performance metrics mapping DoI and Stock Out Rates.</p>
                                    </div>
                                    <select id="timeframeToggle" class="mt-3 md:mt-0 bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-200 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-2 font-semibold" onchange="toggleTimeframe(this.value)">
                                        <option value="ytd">Year-to-Date (YTD)</option>
                                        <option value="weekly">Weekly View</option>
                                    </select>
                                </div>
                                
                                <!-- Graph Grid -->
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                    <div class="border border-gray-100 dark:border-gray-700/60 rounded-xl p-5 shadow-sm flex flex-col h-80 hover:shadow-md transition-shadow bg-gray-50/50 dark:bg-gray-800/30">
                                        <h4 class="text-sm font-bold text-center mb-1 text-gray-800 dark:text-gray-200">Per Branch OOS</h4>
                                        <p class="text-[10px] text-center text-gray-500 mb-3 uppercase tracking-wider">Stockout %</p>
                                        <div class="relative flex-grow"><canvas id="chartPerBranch"></canvas></div>
                                    </div>
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
                                    
                                    <div class="border border-gray-100 dark:border-gray-700/60 rounded-xl p-5 shadow-sm flex flex-col h-80 hover:shadow-md transition-shadow bg-gray-50/50 dark:bg-gray-800/30">
                                        <h4 class="text-sm font-bold text-center mb-1 text-gray-800 dark:text-gray-200">Per Branch Class A Stock Out Rate</h4>
                                        <p class="text-[10px] text-center text-gray-500 mb-3 uppercase tracking-wider">Network Priority Risk %</p>
                                        <div class="relative flex-grow"><canvas id="chartClassA"></canvas></div>
                                    </div>
                                    <div class="border border-gray-100 dark:border-gray-700/60 rounded-xl p-5 shadow-sm flex flex-col h-80 hover:shadow-md transition-shadow bg-gray-50/50 dark:bg-gray-800/30">
                                        <h4 class="text-sm font-bold text-center mb-1 text-gray-800 dark:text-gray-200">Class A Days of Inventory</h4>
                                        <p class="text-[10px] text-center text-gray-500 mb-3 uppercase tracking-wider">Class A DoI Ratio</p>
                                        <div class="relative flex-grow"><canvas id="chartClassADoI"></canvas></div>
                                    </div>

                                    <div class="border border-gray-100 dark:border-gray-700/60 rounded-xl p-5 shadow-sm flex flex-col h-80 hover:shadow-md transition-shadow bg-gray-50/50 dark:bg-gray-800/30">
                                        <h4 class="text-sm font-bold text-center mb-1 text-gray-800 dark:text-gray-200">Days of Inventory</h4>
                                        <p class="text-[10px] text-center text-gray-500 mb-3 uppercase tracking-wider">DoI Ratio</p>
                                        <div class="relative flex-grow"><canvas id="chartDoI"></canvas></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 2: BRANCH-LEVEL PRESENTATION -->
                        <div id="branchSectionWidget" class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 p-6 rounded-xl shadow-xl transition-all">
                            
                            <!-- Branch Header & Filter -->
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 border-b border-gray-200 dark:border-gray-700 pb-4 gap-4">
                                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-indigo-500"></span> Branch-Level Stockout Performance ({{ $branchFilter }})
                                </h2>
                                <div class="flex items-center gap-2 w-full md:w-auto" id="branchFilterContainer">
                                    <label for="branchSelect" class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider whitespace-nowrap">Branch:</label>
                                    <select name="branch" id="branchSelect" onchange="fetchFilteredData()" class="bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-200 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-2 w-full md:w-64">
                                        <option value="All">All Branches</option>
                                        @foreach($branches as $b)
                                            @php
                                                $branchArea = \App\Models\InventoryRecord::where('branch', $b)->value('area');
                                            @endphp
                                            <option value="{{ $b }}" data-area="{{ $branchArea }}" {{ $branchFilter == $b ? 'selected' : '' }}>{{ $b }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Branch Rate Cards -->
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-10">
                                <div class="bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 shadow-sm rounded-xl p-5 border-t-4 border-rose-500">
                                    <h3 class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Branch Class A Rate</h3>
                                    <p class="text-3xl font-black text-gray-900 dark:text-white mt-3">{{ round($branchRateA) }}%</p>
                                    <span class="text-xs text-rose-500 dark:text-rose-400 mt-1 block">Branch High Priority Risk</span>
                                </div>
                                
                                <div class="bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 shadow-sm rounded-xl p-5 border-t-4 border-orange-400">
                                    <h3 class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Branch Class B Rate</h3>
                                    <p class="text-3xl font-black text-gray-900 dark:text-white mt-3">{{ round($branchRateB) }}%</p>
                                    <span class="text-xs text-orange-500 dark:text-orange-400 mt-1 block">Branch Medium Priority Risk</span>
                                </div>

                                <div class="bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 shadow-sm rounded-xl p-5 border-t-4 border-amber-400">
                                    <h3 class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Branch Class C Rate</h3>
                                    <p class="text-3xl font-black text-gray-900 dark:text-white mt-3">{{ round($branchRateC) }}%</p>
                                    <span class="text-xs text-amber-600 dark:text-amber-400 mt-1 block">Branch Low Priority Risk</span>
                                </div>

                                <div class="bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 shadow-sm rounded-xl p-5 border-t-4 border-indigo-600">
                                    <h3 class="text-xs font-bold text-indigo-600 dark:text-indigo-300 uppercase tracking-wider">Branch Average Rate</h3>
                                    <p class="text-3xl font-black text-gray-900 dark:text-white mt-3">{{ round($branchAverageRate) }}%</p>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 mt-1 block">Branch Performance Index</span>
                                </div>
                            </div>

                            <!-- Pareto Action Models -->
                            <div class="mb-10">
                                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4">Pareto Action Models</h3>
                                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                                    
                                    <!-- Class A Actions -->
                                    <div class="bg-gray-50/50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700/60 shadow-sm rounded-xl p-5 flex flex-col">
                                        <h3 class="font-bold text-sm text-red-600 dark:text-red-400 border-b border-gray-200 dark:border-gray-700 pb-3 mb-4 flex items-center justify-between">
                                            <span>Class A Models</span>
                                            <span class="text-[10px] bg-red-100 dark:bg-red-500/20 text-red-600 dark:text-red-300 px-2 py-1 rounded-full font-semibold">{{ $classA->count() }} items</span>
                                        </h3>
                                        <div class="overflow-x-auto overflow-y-auto max-h-80 pr-1">
                                            <table class="w-full text-left border-collapse text-xs whitespace-nowrap">
                                                <thead class="sticky top-0 bg-white dark:bg-gray-900 text-gray-600 dark:text-gray-400 uppercase">
                                                    <tr>
                                                        <th class="p-2">Model</th>
                                                        <th class="p-2 text-center">Status</th>
                                                        <th class="p-2 text-center">Inv</th>
                                                        <th class="p-2 text-center">Trnsf</th>
                                                        <th class="p-2 text-center">DOI</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700/40">
                                                    @foreach($classA as $item)
                                                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700/50 transition">
                                                        <td class="p-2 {{ $item->stock_status == 'Stockout' ? 'text-red-600 dark:text-red-400 font-bold' : 'text-gray-700 dark:text-gray-300' }}">
                                                            {{ $item->model }}
                                                        </td>
                                                        <td class="p-2 text-center text-xs font-semibold {{ $item->stock_status == 'Stockout' ? 'text-red-600 dark:text-red-400' : 'text-gray-600 dark:text-gray-400' }}">
                                                            {{ $item->stock_status }}
                                                        </td>
                                                        <td class="p-2 text-center text-gray-700 dark:text-gray-300">{{ round($item->remaining_inventory) }}</td>
                                                        <td class="p-2 text-center text-indigo-600 dark:text-indigo-400 font-semibold">{{ round($item->suggested_transfer) }}</td>
                                                        <td class="p-2 text-center text-gray-500 dark:text-gray-400">{{ round($item->doi) }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Class B Actions -->
                                    <div class="bg-gray-50/50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700/60 shadow-sm rounded-xl p-5 flex flex-col">
                                        <h3 class="font-bold text-sm text-amber-600 dark:text-amber-400 border-b border-gray-200 dark:border-gray-700 pb-3 mb-4 flex items-center justify-between">
                                            <span>Class B Models</span>
                                            <span class="text-[10px] bg-amber-100 dark:bg-amber-500/20 text-amber-600 dark:text-amber-300 px-2 py-1 rounded-full font-semibold">{{ $classB->count() }} items</span>
                                        </h3>
                                        <div class="overflow-x-auto overflow-y-auto max-h-80 pr-1">
                                            <table class="w-full text-left border-collapse text-xs whitespace-nowrap">
                                                <thead class="sticky top-0 bg-white dark:bg-gray-900 text-gray-600 dark:text-gray-400 uppercase">
                                                    <tr>
                                                        <th class="p-2">Model</th>
                                                        <th class="p-2 text-center">Status</th>
                                                        <th class="p-2 text-center">Inv</th>
                                                        <th class="p-2 text-center">Trnsf</th>
                                                        <th class="p-2 text-center">DOI</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700/40">
                                                    @foreach($classB as $item)
                                                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700/50 transition">
                                                        <td class="p-2 {{ $item->stock_status == 'Stockout' ? 'text-amber-600 dark:text-amber-400 font-bold' : 'text-gray-700 dark:text-gray-300' }}">
                                                            {{ $item->model }}
                                                        </td>
                                                        <td class="p-2 text-center text-xs font-semibold {{ $item->stock_status == 'Stockout' ? 'text-red-600 dark:text-red-400' : 'text-gray-600 dark:text-gray-400' }}">
                                                            {{ $item->stock_status }}
                                                        </td>
                                                        <td class="p-2 text-center text-gray-700 dark:text-gray-300">{{ round($item->remaining_inventory) }}</td>
                                                        <td class="p-2 text-center text-indigo-600 dark:text-indigo-400 font-semibold">{{ round($item->suggested_transfer) }}</td>
                                                        <td class="p-2 text-center text-gray-500 dark:text-gray-400">{{ round($item->doi) }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Class C Actions -->
                                    <div class="bg-gray-50/50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700/60 shadow-sm rounded-xl p-5 flex flex-col">
                                        <h3 class="font-bold text-sm text-yellow-600 dark:text-yellow-400 border-b border-gray-200 dark:border-gray-700 pb-3 mb-4 flex items-center justify-between">
                                            <span>Class C Models</span>
                                            <span class="text-[10px] bg-yellow-100 dark:bg-yellow-500/20 text-yellow-700 dark:text-yellow-300 px-2 py-1 rounded-full font-semibold">{{ $classC->count() }} items</span>
                                        </h3>
                                        <div class="overflow-x-auto overflow-y-auto max-h-80 pr-1">
                                            <table class="w-full text-left border-collapse text-xs whitespace-nowrap">
                                                <thead class="sticky top-0 bg-white dark:bg-gray-900 text-gray-600 dark:text-gray-400 uppercase">
                                                    <tr>
                                                        <th class="p-2">Model</th>
                                                        <th class="p-2 text-center">Status</th>
                                                        <th class="p-2 text-center">Inv</th>
                                                        <th class="p-2 text-center">Trnsf</th>
                                                        <th class="p-2 text-center">DOI</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700/40">
                                                    @foreach($classC as $item)
                                                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700/50 transition">
                                                        <td class="p-2 {{ $item->stock_status == 'Stockout' ? 'text-yellow-600 dark:text-yellow-400 font-bold' : 'text-gray-700 dark:text-gray-300' }}">
                                                            {{ $item->model }}
                                                        </td>
                                                        <td class="p-2 text-center text-xs font-semibold {{ $item->stock_status == 'Stockout' ? 'text-red-600 dark:text-red-400' : 'text-gray-600 dark:text-gray-400' }}">
                                                            {{ $item->stock_status }}
                                                        </td>
                                                        <td class="p-2 text-center text-gray-700 dark:text-gray-300">{{ round($item->remaining_inventory) }}</td>
                                                        <td class="p-2 text-center text-indigo-600 dark:text-indigo-400 font-semibold">{{ round($item->suggested_transfer) }}</td>
                                                        <td class="p-2 text-center text-gray-500 dark:text-gray-400">{{ round($item->doi) }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Network Watchlist -->
                            <div class="border border-gray-100 dark:border-gray-700/60 rounded-xl p-5 shadow-sm flex flex-col bg-gray-50/50 dark:bg-gray-800/30">
                                <h2 class="text-base font-bold text-gray-900 dark:text-white mb-4">Branch Watchlist (Class A Stockouts)</h2>
                                <div class="overflow-y-auto max-h-64 flex-grow pr-1">
                                    <table class="w-full text-left border-collapse text-sm">
                                        <thead class="sticky top-0 bg-white dark:bg-gray-900 text-gray-600 dark:text-gray-400 uppercase text-xs">
                                            <tr>
                                                <th class="p-3">Model</th>
                                                <th class="p-3 text-center">Status</th>
                                                <th class="p-3 text-center">Inventory</th>
                                                <th class="p-3 text-center">Suggested Transfer</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700/50">
                                            @forelse($classA->where('stock_status', 'Stockout')->take(10) as $item)
                                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700/30 transition">
                                                <td class="p-3 font-semibold text-red-600 dark:text-red-400">{{ $item->model }}</td>
                                                <td class="p-3 text-center text-red-600 dark:text-red-400 font-semibold">{{ $item->stock_status }}</td>
                                                <td class="p-3 text-center text-gray-700 dark:text-gray-300">{{ round($item->remaining_inventory) }}</td>
                                                <td class="p-3 text-center text-indigo-600 dark:text-indigo-400 font-bold">{{ round($item->suggested_transfer) }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="4" class="p-4 text-center text-gray-500">No active Class A stockouts found.</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </form>

                </div>
            </main>
        </div>
    </div>

    <!-- Enhanced Success Toast Notification Pop-Up (Added for the Redirect) -->
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
    @endif

    <!-- Enhanced Error Toast Notification Pop-Up (Added for the Redirect) -->
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
    @endif

    <!-- Script Suite -->
    <script>
        // Data Sync Dropdown Toggle Logic
        function toggleDropdown(id) {
            const dropdown = document.getElementById(id);
            dropdown.classList.toggle('hidden');
        }

        // Close Dropdown when clicking outside
        window.addEventListener('click', function(e) {
            const button = document.getElementById('dataDropdownContainer');
            const dropdown = document.getElementById('dataDropdownMenu');
            if (button && dropdown && !button.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });

        // Ensure the DataLabels plugin is globally registered before drawing charts
        Chart.register(ChartDataLabels);

        // Toast Auto-Dismiss Logic
        document.addEventListener('DOMContentLoaded', () => {
            const successToast = document.getElementById('toast-success');
            if (successToast) {
                setTimeout(() => {
                    successToast.classList.remove('translate-y-0', 'opacity-100');
                    successToast.classList.add('translate-y-10', 'opacity-0');
                    setTimeout(() => successToast.remove(), 500); 
                }, 5000);
            }

            const errorToast = document.getElementById('toast-error');
            if (errorToast) {
                setTimeout(() => {
                    errorToast.classList.remove('translate-y-0', 'opacity-100');
                    errorToast.classList.add('translate-y-10', 'opacity-0');
                    setTimeout(() => errorToast.remove(), 500); 
                }, 8000);
            }
        });

        // Theme Toggle Logic with LocalStorage persistence
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
            if (localStorage.getItem('theme') === 'light') {
                document.documentElement.classList.remove('dark');
            }
            filterBranches();
        });

        // Cascading Dependent Branch Filtering & AJAX Update Logic
        async function fetchFilteredData() {
            const form = document.getElementById('dashboardForm');
            const url = new URL(window.location.href.split('?')[0]); 
            const formData = new FormData(form);
            
            // Defensively capture timeframe toggle state
            const timeframeSelect = document.getElementById('timeframeToggle');
            const currentTimeframe = timeframeSelect ? timeframeSelect.value : 'ytd';

            // Build new query string
            formData.forEach((value, key) => {
                if(value) url.searchParams.append(key, value);
            });

            // Add visual fade out feedback while loading
            form.classList.add('opacity-50', 'pointer-events-none', 'transition-opacity', 'duration-300');

            try {
                const response = await fetch(url.toString(), {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const html = await response.text();
                
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                
                // Swap the inner content without refreshing the whole page
                const newForm = doc.getElementById('dashboardForm');
                if (newForm) {
                    form.innerHTML = newForm.innerHTML;
                    
                    // Re-apply preserved toggle state
                    const newTimeframeSelect = document.getElementById('timeframeToggle');
                    if (newTimeframeSelect) {
                        newTimeframeSelect.value = currentTimeframe;
                    }
                    
                    // Re-initialize logic after DOM swap
                    filterBranches(); 
                    const isDark = document.documentElement.classList.contains('dark');
                    initChart(isDark);
                }
            } catch (error) {
                console.error('Error fetching data:', error);
                form.submit(); // fallback to normal reload if fetch fails
            } finally {
                form.classList.remove('opacity-50', 'pointer-events-none');
            }
        }

        function filterBranches() {
            const selectedArea = document.getElementById('areaSelect').value;
            const branchSelect = document.getElementById('branchSelect');
            if(!branchSelect) return;

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
            fetchFilteredData();
        }

        // INTUITIVE LINE CHART INITIALIZATION
        let stockoutChart;
        window.kpiCharts = {};

        // Helper to grab safe JSON array keys defensively 
        function getSafeData(dataKey) {
            if (!window.currentKpiData) return [];
            return window.currentKpiData[dataKey] || [];
        }

        // Reusable function to create the highly intuitive KPI charts
        function createKpiChart(ctxId, label, dataKey, colorStr, isDark, isPercentage = true) {
            const canvas = document.getElementById(ctxId);
            if (!canvas) return null;
            
            const ctx = canvas.getContext('2d');
            const gridColor = isDark ? '#374151' : '#e5e7eb';
            const fontColor = isDark ? '#9ca3af' : '#6b7280';
            
            // Extract the live data mapped to global
            const dataArr = getSafeData(dataKey);
            
            // Ensure numbers parse safely to avoid ChartJS crash
            const validData = dataArr.filter(v => v !== null && v !== undefined && !isNaN(v)).map(Number);
            const dataMax = validData.length ? Math.max(...validData) : 0;
            const suggestedMax = dataMax + (dataMax * 0.15) || 1;

            return new Chart(ctx, {
                type: 'line',
                data: {
                    labels: window.currentKpiData.labels || [],
                    datasets: [{
                        label: label,
                        data: dataArr,
                        borderColor: colorStr,
                        backgroundColor: colorStr + '20',
                        borderWidth: 3, 
                        tension: 0.4, 
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
                        padding: { top: 30, right: 15, left: 10, bottom: 5 }
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
                                    let val = Math.round(context.parsed.y);
                                    return context.dataset.label + ': ' + val + (isPercentage ? '%' : '');
                                }
                            }
                        },
                        datalabels: {
                            display: true,
                            align: function(context) {
                                const value = context.dataset.data[context.dataIndex];
                                const currentMax = context.chart.scales.y.max || 1;
                                return value > (currentMax * 0.85) ? 'bottom' : 'top';
                            },
                            anchor: 'center',
                            offset: 8,
                            backgroundColor: isDark ? 'rgba(17, 24, 39, 0.7)' : 'rgba(255, 255, 255, 0.8)',
                            borderRadius: 4,
                            padding: { top: 2, bottom: 2, left: 4, right: 4 },
                            color: isDark ? '#f3f4f6' : '#111827',
                            font: {
                                weight: 'bold',
                                size: 10
                            },
                            formatter: function(value) {
                                return Math.round(value) + (isPercentage ? '%' : '');
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
                                callback: function(value) { return Math.round(value) + (isPercentage ? '%' : ''); }
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
            // Destroy existing charts to prevent artifacting 
            if (stockoutChart) stockoutChart.destroy();
            if (window.kpiCharts.afterPO) window.kpiCharts.afterPO.destroy();
            if (window.kpiCharts.perBranch) window.kpiCharts.perBranch.destroy();
            if (window.kpiCharts.beforePO) window.kpiCharts.beforePO.destroy();
            if (window.kpiCharts.doi) window.kpiCharts.doi.destroy();
            if (window.kpiCharts.classA) window.kpiCharts.classA.destroy();
            if (window.kpiCharts.classADoI) window.kpiCharts.classADoI.destroy();

            // Fetch dynamic payload from hidden container
            const dataContainer = document.getElementById('chartDataContainer');
            const chartData = JSON.parse(dataContainer.getAttribute('data-chart'));
            const kpiYtd = JSON.parse(dataContainer.getAttribute('data-kpi-ytd'));
            const kpiWeekly = JSON.parse(dataContainer.getAttribute('data-kpi-weekly'));
            
            const timeframeToggle = document.getElementById('timeframeToggle');
            const timeframe = timeframeToggle ? timeframeToggle.value : 'ytd';
            window.currentKpiData = timeframe === 'weekly' ? kpiWeekly : kpiYtd;

            Chart.defaults.color = isDark ? '#9ca3af' : '#4b5563';

            // AREA BAR CHART
            const labels = [...new Set(chartData.map(d => d.area))];
            const areaAverageData = labels.map(label => {
                const recordA = chartData.find(d => d.area === label && d.pareto_class === 'Class A');
                const recordB = chartData.find(d => d.area === label && d.pareto_class === 'Class B');
                const recordC = chartData.find(d => d.area === label && d.pareto_class === 'Class C');

                const rateA = recordA && recordA.total > 0 ? (recordA.stockouts / recordA.total) * 100 : 0;
                const rateB = recordB && recordB.total > 0 ? (recordB.stockouts / recordB.total) * 100 : 0;
                const rateC = recordC && recordC.total > 0 ? (recordC.stockouts / recordC.total) * 100 : 0;

                return Math.round((rateA + rateB + rateC) / 3);
            });

            const stockoutCanvas = document.getElementById('stockoutChart');
            if (stockoutCanvas) {
                stockoutChart = new Chart(stockoutCanvas.getContext('2d'), {
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
                                display: true, align: 'top', anchor: 'end', offset: 4,
                                color: isDark ? '#f3f4f6' : '#111827',
                                font: { weight: 'bold', size: 11 },
                                formatter: function(value) { return Math.round(value) + '%'; }
                            }
                        },
                        scales: {
                            y: { beginAtZero: true, grid: { color: isDark ? '#374151' : '#e5e7eb', borderDash: [5, 5] }, ticks: { color: isDark ? '#9ca3af' : '#6b7280', callback: function(value) { return Math.round(value) + '%'; } }, border: { display: false } },
                            x: { grid: { display: false }, ticks: { color: isDark ? '#9ca3af' : '#4b5563', font: { weight: 'bold' } }, border: { color: isDark ? '#4b5563' : '#d1d5db' } }
                        }
                    }
                });
            }

            // OTHER KPI CHARTS
            window.kpiCharts.afterPO = createKpiChart('chartAfterPO', 'After PO OOS %', 'afterPO', '#10b981', isDark, true);
            window.kpiCharts.beforePO = createKpiChart('chartBeforePO', 'Before PO OOS %', 'beforePO', '#f59e0b', isDark, true);
            window.kpiCharts.perBranch = createKpiChart('chartPerBranch', 'Per Branch OOS %', 'perBranch', '#3b82f6', isDark, true);
            window.kpiCharts.doi = createKpiChart('chartDoI', 'Days of Inventory', 'doi', '#8b5cf6', isDark, false);
            window.kpiCharts.classA = createKpiChart('chartClassA', 'Class A Stock Out %', 'classA', '#ef4444', isDark, true);
            window.kpiCharts.classADoI = createKpiChart('chartClassADoI', 'Class A DOI', 'classADoI', '#ec4899', isDark, false);
        }

        window.toggleTimeframe = function(timeframe) {
            const dataContainer = document.getElementById('chartDataContainer');
            const kpiYtd = JSON.parse(dataContainer.getAttribute('data-kpi-ytd'));
            const kpiWeekly = JSON.parse(dataContainer.getAttribute('data-kpi-weekly'));
            
            window.currentKpiData = timeframe === 'weekly' ? kpiWeekly : kpiYtd;
            
            const updateChartData = (chartObj, dataKey) => {
                if(chartObj) {
                    const dataArr = getSafeData(dataKey);

                    chartObj.data.labels = window.currentKpiData.labels || [];
                    chartObj.data.datasets[0].data = dataArr;
                    
                    const validData = dataArr.filter(v => v !== null && v !== undefined && !isNaN(v)).map(Number);
                    const maxVal = validData.length ? Math.max(...validData) : 0;
                    chartObj.options.scales.y.suggestedMax = maxVal + (maxVal * 0.15) || 1;
                    
                    chartObj.update();
                }
            };

            updateChartData(window.kpiCharts.afterPO, 'afterPO');
            updateChartData(window.kpiCharts.beforePO, 'beforePO');
            updateChartData(window.kpiCharts.perBranch, 'perBranch');
            updateChartData(window.kpiCharts.doi, 'doi');
            updateChartData(window.kpiCharts.classA, 'classA');
            updateChartData(window.kpiCharts.classADoI, 'classADoI');
        };

        function updateChartTheme(isDark) {
            initChart(isDark);
        }

        // Run instantiation on initial load
        const initialDarkState = localStorage.getItem('theme') === 'dark' || 
                                 (!localStorage.getItem('theme') && document.documentElement.classList.contains('dark'));
        initChart(initialDarkState);
    </script>
</body>
</html>