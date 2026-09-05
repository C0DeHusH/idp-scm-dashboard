<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\Import; // 1. Add this new use statement

// 2. Add the Import interface to the implements list
class KpiSheetsImport implements WithMultipleSheets, Import 
{
    public function sheets(): array
    {
        return [
            // Ensure these keys match your Excel sheet names verbatim
            'KPI_YTD_Input'    => new KpiDataImport('YTD'),
            'KPI_WEEKLY_Input' => new KpiDataImport('Weekly'),
        ];
    }
}