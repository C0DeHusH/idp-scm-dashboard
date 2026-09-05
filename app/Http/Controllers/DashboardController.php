<?php

namespace App\Http\Controllers;

use App\Models\InventoryRecord;
use App\Models\KpiRecord; // Added for dynamic KPI importing
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $areaFilter = $request->input('area', 'All');
        $branchFilter = $request->input('branch', 'All');

        // Base queries
        $query = InventoryRecord::query();
        if ($areaFilter !== 'All') {
            $query->where('area', $areaFilter);
        }
        if ($branchFilter !== 'All') {
            $query->where('branch', $branchFilter);
        }

        // Action Lists based on filtered query
        $classA = (clone $query)->where('pareto_class', 'Class A')->get();
        $classB = (clone $query)->where('pareto_class', 'Class B')->get();
        $classC = (clone $query)->where('pareto_class', 'Class C')->get();

        // Helper rate calculation closure
        $calcRate = function($collection) {
            $total = $collection->count();
            if ($total === 0) return 0;
            $stockouts = $collection->where('stock_status', 'Stockout')->count();
            return round(($stockouts / $total) * 100, 2);
        };

        // --- 1. AREA-LEVEL METRICS ---
        $areaQuery = InventoryRecord::query();
        if ($areaFilter !== 'All') {
            $areaQuery->where('area', $areaFilter);
        }
        $areaClassA = (clone $areaQuery)->where('pareto_class', 'Class A')->get();
        $areaClassB = (clone $areaQuery)->where('pareto_class', 'Class B')->get();
        $areaClassC = (clone $areaQuery)->where('pareto_class', 'Class C')->get();

        $areaRateA = $calcRate($areaClassA);
        $areaRateB = $calcRate($areaClassB);
        $areaRateC = $calcRate($areaClassC);
        $areaAverageRate = round(($areaRateA + $areaRateB + $areaRateC) / 3, 2);


        // --- 2. BRANCH-LEVEL METRICS ---
        $branchRateA = 0; $branchRateB = 0; $branchRateC = 0; $branchAverageRate = 0;
        if ($branchFilter !== 'All') {
            $branchClassA = InventoryRecord::where('branch', $branchFilter)->where('pareto_class', 'Class A')->get();
            $branchClassB = InventoryRecord::where('branch', $branchFilter)->where('pareto_class', 'Class B')->get();
            $branchClassC = InventoryRecord::where('branch', $branchFilter)->where('pareto_class', 'Class C')->get();

            $branchRateA = $calcRate($branchClassA);
            $branchRateB = $calcRate($branchClassB);
            $branchRateC = $calcRate($branchClassC);
            $branchAverageRate = round(($branchRateA + $branchRateB + $branchRateC) / 3, 2);
        } else {
            $branchRateA = $areaRateA;
            $branchRateB = $areaRateB;
            $branchRateC = $areaRateC;
            $branchAverageRate = $areaAverageRate;
        }

        // Executive Matrix for Chart
        $stockOutRates = InventoryRecord::select('area', 'pareto_class', 
            DB::raw('SUM(CASE WHEN stock_status = "Stockout" THEN 1 ELSE 0 END) as stockouts'),
            DB::raw('COUNT(*) as total'))
            ->groupBy('area', 'pareto_class')
            ->get();

        $areas = InventoryRecord::select('area')->distinct()->pluck('area');
        $branches = InventoryRecord::select('branch')->distinct()->pluck('branch');


        // --- 3. DYNAMIC KPI LINE GRAPH DATA ---
        // Fetch data mapped from the KpiSheetsImport logic
        $ytdRecords = KpiRecord::where('type', 'YTD')->orderBy('id')->get();
        $weeklyRecords = KpiRecord::where('type', 'Weekly')->orderBy('id')->get();

        $kpiYtd = [
            'labels'    => $ytdRecords->pluck('period')->toArray(),
            'afterPO'   => $ytdRecords->pluck('after_po_oos')->toArray(),
            'perBranch' => $ytdRecords->pluck('per_branch_oos')->toArray(),
            'beforePO'  => $ytdRecords->pluck('before_po_oos')->toArray(),
            'doi'       => $ytdRecords->pluck('doi')->toArray(),
            'classA'    => $ytdRecords->pluck('class_a_oos')->toArray(),
        ];

        $kpiWeekly = [
            'labels'    => $weeklyRecords->pluck('period')->toArray(),
            'afterPO'   => $weeklyRecords->pluck('after_po_oos')->toArray(),
            'perBranch' => $weeklyRecords->pluck('per_branch_oos')->toArray(),
            'beforePO'  => $weeklyRecords->pluck('before_po_oos')->toArray(),
            'doi'       => $weeklyRecords->pluck('doi')->toArray(),
            'classA'    => $weeklyRecords->pluck('class_a_oos')->toArray(),
        ];

        // --- FALLBACK MECHANISM ---
        // Prevents blank charts on initial load before the first Excel file is imported
        if (empty($kpiYtd['labels'])) {
            $kpiYtd = [
                'labels'    => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'],
                'afterPO'   => [24.10, 12.97, 12.19, 13.41, 12.14, 9.78, 5.78, 4.44],
                'perBranch' => [28.47, 34.12, 28.12, 29.24, 30.81, 35.97, 34.45, 32.08],
                'beforePO'  => [35.03, 36.08, 28.31, 26.47, 35.20, 45.10, 40.65, 25.45],
                'doi'       => [139.0, 95.31, 98.74, 104.79, 85.43, 82.95, 89.55, 92.00],
                'classA'    => [33.33, 9.09, 0, 0, 0, 0, 0, 0]
            ];
        }

        if (empty($kpiWeekly['labels'])) {
            $kpiWeekly = [
                'labels'    => ['08/10', '08/17', '08/24', '08/31'],
                'afterPO'   => [4.52, 4.05, 3.57, 4.44],
                'perBranch' => [36.44, 33.66, 33.37, 32.08],
                'beforePO'  => [33.28, 28.62, 26.96, 25.45],
                'doi'       => [93.34, 92.71, 104.10, 92.00],
                'classA'    => [0, 0, 0, 0]
            ];
        }

        return view('dashboard.unified', compact(
            'classA', 'classB', 'classC', 'areas', 'branches', 
            'areaFilter', 'branchFilter', 'stockOutRates',
            'areaRateA', 'areaRateB', 'areaRateC', 'areaAverageRate',
            'branchRateA', 'branchRateB', 'branchRateC', 'branchAverageRate',
            'kpiYtd', 'kpiWeekly'
        ));
    }
}