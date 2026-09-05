<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\InventoryDataImport;
use App\Imports\KpiSheetsImport;

class ImportController extends Controller
{
    public function index()
    {
        return view('admin.import');
    }

    public function store(Request $request)
    {
        $request->validate([
            'inventory_file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            // 1. Process standard inventory tab
            Excel::import(new InventoryDataImport, $request->file('inventory_file'));

            // 2. Process KPI YTD and Weekly Data tabs
            Excel::import(new KpiSheetsImport, $request->file('inventory_file'));

            return redirect()->route('dashboard.unified')
                ->with('success', 'Inventory and Executive KPI data successfully imported.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error parsing file: ' . $e->getMessage());
        }
    }
}