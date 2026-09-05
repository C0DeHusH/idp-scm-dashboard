<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\InventoryDataImport;

class ImportController extends Controller
{
    public function index()
    {
        return view('admin.import');
    }

    public function store(Request $request)
    {
        $request->validate([
            'import_file' => 'required|mimes:csv,txt,xlsx'
        ]);

        Excel::import(new InventoryDataImport, $request->file('import_file'));

        return redirect()->route('admin.import')->with('success', 'Network inventory data updated successfully.');
    }
}