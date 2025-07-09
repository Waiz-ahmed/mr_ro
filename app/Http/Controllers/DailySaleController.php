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

        return redirect()->route('shops.pos', $validated['shop_id'])->with('success', 'Sale recorded successfully!');
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
        if ($type == 'credit') {
            $sales = DailySale::where('is_credit', 1)->get();
        } elseif ($type == 'non-credit') {
            $sales = DailySale::where('is_credit', 0)->get();
        } else {
            $sales = DailySale::all();
        }

        $pdf = PDF::loadView('sales.report', compact('sales', 'type'));
        return $pdf->download("{$type}_sales_report.pdf");
    }

    public function shopPosPage($shopId)
    {
        $shop = \App\Models\Shop::findOrFail($shopId);
        $customers = \App\Models\Customer::all();

        return view('sales.index', compact('shop', 'customers'));
    }

    public function pos($shopId)
    {
        $customers = Customer::all();
        $shop = \App\Models\Shop::findOrFail($shopId);

        return view('sales.index', compact('customers', 'shop'));
    }



}
