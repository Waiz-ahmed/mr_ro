<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\CreditCustomer;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'customer_id' => 'required|exists:customers,id',
            'amount_paid' => 'required|numeric|min:1',
            'payment_method' => 'required|string'
        ]);

        $payment = Payment::create([
            'customer_id' => $request->customer_id,
            'amount_paid' => $request->amount_paid,
            'payment_method' => $request->payment_method,
            'payment_date' => now(),
        ]);

        // 🧠 Apply payment to oldest credit balances
        $remaining = $request->amount_paid;

        $credits = CreditCustomer::where('customer_id', $request->customer_id)
                    ->where('balance', '>', 0)
                    ->orderBy('created_at')
                    ->get();

        foreach ($credits as $credit) {
            if ($remaining <= 0) break;

            $deduct = min($credit->balance, $remaining);
            $credit->balance -= $deduct;
            $credit->save();

            $remaining -= $deduct;
        }

        return redirect()->back()->with('success', 'Payment recorded and applied to outstanding balance.');
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
}
