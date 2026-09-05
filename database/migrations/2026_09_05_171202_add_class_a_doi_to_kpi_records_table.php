<?php

namespace App\Imports;

use App\Models\KpiRecord;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class KpiDataImport implements ToCollection, WithCalculatedFormulas
{
    protected $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function collection(Collection $collection): void
    {
        // Wipe existing records of this type to allow a clean overwrite
        KpiRecord::where('type', $this->type)->delete();

        $periods = [];
        $currentSection = '';
        $metrics = [
            'after_po'    => [], 
            'per_branch'  => [], 
            'before_po'   => [], 
            'class_a'     => [], 
            'doi'         => [],
            'class_a_doi' => []
        ];

        foreach ($collection as $index => $row) {
            $rawCell0 = (string)($row[0] ?? '');
            $firstCell = strtolower(trim($rawCell0));

            // Track active section header context
            if (str_contains($firstCell, 'stock outrate') || str_contains($firstCell, 'doi') || str_contains($firstCell, 'stock out rate')) {
                $currentSection = $firstCell;
            }

            // Detect timeline rows and ensure the calculated value isn't an empty string
            if ((empty($firstCell) || in_array($firstCell, ['month', 'date', 'period', 'week', 'timeline', 'label'])) && !empty($row[2]) && trim((string)$row[2]) !== '') {
                foreach ($row as $colIndex => $cell) {
                    if ($colIndex >= 2 && !empty($cell) && trim((string)$cell) !== '') {
                        $periods[$colIndex] = $this->formatDate($cell);
                    }
                }
            } 
            // Map rows precisely - Increased strlen limit to < 100 to allow long headers like "(Before PO Balance)"
            elseif ((str_contains($firstCell, 'per branch class a') || str_contains($firstCell, 'class a stock out rate') || str_contains($firstCell, 'class a stock out %')) && strlen($firstCell) < 100) {
                $metrics['class_a'] = $this->extractRowData($row);
            } elseif ((str_contains($firstCell, 'mc class a doi') || (str_contains($firstCell, 'class a') && str_contains($firstCell, 'doi'))) && strlen($firstCell) < 100) {
                $metrics['class_a_doi'] = $this->extractRowData($row, false);
            } elseif (str_contains($firstCell, 'after po') && strlen($firstCell) < 100) {
                $metrics['after_po'] = $this->extractRowData($row);
            } elseif ((str_contains($firstCell, 'per-branch') || str_contains($firstCell, 'per branch')) && strlen($firstCell) < 100) {
                $metrics['per_branch'] = $this->extractRowData($row);
            } elseif (str_contains($firstCell, 'before po') && strlen($firstCell) < 100) {
                $metrics['before_po'] = $this->extractRowData($row);
            } elseif ((str_contains($firstCell, 'doi') || str_contains($firstCell, 'days of inventory')) && !str_contains($firstCell, 'class a') && strlen($firstCell) < 100) {
                $metrics['doi'] = $this->extractRowData($row, false);
            }
        }

        // Commit parsed mapped data to the database
        if (!empty($periods)) {
            foreach ($periods as $colIndex => $period) {
                // Skip if the date formula resolved to an empty string
                if (trim($period) === '') continue;

                KpiRecord::create([
                    'type'           => $this->type,
                    'period'         => $period,
                    'after_po_oos'   => $metrics['after_po'][$colIndex] ?? 0,
                    'per_branch_oos' => $metrics['per_branch'][$colIndex] ?? 0,
                    'before_po_oos'  => $metrics['before_po'][$colIndex] ?? 0,
                    'class_a_oos'    => $metrics['class_a'][$colIndex] ?? 0,
                    'doi'            => $metrics['doi'][$colIndex] ?? 0,
                    'class_a_doi'    => $metrics['class_a_doi'][$colIndex] ?? 0, 
                ]);
            }
        }
    }

    private function extractRowData($row, $asPercent = true)
    {
        $data = [];
        foreach ($row as $colIndex => $val) {
            // Ensure we aren't trying to parse formula blank spaces
            if ($colIndex >= 2 && $val !== null && trim((string)$val) !== '') {
                $num = is_numeric($val) ? (float)$val : 0;
                $data[$colIndex] = $asPercent ? $this->formatPercent($num) : round($num, 2);
            }
        }
        return $data;
    }

    private function formatPercent($num)
    {
        return ($num > 0 && $num <= 1) ? round($num * 100, 2) : round($num, 2);
    }

    private function formatDate($cell)
    {
        // Catch string formulas that resolved to empty
        if (trim((string)$cell) === '') {
            return '';
        }

        if (is_numeric($cell)) {
            try {
                return Date::excelToDateTimeObject($cell)->format($this->type === 'YTD' ? 'M' : 'm/d');
            } catch (\Exception $e) {
                return (string)$cell;
            }
        }
        return (string)$cell;
    }
}