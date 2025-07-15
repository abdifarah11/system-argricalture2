<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    // Display all regions
    public function index()
    {
        $regions = Region::all();
        return view('regions.index', compact('regions'));
    }

    // Show form to create a region
    public function create()
    {
        return view('regions.create');
    }

    // Store new region
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:regions,name',
        ]);

        Region::create([
            'name' => $request->name,
        ]);

        return redirect()->route('regions.index')->with('success', 'Region created successfully.');
    }

    // Show edit form
    public function edit(Region $region)
    {
        return view('regions.edit', compact('region'));
    }

    // Update existing region
    public function update(Request $request, Region $region)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:regions,name,' . $region->id,
        ]);

        $region->update([
            'name' => $request->name,
        ]);

        return redirect()->route('regions.index')->with('success', 'Region updated successfully.');
    }

    // Delete region
    public function destroy(Region $region)
    {
        $region->delete();
        return redirect()->route('regions.index')->with('success', 'Region deleted successfully.');
    }
}
