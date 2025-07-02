<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DailySale;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Customer;

class DailySaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all();
        return view('sales.index', compact('customers'));
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
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'quantity' => 'required|integer|min:1',
        ]);

        $sale = DailySale::create([
            'item' => $request->item ?? 'Ration Pack',
            'amount' => $request->amount,
            'quantity' => $request->quantity,
            'customer_id' => $request->customer_id,
            'is_credit' => $request->is_credit ? 1 : 0,
        ]);

        // If credit sale, record it in CreditCustomer
        if ($request->is_credit && $request->customer_id) {
            CreditCustomer::create([
                'customer_id' => $request->customer_id,
                'daily_sale_id' => $sale->id,
                'balance' => $request->amount * $request->quantity,
            ]);
        }

        return redirect()->route('sales.index')->with('success', 'Sale recorded successfully!');
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

}
