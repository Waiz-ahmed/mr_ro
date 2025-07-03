<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CreditCustomer;  
use PDF;
use App\Models\Payment;
use App\Models\Customer;
use App\Models\DailySale;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf as DomPDF;
use Illuminate\Support\Facades\DB;


class CreditCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $groupedCredits = CreditCustomer::with('customer')
            ->selectRaw('customer_id, SUM(balance) as total_balance')
            ->groupBy('customer_id')
            ->get();

        return view('credits.index', compact('groupedCredits'));
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
        //
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

    public function generateInvoice($customerId)
    {
        $customer = Customer::findOrFail($customerId);

        // Get all unpaid credits (credit sales)
        $credits = CreditCustomer::with('dailySale')
            ->where('customer_id', $customerId)
            ->where('balance', '>', 0)
            ->get();

        // Total outstanding credit
        $totalCredit = $credits->sum('balance');

        // Get all payments made by the customer
        $payments = Payment::where('customer_id', $customerId)->get();
        $totalPaid = $payments->sum('amount_paid');

        // Net outstanding
        $netOutstanding = max(0, $totalCredit - $totalPaid);

        // Generate the invoice PDF
        $pdf = Pdf::loadView('credits.invoice', [
            'customer' => $customer,
            'credits' => $credits,
            'payments' => $payments, // ✅ Fix: include payments for the view
            'totalCredit' => $totalCredit,
            'totalPaid' => $totalPaid,
            'balance' => $netOutstanding,
            'invoiceDate' => now()->format('Y-m-d'),
        ]);

        // Clean filename
        $sanitizedName = preg_replace('/[^A-Za-z0-9]/', '_', $customer->name);
        return $pdf->download("Invoice_{$sanitizedName}_" . now()->format('Ym') . ".pdf");
    }
}
