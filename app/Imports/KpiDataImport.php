<?php

namespace App\Imports;

use App\Models\KpiRecord;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class KpiDataImport implements ToCollection
{
    protected $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    // 1. Updated signature to perfectly match the interface requirement
    public function collection(Collection $collection): void
    {
        // Wipe existing records of this type to allow a clean overwrite during re-imports
        KpiRecord::where('type', $this->type)->delete();

        $periods = [];
        $metrics = [
            'after_po' => [], 'per_branch' => [], 'before_po' => [], 'class_a' => [], 'doi' => []
        ];

        // 2. Updated variable name to $collection
        foreach ($collection as $index => $row) {
            $firstCell = strtolower(trim((string)($row[0] ?? '')));
            
            // Detect transposed headers (where dates are arrayed horizontally starting at column 2)
            if (empty($firstCell) && !empty($row[2])) {
                foreach ($row as $colIndex => $cell) {
                    if ($colIndex >= 2 && !empty($cell)) {
                        $periods[$colIndex] = $this->formatDate($cell);
                    }
                }
            } 
            // Map the rows to metric categories
            elseif (str_contains($firstCell, 'after po')) {
                $metrics['after_po'] = $this->extractRowData($row);
            } elseif (str_contains($firstCell, 'per-branch') || str_contains($firstCell, 'per branch')) {
                $metrics['per_branch'] = $this->extractRowData($row);
            } elseif (str_contains($firstCell, 'before po')) {
                $metrics['before_po'] = $this->extractRowData($row);
            } elseif (str_contains($firstCell, 'class a')) {
                $metrics['class_a'] = $this->extractRowData($row);
            } elseif (str_contains($firstCell, 'doi') || str_contains($firstCell, 'days of inventory')) {
                $metrics['doi'] = $this->extractRowData($row, false);
            }
        }

        // Commit parsed mapped data to the database
        if (!empty($periods)) {
            foreach ($periods as $colIndex => $period) {
                KpiRecord::create([
                    'type'           => $this->type,
                    'period'         => $period,
                    'after_po_oos'   => $metrics['after_po'][$colIndex] ?? 0,
                    'per_branch_oos' => $metrics['per_branch'][$colIndex] ?? 0,
                    'before_po_oos'  => $metrics['before_po'][$colIndex] ?? 0,
                    'class_a_oos'    => $metrics['class_a'][$colIndex] ?? 0,
                    'doi'            => $metrics['doi'][$colIndex] ?? 0,
                ]);
            }
        }
    }

    private function extractRowData($row, $asPercent = true)
    {
        $data = [];
        foreach ($row as $colIndex => $val) {
            if ($colIndex >= 2) {
                $num = is_numeric($val) ? (float)$val : 0;
                $data[$colIndex] = $asPercent ? $this->formatPercent($num) : round($num, 2);
            }
        }
        return $data;
    }

    private function formatPercent($num)
    {
        // Convert trailing decimals (e.g. 0.24) to whole percentages (24.00)
        return ($num > 0 && $num <= 1) ? round($num * 100, 2) : round($num, 2);
    }

    private function formatDate($cell)
    {
        if (is_numeric($cell)) {
            return Date::excelToDateTimeObject($cell)->format($this->type === 'YTD' ? 'M' : 'm/d');
        }
        return (string)$cell;
    }
}