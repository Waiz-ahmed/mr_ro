<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DailySale;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Customer;
use Illuminate\Support\Carbon;
use App\Models\CreditCustomer;

class DailySaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $firstShop = \App\Models\Shop::first();

        if (!$firstShop) {
            return redirect()->back()->with('error', 'No shops found.');
        }

        $customers = Customer::all();
        return view('sales.index', [
            'customers' => $customers,
            'shop' => $firstShop
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'quantity' => 'required|integer|min:1',
            'total_amount' => 'required|numeric',
            'customer_id' => 'nullable|exists:customers,id',
            'is_credit' => 'nullable|boolean',
            'shop_id' => 'required|exists:shops,id', // ✅ ADD THIS
        ]);

        $validated['is_credit'] = $request->has('is_credit') ? 1 : 0;

        // ✅ Auto-set the sale_date to today
        $validated['sale_date'] = Carbon::today();
        $validated['month'] = Carbon::now()->format('F');
        $validated['year'] = Carbon::now()->year;
        $validated['status'] = 'draft'; // ✅ Important

        $sale = DailySale::create($validated);

        // Credit logic
        if ($validated['is_credit'] && $validated['customer_id']) {
            CreditCustomer::create([
                'customer_id' => $validated['customer_id'],
                'daily_sale_id' => $sale->id,
                'credit_date' => now(),
                'amount' => $validated['total_amount'],
                'balance' => $validated['total_amount'],
            ]);
        }

        return redirect()->route('shops.pos', $validated['shop_id']);
    }

    public function drafts()
    {
        $today = Carbon::today();

        $draftSales = DailySale::with('customer')
            ->whereDate('sale_date', $today)
            ->where('status', 'draft')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('sales.drafts', compact('draftSales'));
    }

    public function finalize($id)
    {
        $sale = DailySale::findOrFail($id);
        $sale->status = 'finalized';
        $sale->save();

        return redirect()->route('sales.drafts')->with('success', 'Order marked as done.');
    }
    public function finalizeSale($id)
    {
        $sale = DailySale::findOrFail($id);

        // Only allow the status change if it's currently in 'draft'
        if ($sale->status == 'draft') {
            $sale->status = 'finalized';
            $sale->save();

            return redirect()->route('sales.index')->with('success', 'Order has been finalized!');
        }

        return redirect()->route('sales.index')->with('error', 'This order is already finalized.');
    }


    public function allSales(Request $request)
    {
        $query = DailySale::with('shop', 'customer')
            ->orderBy('created_at', 'desc');

        // ✅ Date Filter
        if ($request->from_date && $request->to_date) {
            $query->whereBetween('sale_date', [
                $request->from_date,
                $request->to_date
            ]);
        }

        // ✅ Table Search (searches across multiple columns)
        if ($request->search) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('item', 'LIKE', "%{$searchTerm}%")
                ->orWhere('quantity', 'LIKE', "%{$searchTerm}%")
                ->orWhere('amount', 'LIKE', "%{$searchTerm}%")
                ->orWhere('total_amount', 'LIKE', "%{$searchTerm}%")
                ->orWhere('sale_date', 'LIKE', "%{$searchTerm}%")
                // Wrap relationship queries in nested closures
                ->orWhere(function ($subQuery) use ($searchTerm) {
                    $subQuery->whereHas('customer', function ($customerQuery) use ($searchTerm) {
                        $customerQuery->where('name', 'LIKE', "%{$searchTerm}%");
                    });
                })
                ->orWhere(function ($subQuery) use ($searchTerm) {
                    $subQuery->whereHas('shop', function ($shopQuery) use ($searchTerm) {
                        $shopQuery->where('name', 'LIKE', "%{$searchTerm}%");
                    });
                })
                ->orWhere(function ($subQuery) use ($searchTerm) {
                    $subQuery->whereNull('customer_id')
                            ->whereRaw("LOWER('Walk-in') LIKE ?", ["%".strtolower($searchTerm)."%"]);
                });
            });
        }

        // ✅ Paginate results
        $allSales = $query->paginate(10);

        return view('sales.all', compact('allSales'));
    }





    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function report($type)
    {
        $today = Carbon::today();

        if ($type === 'credit') {
            $creditSales = DailySale::with('customer')
                ->whereDate('sale_date', $today)
                ->where('is_credit', 1)
                ->get();

            $payments = \App\Models\Payment::with('customer')
                ->whereDate('payment_date', $today)
                ->get();

            $pdf = Pdf::loadView('sales.report.credit', [
                'creditSales' => $creditSales,
                'payments' => $payments,
                'date' => $today->format('Y-m-d'),
            ]);

            return $pdf->download('credit_sales_report_' . $today->format('Y_m_d') . '.pdf');
        }

        // Default: Daily Sales (cash + credit)
        $cashSales = DailySale::with('customer')
            ->whereDate('sale_date', $today)
            ->where('is_credit', 0)
            ->get();

        $creditSales = DailySale::with('customer')
            ->whereDate('sale_date', $today)
            ->where('is_credit', 1)
            ->get();

        $payments = \App\Models\Payment::with('customer')
            ->whereDate('payment_date', $today)
            ->get();

        $pdf = Pdf::loadView('sales.report', [
            'cashSales' => $cashSales,
            'creditSales' => $creditSales,
            'payments' => $payments,
            'date' => $today->format('Y-m-d'),
        ]);

        return $pdf->download('daily_sales_report_'.$today->format('Y_m_d').'.pdf');
    }

    public function shopPosPage($shopId)
    {
        if (session('pos_verified_shop') != $shopId) {
            return redirect()->route('shops.cards')
                ->with('pos_require_auth', $shopId);
        }

        $shop       = \App\Models\Shop::findOrFail($shopId);
        $customers  = \App\Models\Customer::all();
        $categories = \App\Models\ProductCategory::with(['templates' => function ($q) {
                            $q->where('status', 'active')->where('sale_ok', 1);
                        }])
                        ->where('status', 'active')
                        ->orderBy('name')
                        ->get();

        // "All" pseudo-category carries every sellable product
        $allProducts = \App\Models\ProductTemplate::where('status', 'active')
                        ->where('sale_ok', 1)
                        ->orderBy('name')
                        ->get();

        return view('sales.index', compact('shop', 'customers', 'categories', 'allProducts'));
    }

    public function pos($shopId)
    {
        $shop       = \App\Models\Shop::findOrFail($shopId);
        $customers  = \App\Models\Customer::all();
        $categories = \App\Models\ProductCategory::with(['templates' => function ($q) {
                            $q->where('status', 'active')->where('sale_ok', 1);
                        }])
                        ->where('status', 'active')
                        ->orderBy('name')
                        ->get();

        $allProducts = \App\Models\ProductTemplate::where('status', 'active')
                        ->where('sale_ok', 1)
                        ->orderBy('name')
                        ->get();

        return view('sales.index', compact('shop', 'customers', 'categories', 'allProducts'));
    }



}
