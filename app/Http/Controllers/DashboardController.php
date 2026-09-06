<?php

namespace App\Http\Controllers;

use App\Models\InventoryRecord;
use App\Models\KpiRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpPresentation\PhpPresentation;
use PhpOffice\PhpPresentation\IOFactory;
use PhpOffice\PhpPresentation\Style\Alignment;
use PhpOffice\PhpPresentation\Style\Color;
use PhpOffice\PhpPresentation\Style\Border;

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

        return view('dashboard.unified', compact(
            'classA', 'classB', 'classC', 'areas', 'branches', 
            'areaFilter', 'branchFilter', 'stockOutRates',
            'areaRateA', 'areaRateB', 'areaRateC', 'areaAverageRate',
            'branchRateA', 'branchRateB', 'branchRateC', 'branchAverageRate',
            'kpiYtd', 'kpiWeekly'
        ));
    }

    // --- PDF EXPORT ---
    public function exportPdf()
    {
        // Retrieve your specific motorcycle or spare parts data
        $records = InventoryRecord::limit(100)->get();

        // Load a Blade view and pass the data
        $pdf = Pdf::loadView('exports.inventory_pdf', compact('records'));
        
        return $pdf->download('Koronadal_Warehouse_Inventory.pdf');
    }

// --- POWERPOINT EXPORT ---
    public function exportPptx()
    {
        $presentation = new PhpPresentation();
        
        // --- SLIDE 1: TITLE SLIDE ---
        $slide1 = $presentation->getActiveSlide();
        $titleShape = $slide1->createRichTextShape()
            ->setHeight(100)->setWidth(800)
            ->setOffsetX(80)->setOffsetY(250);
        $titleShape->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $titleShape->createTextRun('Koronadal Central Warehouse')
            ->getFont()->setBold(true)->setSize(36);
            
        $subTitleShape = $slide1->createRichTextShape()
            ->setHeight(50)->setWidth(800)
            ->setOffsetX(80)->setOffsetY(320);
        $subTitleShape->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $subTitleShape->createTextRun('Distribution & KPI Metrics Report')
            ->getFont()->setSize(24)->setColor(new Color('FF555555'));

        // --- SLIDE 2: KPI METRICS TABLE ---
        $slide2 = $presentation->createSlide();
        
        // Slide 2 Title
        $slide2Title = $slide2->createRichTextShape()
            ->setHeight(50)->setWidth(800)
            ->setOffsetX(50)->setOffsetY(30);
        $slide2Title->createTextRun('Key Performance Indicators')
            ->getFont()->setBold(true)->setSize(28);

        // Fetch the latest metrics from the database
        $latestKpi = \App\Models\KpiRecord::latest()->first();
        
        // Map the metrics you want to display
        $metrics = [
            'Class A Days of Inventory (DOI)' => $latestKpi->class_a_doi ?? 'N/A',
            'Motorcycle Unit Allocation (CBM)' => $latestKpi->motorcycle_cbm_vol ?? 'N/A',
            'Spare Parts Fleet Weight (kg)' => $latestKpi->spare_parts_weight ?? 'N/A',
            'Overall Warehouse DOI' => $latestKpi->overall_doi ?? 'N/A',
        ];

        // Create a 2-column Table Shape
        $tableShape = $slide2->createTableShape(2);
        $tableShape->setHeight(300)->setWidth(700)->setOffsetX(130)->setOffsetY(120);

        // Define Table Header Row
        $headerRow = $tableShape->createRow();
        $headerRow->setHeight(40);
        
        // Header Cell 1
        $col1 = $headerRow->nextCell();
        $col1->setWidth(400);
        $col1->getFill()->setFillType(\PhpOffice\PhpPresentation\Style\Fill::FILL_SOLID)
             ->setStartColor(new Color('FF0070C0'));
        $col1->createTextRun('Metric Description')->getFont()->setBold(true)->setColor(new Color('FFFFFFFF'));
        
        // Header Cell 2
        $col2 = $headerRow->nextCell();
        $col2->setWidth(300);
        $col2->getFill()->setFillType(\PhpOffice\PhpPresentation\Style\Fill::FILL_SOLID)
             ->setStartColor(new Color('FF0070C0'));
        $col2->createTextRun('Current Value')->getFont()->setBold(true)->setColor(new Color('FFFFFFFF'));

        // Populate Table Rows with Metrics Data
        foreach ($metrics as $name => $value) {
            $row = $tableShape->createRow();
            $row->setHeight(35);
            
            $cell1 = $row->nextCell();
            $cell1->createTextRun($name)->getFont()->setSize(14);
            $cell1->getBorders()->getBottom()
                  ->setLineStyle(Border::LINE_SINGLE)
                  ->setColor(new Color('FFCCCCCC'));
            
            $cell2 = $row->nextCell();
            $cell2->createTextRun((string) $value)->getFont()->setSize(14);
            $cell2->getBorders()->getBottom()
                  ->setLineStyle(Border::LINE_SINGLE)
                  ->setColor(new Color('FFCCCCCC'));
        }

        // --- SAVE AND EXPORT ---
        $writer = IOFactory::createWriter($presentation, 'PowerPoint2007');
        $fileName = 'KPI_Metrics_Export_' . date('Y_m_d') . '.pptx';
        $tempFile = tempnam(sys_get_temp_dir(), 'pptx');
        $writer->save($tempFile);

        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }
}