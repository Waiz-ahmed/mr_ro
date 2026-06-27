<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CurrenciesImport;

class CurrencyController extends Controller
{
    public function index()
    {
        $currencies = Currency::latest()->paginate(20);
        return view('foundation.currencies.index', compact('currencies'));
    }

    public function create()
    {
        return view('foundation.currencies.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code'          => 'required|string|max:10|unique:currencies,code',
            'name'          => 'required|string|max:100',
            'symbol'        => 'nullable|string|max:10',
            'exchange_rate' => 'required|numeric|min:0',
            'is_default'    => 'boolean',
            'status'        => 'in:active,inactive',
        ]);

        Currency::create($validated);

        return redirect()->route('currencies.index')->with('success', 'Currency created.');
    }

    public function show(Currency $currency)
    {
        return view('foundation.currencies.show', compact('currency'));
    }

    public function edit(Currency $currency)
    {
        return view('foundation.currencies.edit', compact('currency'));
    }

    public function update(Request $request, Currency $currency)
    {
        $validated = $request->validate([
            'code'          => 'required|string|max:10|unique:currencies,code,' . $currency->id,
            'name'          => 'required|string|max:100',
            'symbol'        => 'nullable|string|max:10',
            'exchange_rate' => 'required|numeric|min:0',
            'is_default'    => 'boolean',
            'status'        => 'in:active,inactive',
        ]);

        $currency->update($validated);

        return redirect()->route('currencies.index')->with('success', 'Currency updated.');
    }

    public function destroy(Currency $currency)
    {
        $currency->delete(); // soft delete
        return redirect()->route('currencies.index')->with('success', 'Currency deleted.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new CurrenciesImport, $request->file('file'));

        return redirect()->back()->with('success', 'Currencies imported successfully!');
    }
}