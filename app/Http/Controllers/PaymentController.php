<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\CreditCustomer;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource with search.
     */
    public function index(Request $request)
    {
        $query = Payment::with('customer');

        // Search by customer name
        if ($request->filled('customer_name')) {
            $query->whereHas('customer', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->customer_name . '%');
            });
        }

        // Search by payment date
        if ($request->filled('payment_date')) {
            $query->whereDate('payment_date', $request->payment_date);
        }

        $payments = $query->latest()->paginate(20);

        return view('payments.index', compact('payments'));
    }

    /**
     * Store a newly created payment and apply it to credit balances.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id'     => 'required|exists:customers,id',
            'amount_paid'     => 'required|numeric|min:1',
            'payment_method'  => 'required|string|max:50',
            'note'            => 'nullable|string|max:255',
            'shop_id'         => 'required|exists:shops,id'
        ]);

        // Create payment record
        $payment = Payment::create([
            'customer_id'    => $request->customer_id,
            'shop_id'        => $request->shop_id,
            'amount_paid'    => $request->amount_paid,
            'payment_method' => $request->payment_method,
            'note'           => $request->note,
            'payment_date'   => now(),
            'month'          => now()->month,
            'year'           => now()->year
        ]);

        // Auto apply payment to oldest outstanding credits
        $remaining = $payment->amount_paid;

        $credits = CreditCustomer::where('customer_id', $payment->customer_id)
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

        return redirect()->back()->with('success', 'Payment recorded and applied to credit balance.');
    }

    // Other resource methods can remain empty or be defined as needed
    public function create() {}
    public function show(string $id) {}
    public function edit(string $id) {}
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}
}
