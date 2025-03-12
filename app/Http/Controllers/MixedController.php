<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Member;
use App\Models\Package;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class MixedController extends Controller
{
    public function fetchAllCounts()
{
    $currentDate = Carbon::now();
    $getData = function ($interval, $count, $type) use ($currentDate) {
        $labels = [];
        $members = [];
        $invoices = [];
        $paidMembers = [];

        for ($i = $count - 1; $i >= 0; $i--) {
            $startDate = $currentDate->copy()->sub($interval, $i);
            $endDate = $currentDate->copy()->sub($interval, $i - 1);

            if ($type === 'daily') {
                $startDate = $startDate->startOfDay(); 
                $endDate = $startDate->copy()->endOfDay(); 
                $labels["label_" . ($count - $i)] = $startDate->format('D'); 
            } elseif ($type === 'weekly') {
                $labels["label_" . ($count - $i)] = "Week " . ($count - $i);
            } else { // Monthly
                $labels["label_" . ($count - $i)] = $startDate->format('M Y'); 
            }

            $members["member_" . ($count - $i)] = Member::whereBetween('created_at', [$startDate, $endDate])->count();
            $invoices["invoice_" . ($count - $i)] = Invoice::whereBetween('created_at', [$startDate, $endDate])->count();
            $paidMembers["paid_member_" . ($count - $i)] = Invoice::whereBetween('created_at', [$startDate, $endDate])
                ->where('paid', true)
                ->distinct('member_id')
                ->count('member_id');
        }

        return [
            'labels' => $labels,
            'members' => $members,
            'invoices' => $invoices,
            'paid_members' => $paidMembers,
        ];
    };

    $dailyData = $getData('days', 7, 'daily');
    $weeklyData = $getData('weeks', 6, 'weekly');
    $monthlyData = $getData('months', 6, 'monthly');

    return response()->json([
        'success' => true,
        'message' => 'Totals retrieved successful',
        'data' => [
            'members' => Member::count(),
            'invoices' => Invoice::count(),
            'paid_members' => Invoice::where('paid', true)->distinct('member_id')->count('member_id'), 
            'packages' => Package::distinct()->count('name'),
            'discounts' => Invoice::where('discount_percentage', '>', 0)->count(),
            'daily' => $dailyData,
            'weekly' => $weeklyData,
            'monthly' => $monthlyData,
        ],
    ]);
}

}
