<?php

namespace App\Http\Controllers;

use App\Models\InventoryRecord;
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

        // --- 1. AREA-LEVEL METRICS (Calculated across the selected Area) ---
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


        // --- 2. BRANCH-LEVEL METRICS (Calculated for the specific selected Branch) ---
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
            // If no single branch is selected, fall back to overall or area metrics
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

        return view('dashboard.unified', compact(
            'classA', 'classB', 'classC', 'areas', 'branches', 
            'areaFilter', 'branchFilter', 'stockOutRates',
            'areaRateA', 'areaRateB', 'areaRateC', 'areaAverageRate',
            'branchRateA', 'branchRateB', 'branchRateC', 'branchAverageRate'
        ));
    }
}