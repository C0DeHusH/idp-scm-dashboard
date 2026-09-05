<?php

namespace App\Http\Controllers;

use App\Models\Manpower;
use Illuminate\Http\Request;

class ManpowerController extends Controller
{
    // READ: Display the Manpower Dashboard
    public function index()
    {
        $personnel = Manpower::orderBy('name', 'asc')->get();
        
        // Point this to the location of the Blade file we just created
        return view('manpower.index', compact('personnel')); 
    }

    // CREATE: Show form (can be a separate view or handled via modals)
    public function create()
    {
        return view('manpower.create');
    }

    // STORE: Save new personnel to the database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'section' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'status' => 'required|string|in:Active,Inactive,On Leave',
        ]);

        Manpower::create($validated);

        return redirect()->route('manpower.index')
            ->with('success', 'Personnel added successfully.');
    }

    // EDIT: Show form to edit existing personnel
    public function edit(Manpower $manpower)
    {
        return view('manpower.edit', compact('manpower'));
    }

    // UPDATE: Save changes to existing personnel
    public function update(Request $request, Manpower $manpower)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'section' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'status' => 'required|string|in:Active,Inactive,On Leave',
        ]);

        $manpower->update($validated);

        return redirect()->route('manpower.index')
            ->with('success', 'Personnel updated successfully.');
    }

    // DESTROY: Delete personnel
    public function destroy(Manpower $manpower)
    {
        $manpower->delete();

        return redirect()->route('manpower.index')
            ->with('success', 'Personnel removed successfully.');
    }
}