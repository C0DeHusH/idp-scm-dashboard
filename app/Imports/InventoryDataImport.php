<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\Import; // <-- 1. Add this

// 2. Add 'Import' to the implements list
class InventoryDataImport implements WithMultipleSheets, Import 
{
    public function sheets(): array
    {
        return [
            // Targets only the specific sheet containing our database rows
            'Raw_Data' => new RawDataSheetImport(),
        ];
    }
}