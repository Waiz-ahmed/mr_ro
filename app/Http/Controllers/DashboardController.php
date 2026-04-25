<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DailySale;
use App\Models\Expense;
use App\Models\CreditCustomer;
use App\Models\Payment;
use App\Models\Customer;
use App\Models\Vendor;
use App\Models\Shop;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $shopIds = $user->shops()->pluck('id'); // shops owned by this user

        if ($shopIds->isEmpty()) {
            return view('dashboard', $this->emptyDashboardData());
        }

        $today = Carbon::today();
        $weekAgo = Carbon::today()->subDays(7);
        $startOfMonth = Carbon::now()->startOfMonth();

        // Sales (only finalized)
        $salesToday = DailySale::where('status', 'finalized')
            ->whereIn('shop_id', $shopIds)
            ->whereDate('sale_date', $today)
            ->sum('total_amount');

        $salesWeek = DailySale::where('status', 'finalized')
            ->whereIn('shop_id', $shopIds)
            ->whereDate('sale_date', '>=', $weekAgo)
            ->sum('total_amount');

        $salesMonth = DailySale::where('status', 'finalized')
            ->whereIn('shop_id', $shopIds)
            ->whereDate('sale_date', '>=', $startOfMonth)
            ->sum('total_amount');

        // Expenses
        $expensesToday = Expense::whereIn('shop_id', $shopIds)
            ->whereDate('expense_date', $today)
            ->sum('amount');

        $expensesWeek = Expense::whereIn('shop_id', $shopIds)
            ->whereDate('expense_date', '>=', $weekAgo)
            ->sum('amount');

        $expensesMonth = Expense::whereIn('shop_id', $shopIds)
            ->whereDate('expense_date', '>=', $startOfMonth)
            ->sum('amount');

        $netProfitToday = $salesToday - $expensesToday;

        // Outstanding credit (sum of balances where related shop belongs to user)
        $outstandingCredit = CreditCustomer::whereHas('dailySale', function($q) use ($shopIds) {
                $q->whereIn('shop_id', $shopIds);
            })->sum('balance');

        $paymentsToday = Payment::whereDate('payment_date', $today)->sum('amount_paid');

        // Count customers that have bought from user's shops
        $customerCount = Customer::whereHas('dailySales', function($q) use ($shopIds) {
                $q->whereIn('shop_id', $shopIds);
            })->count();

        $vendorCount = Vendor::count(); // vendors are global, adjust if needed
        $shopCount = $shopIds->count();

        // Chart: last 7 days sales
        $labels = [];
        $salesData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $labels[] = $date->format('D, M j');
            $dailyTotal = DailySale::where('status', 'finalized')
                ->whereIn('shop_id', $shopIds)
                ->whereDate('sale_date', $date)
                ->sum('total_amount');
            $salesData[] = $dailyTotal;
        }

        // Recent 5 finalized sales
        $recentSales = DailySale::with('customer', 'shop')
            ->where('status', 'finalized')
            ->whereIn('shop_id', $shopIds)
            ->orderBy('sale_date', 'desc')
            ->limit(5)
            ->get();

        return view('home', compact(
            'salesToday', 'salesWeek', 'salesMonth',
            'expensesToday', 'expensesWeek', 'expensesMonth',
            'netProfitToday', 'outstandingCredit', 'paymentsToday',
            'customerCount', 'vendorCount', 'shopCount',
            'labels', 'salesData', 'recentSales'
        ));
    }

    private function emptyDashboardData()
    {
        return [
            'salesToday' => 0, 'salesWeek' => 0, 'salesMonth' => 0,
            'expensesToday' => 0, 'expensesWeek' => 0, 'expensesMonth' => 0,
            'netProfitToday' => 0, 'outstandingCredit' => 0, 'paymentsToday' => 0,
            'customerCount' => 0, 'vendorCount' => 0, 'shopCount' => 0,
            'labels' => [], 'salesData' => [], 'recentSales' => collect(),
        ];
    }
}