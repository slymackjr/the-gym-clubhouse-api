<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportExport;
use Barryvdh\DomPDF\Facade\Pdf;
use ConsoleTVs\Charts\Classes\Highcharts\Chart;

class ReportController extends Controller
{
    public function getMonthlyReports(Request $request)
    {
        $year = $request->input('year', Carbon::now()->year);

        $months = collect([
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 
            6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 
            11 => 'November', 12 => 'December'
        ]);

        $membersData = Member::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        $membersPerMonth = $months->map(function ($monthName, $monthNumber) use ($membersData) {
            return [
                'month' => $monthName,
                'total' => $membersData[$monthNumber]->total ?? 0,
            ];
        });
        $paidData = Invoice::selectRaw('MONTH(created_at) as month, COUNT(DISTINCT member_id) as total')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        $paidPerMonth = $months->map(function ($monthName, $monthNumber) use ($paidData) {
            return [
                'month' => $monthName,
                'total' => $paidData[$monthNumber]->total ?? 0,
            ];
        });

        $invoicesData = Invoice::selectRaw('MONTH(created_at) as month, SUM(amount_paid) as total')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        $invoicesPerMonth = $months->map(function ($monthName, $monthNumber) use ($invoicesData) {
            return [
                'month' => $monthName,
                'total' => $invoicesData[$monthNumber]->total ?? 0,
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Report retrieved successfully',
            'data' => [
                'year' => $year,
                'members' => $membersPerMonth->values(),
                'paid' => $paidPerMonth->values(),
                'invoices' => $invoicesPerMonth->values(),
            ],
        ]);
    }

    public function downloadReport(Request $request)
    {
        $year = $request->input('year', Carbon::now()->year);

        $months = collect([
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 
            6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 
            11 => 'November', 12 => 'December'
        ]);

        $membersData = Invoice::selectRaw('MONTH(created_at) as month, COUNT(DISTINCT member_id) as total')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        $membersPerMonth = $months->map(function ($monthName, $monthNumber) use ($membersData) {
            return [
                'month' => $monthName,
                'total' => $membersData[$monthNumber]->total ?? 0,
            ];
        });

        $invoicesData = Invoice::selectRaw('MONTH(created_at) as month, SUM(amount_paid) as total')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        $invoicesPerMonth = $months->map(function ($monthName, $monthNumber) use ($invoicesData) {
            return [
                'month' => $monthName,
                'total' => $invoicesData[$monthNumber]->total ?? 0,
            ];
        });

        $data = [
            'year' => $year,
            'members' => $membersPerMonth->values()->toArray(),
            'invoices' => $invoicesPerMonth->values()->toArray(),
        ];

        return Excel::download(new ReportExport($data), "monthly_report_{$year}.xlsx");
    }

    public function downloadChartReport(Request $request)
{
    $year = $request->input('year', Carbon::now()->year);


    $months = collect([
        1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 
        6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 
        11 => 'November', 12 => 'December'
    ]);

   
    $membersData = Invoice::selectRaw('MONTH(created_at) as month, COUNT(DISTINCT member_id) as total')
        ->whereYear('created_at', $year)
        ->groupBy('month')
        ->orderBy('month')
        ->get()
        ->keyBy('month');

    $membersPerMonth = $months->map(function ($monthName, $monthNumber) use ($membersData) {
        return $membersData[$monthNumber]->total ?? 0;
    });

    $invoicesData = Invoice::selectRaw('MONTH(created_at) as month, SUM(amount_paid) as total')
        ->whereYear('created_at', $year)
        ->groupBy('month')
        ->orderBy('month')
        ->get()
        ->keyBy('month');

    $invoicesPerMonth = $months->map(function ($monthName, $monthNumber) use ($invoicesData) {
        return $invoicesData[$monthNumber]->total ?? 0;
    });

    $chart = new Chart();
    $chart->title("4JS FITNESS CENTER STATISTICS FOR THE YEAR {$year}")
          ->labels($months->values()->toArray());
    
    $chart->dataset('New Members', 'line', $membersPerMonth->values()->toArray())
          ->color('#FF5733'); 

    $chart->dataset('Invoices Paid', 'line', $invoicesPerMonth->values()->toArray())
          ->color('#33FF57'); 

    $chartHtml = view('charts.chart-pdf', compact('chart'))->render();

    $pdf = Pdf::loadHTML($chartHtml);

    return $pdf->download("4JS_FITNESS_CENTER_Statistics_{$year}.pdf");
}

}
