<?php

namespace App\Imports;

use App\Models\InventoryRecord;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class RawDataSheetImport implements ToModel, WithHeadingRow
{
    public function __construct()
    {
        // Clear old data before importing new batch
        DB::table('inventory_records')->truncate();
    }

    public function model(array $row): Model|array|null
    {
        // Failsafe: Skip the row if 'area' is missing or empty
        if (!isset($row['area']) || empty($row['area'])) {
            return null;
        }

        return new InventoryRecord([
            'area'                => $row['area'],
            'pareto_class'        => $row['class'],
            'branch'              => $row['branch'],
            'model'               => $row['model'],
            'rank'                => $row['rank'] ?? null,
            'stock_status'        => $row['stock_status'],
            'stock_status_count'  => $row['stock_status_count'] ?? 1,
            'remaining_inventory' => $row['remaining_inventory'] ?? 0,
            'suggested_transfer'  => $row['suggested_transfer'] ?? 0,
            'doi'                 => $row['doi'] ?? 0,
        ]);
    }
}