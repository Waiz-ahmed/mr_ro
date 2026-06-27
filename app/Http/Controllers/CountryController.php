<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CountriesImport;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::latest()->paginate(20);
        return view('foundation.countries.index', compact('countries'));
    }

    public function create()
    {
        return view('foundation.countries.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:100|unique:countries,name',
            'code'       => 'nullable|string|max:5|unique:countries,code',
            'phone_code' => 'nullable|string|max:10',
            'status'     => 'in:active,inactive',
        ]);

        Country::create($validated);

        return redirect()->route('countries.index')->with('success', 'Country created.');
    }

    public function show(Country $country)
    {
        $country->load('states');
        return view('foundation.countries.show', compact('country'));
    }

    public function edit(Country $country)
    {
        return view('foundation.countries.edit', compact('country'));
    }

    public function update(Request $request, Country $country)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:100|unique:countries,name,' . $country->id,
            'code'       => 'nullable|string|max:5|unique:countries,code,' . $country->id,
            'phone_code' => 'nullable|string|max:10',
            'status'     => 'in:active,inactive',
        ]);

        $country->update($validated);

        return redirect()->route('countries.index')->with('success', 'Country updated.');
    }

    public function destroy(Country $country)
    {
        $country->delete();
        return redirect()->route('countries.index')->with('success', 'Country deleted.');
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);
        Excel::import(new CountriesImport, $request->file('file'));
        return redirect()->back()->with('success', 'Countries imported successfully!');
    }
}