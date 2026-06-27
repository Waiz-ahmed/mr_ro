<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StatesImport;

class StateController extends Controller
{
    public function index(Request $request)
    {
        $query = State::with('country');
        if ($request->country_id) {
            $query->where('country_id', $request->country_id);
        }
        $states = $query->latest()->paginate(20);
        $countries = Country::where('status', 'active')->get();
        return view('foundation.states.index', compact('states', 'countries'));
    }

    public function create()
    {
        $countries = Country::where('status', 'active')->get();
        return view('foundation.states.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'country_id' => 'required|exists:countries,id',
            'name'       => 'required|string|max:100|unique:states,name,NULL,id,country_id,' . $request->country_id,
            'code'       => 'nullable|string|max:10',
            'status'     => 'in:active,inactive',
        ]);

        State::create($validated);

        return redirect()->route('states.index')->with('success', 'State created.');
    }

    public function show(State $state)
    {
        $state->load('country', 'cities');
        return view('foundation.states.show', compact('state'));
    }

    public function edit(State $state)
    {
        $countries = Country::where('status', 'active')->get();
        return view('foundation.states.edit', compact('state', 'countries'));
    }

    public function update(Request $request, State $state)
    {
        $validated = $request->validate([
            'country_id' => 'required|exists:countries,id',
            'name'       => 'required|string|max:100|unique:states,name,' . $state->id . ',id,country_id,' . $request->country_id,
            'code'       => 'nullable|string|max:10',
            'status'     => 'in:active,inactive',
        ]);

        $state->update($validated);

        return redirect()->route('states.index')->with('success', 'State updated.');
    }

    public function destroy(State $state)
    {
        $state->delete();
        return redirect()->route('states.index')->with('success', 'State deleted.');
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);
        Excel::import(new StatesImport, $request->file('file'));
        return redirect()->back()->with('success', 'States imported successfully!');
    }
}