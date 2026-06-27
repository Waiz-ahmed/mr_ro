<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CitiesImport;

class CityController extends Controller
{
    public function index(Request $request)
    {
        $query = City::with('state.country');
        if ($request->state_id) {
            $query->where('state_id', $request->state_id);
        }
        $cities = $query->latest()->paginate(20);
        $states = State::with('country')->where('status', 'active')->get();
        return view('foundation.cities.index', compact('cities', 'states'));
    }

    public function create()
    {
        $states = State::with('country')->where('status', 'active')->get();
        return view('foundation.cities.create', compact('states'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'state_id' => 'required|exists:states,id',
            'name'     => 'required|string|max:100|unique:cities,name,NULL,id,state_id,' . $request->state_id,
            'status'   => 'in:active,inactive',
        ]);

        City::create($validated);

        return redirect()->route('cities.index')->with('success', 'City created.');
    }

    public function show(City $city)
    {
        $city->load('state.country');
        return view('foundation.cities.show', compact('city'));
    }

    public function edit(City $city)
    {
        $states = State::with('country')->where('status', 'active')->get();
        return view('foundation.cities.edit', compact('city', 'states'));
    }

    public function update(Request $request, City $city)
    {
        $validated = $request->validate([
            'state_id' => 'required|exists:states,id',
            'name'     => 'required|string|max:100|unique:cities,name,' . $city->id . ',id,state_id,' . $request->state_id,
            'status'   => 'in:active,inactive',
        ]);

        $city->update($validated);

        return redirect()->route('cities.index')->with('success', 'City updated.');
    }

    public function destroy(City $city)
    {
        $city->delete();
        return redirect()->route('cities.index')->with('success', 'City deleted.');
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);
        Excel::import(new CitiesImport, $request->file('file'));
        return redirect()->back()->with('success', 'Cities imported successfully!');
    }
}