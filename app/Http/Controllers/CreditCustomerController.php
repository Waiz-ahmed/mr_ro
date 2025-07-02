<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CreditCustomer;  

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
}
