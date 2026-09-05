<?php

namespace App\Http\Controllers;

use App\Models\InventoryRecord;
use App\Models\KpiRecord;
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
        if ($areaFilter !== 'All') $query->where('area', $areaFilter);
        if ($branchFilter !== 'All') $query->where('branch', $branchFilter);

        $classA = (clone $query)->where('pareto_class', 'Class A')->get();
        $classB = (clone $query)->where('pareto_class', 'Class B')->get();
        $classC = (clone $query)->where('pareto_class', 'Class C')->get();

        $calcRate = function($collection) {
            $total = $collection->count();
            if ($total === 0) return 0;
            $stockouts = $collection->where('stock_status', 'Stockout')->count();
            return round(($stockouts / $total) * 100, 2);
        };

        // --- 1. AREA-LEVEL METRICS ---
        $areaQuery = InventoryRecord::query();
        if ($areaFilter !== 'All') $areaQuery->where('area', $areaFilter);
        
        $areaRateA = $calcRate((clone $areaQuery)->where('pareto_class', 'Class A')->get());
        $areaRateB = $calcRate((clone $areaQuery)->where('pareto_class', 'Class B')->get());
        $areaRateC = $calcRate((clone $areaQuery)->where('pareto_class', 'Class C')->get());
        $areaAverageRate = round(($areaRateA + $areaRateB + $areaRateC) / 3, 2);

        // --- 2. BRANCH-LEVEL METRICS ---
        if ($branchFilter !== 'All') {
            $branchRateA = $calcRate(InventoryRecord::where('branch', $branchFilter)->where('pareto_class', 'Class A')->get());
            $branchRateB = $calcRate(InventoryRecord::where('branch', $branchFilter)->where('pareto_class', 'Class B')->get());
            $branchRateC = $calcRate(InventoryRecord::where('branch', $branchFilter)->where('pareto_class', 'Class C')->get());
            $branchAverageRate = round(($branchRateA + $branchRateB + $branchRateC) / 3, 2);
        } else {
            $branchRateA = $areaRateA; $branchRateB = $areaRateB; $branchRateC = $areaRateC; $branchAverageRate = $areaAverageRate;
        }

        $stockOutRates = InventoryRecord::select('area', 'pareto_class', 
             DB::raw('SUM(CASE WHEN stock_status = "Stockout" THEN 1 ELSE 0 END) as stockouts'),
            DB::raw('COUNT(*) as total'))->groupBy('area', 'pareto_class')->get();

        $areas = InventoryRecord::select('area')->distinct()->pluck('area');
        $branches = InventoryRecord::select('branch')->distinct()->pluck('branch');

        // --- 3. DYNAMIC KPI LINE GRAPH DATA ---
        $ytdRecords = KpiRecord::where('type', 'YTD')->orderBy('id')->get();
        $weeklyRecords = KpiRecord::where('type', 'Weekly')->orderBy('id')->get();

        $kpiYtd = [
            'labels'    => $ytdRecords->pluck('period')->toArray(),
            'afterPO'   => $ytdRecords->pluck('after_po_oos')->toArray(),
            'perBranch' => $ytdRecords->pluck('per_branch_oos')->toArray(),
            'beforePO'  => $ytdRecords->pluck('before_po_oos')->toArray(),
            'doi'       => $ytdRecords->pluck('doi')->toArray(),
            'classA'    => $ytdRecords->pluck('class_a_oos')->toArray(),
            'classADoI' => $ytdRecords->pluck('class_a_doi')->toArray(),
        ];

        $kpiWeekly = [
            'labels'    => $weeklyRecords->pluck('period')->toArray(),
            'afterPO'   => $weeklyRecords->pluck('after_po_oos')->toArray(),
            'perBranch' => $weeklyRecords->pluck('per_branch_oos')->toArray(),
            'beforePO'  => $weeklyRecords->pluck('before_po_oos')->toArray(),
            'doi'       => $weeklyRecords->pluck('doi')->toArray(),
            'classA'    => $weeklyRecords->pluck('class_a_oos')->toArray(),
            'classADoI' => $weeklyRecords->pluck('class_a_doi')->toArray(),
        ];

        // The hardcoded fallback array has been completely removed so it stops overriding your real data.

        return view('dashboard.unified', compact(
            'classA', 'classB', 'classC', 'areas', 'branches', 
            'areaFilter', 'branchFilter', 'stockOutRates',
            'areaRateA', 'areaRateB', 'areaRateC', 'areaAverageRate',
            'branchRateA', 'branchRateB', 'branchRateC', 'branchAverageRate',
            'kpiYtd', 'kpiWeekly'
        ));
    }
}