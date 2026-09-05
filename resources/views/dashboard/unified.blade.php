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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 font-sans antialiased transition-colors duration-200">
    <div class="w-full mx-auto py-8 px-6 sm:px-8 lg:px-12">
        
        <!-- Header & Auth Controls -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4 border-b border-gray-200 dark:border-gray-800 pb-6">
            <div>
                <h1 class="text-3xl font-extrabold tracking-tight">IDP SCM Executive Control Tower</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Real-time inventory visibility, Pareto classifications, and network stockout analytics.</p>
            </div>
            <div class="flex items-center gap-3">
                <!-- Dark/Light Mode Toggle Button -->
                <button onclick="toggleDarkMode()" class="bg-gray-200 dark:bg-gray-800 hover:bg-gray-300 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 font-medium p-2.5 rounded-lg shadow-sm transition flex items-center justify-center w-10 h-10" title="Toggle Theme">
                    <svg id="theme-icon-sun" class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    <svg id="theme-icon-moon" class="w-5 h-5 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                </button>

                @auth
                    <a href="{{ route('admin.import') }}" class="bg-indigo-600 hover:bg-indigo-500 text-white font-semibold px-5 py-2.5 rounded-lg shadow-md transition duration-150 ease-in-out inline-flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        Data Management
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline font-medium text-sm">Admin Login</a>
                @endauth
            </div>
        </div>

        <!-- Filters Form with Dependent Cascading Dropdowns (Fixed Route Closing Parenthesis) -->
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
            
            <div class="flex items-center gap-2">
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
                    <span class="text-xs text-gray-500 dark:text-gray-400 mt-1 block">(Area A+B+C) / 3 Formula</span>
                </div>
            </div>
        </div>

        <!-- WIDGET SECTION 2: BRANCH STOCK OUT & AVERAGE RATES -->
        <div class="mb-8">
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
                    <span class="text-xs text-gray-500 dark:text-gray-400 mt-1 block">(Branch A+B+C) / 3 Formula</span>
                </div>
            </div>
        </div>

        <!-- Chart and Watchlist Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Stock Out Rate Chart -->
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 shadow-xl rounded-xl p-6 flex flex-col">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Stock Out Rate by Area</h2>
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

    <!-- Script Suite: Theme Toggle & Cascading Dependent Dropdown & Chart -->
    <script>
        // 1. Theme Toggle Logic with LocalStorage persistence
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

        if (localStorage.getItem('theme') === 'light') {
            document.documentElement.classList.remove('dark');
        }

        // 2. Cascading Dependent Branch Filtering Logic
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

        window.addEventListener('DOMContentLoaded', () => {
            filterBranches();
        });

        function handleAreaChange() {
            document.getElementById('branchSelect').value = 'All';
            filterBranches();
            document.getElementById('areaSelect').form.submit();
        }

        // 3. Chart Initialization & Theme Synchronization
        const ctx = document.getElementById('stockoutChart').getContext('2d');
        const chartData = {!! json_encode($stockOutRates) !!};
        
        const labels = [...new Set(chartData.map(d => d.area))];
        const classAData = labels.map(label => {
            const record = chartData.find(d => d.area === label && d.pareto_class === 'Class A');
            return record ? (record.stockouts / record.total) * 100 : 0;
        });

        let stockoutChart;

        function initChart(isDark) {
            if (stockoutChart) stockoutChart.destroy();

            Chart.defaults.color = isDark ? '#9ca3af' : '#4b5563';
            Chart.defaults.borderColor = isDark ? '#374151' : '#e5e7eb';

            stockoutChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Class A Stockout %',
                        data: classAData,
                        backgroundColor: 'rgba(239, 68, 68, 0.8)',
                        borderColor: 'rgba(239, 68, 68, 1)',
                        borderWidth: 1,
                        borderRadius: 4
                    }]
                },
                options: { 
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: isDark ? '#374151' : '#e5e7eb' }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        }

        function updateChartTheme(isDark) {
            initChart(isDark);
        }

        initChart(document.documentElement.classList.contains('dark'));
    </script>
</body>
</html>