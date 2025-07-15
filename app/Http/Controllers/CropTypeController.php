<?php

namespace App\Http\Controllers;

use App\Models\CropType;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CropTypeController extends Controller
{
    /**
     * Display a listing of the crop types.
     */
    public function index(Request $request)
    {
        // Handle AJAX request from DataTables
        if ($request->ajax()) {
            $cropTypes = CropType::query()->select([
                'id',
                'name',
                'description',
                'created_at',
            ]);

            return DataTables::of($cropTypes)
                ->addIndexColumn() // Adds DT_RowIndex
                ->editColumn('created_at', fn($row) =>
                    $row->created_at->format('Y-m-d H:i'))
                ->addColumn('action', function ($row) {
                    return view('pages.crop_types.crop_type_actions', compact('row'))->render();
                })
                ->rawColumns(['action']) // Render HTML inside the action column
                ->make(true);
        }

        // Show Blade view on first load
        return view('pages.crop_types.index');
    }

    /**
     * Show the form for creating a new crop type.
     */
    public function create()
    {
        return view('pages.crop_types.create');
    }

    /**
     * Store a newly created crop type in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:crop_types,name',
            'description' => 'nullable|string',
        ]);

        CropType::create($validated);

        return redirect()->route('crop_types.index')
                         ->with('success', 'Crop type created successfully.');
    }

    /**
     * Show the form for editing the specified crop type.
     */
    public function edit(CropType $cropType)
    {
        return view('pages.crop_types.edit', compact('cropType'));
    }

    /**
     * Update the specified crop type in storage.
     */
    public function update(Request $request, CropType $cropType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:crop_types,name,' . $cropType->id,
            'description' => 'nullable|string',
        ]);

        $cropType->update($validated);

        return redirect()->route('crop_types.index')
                         ->with('success', 'Crop type updated successfully.');
    }

    /**
     * Remove the specified crop type from storage.
     */
    public function destroy(CropType $cropType)
    {
        $cropType->delete();

        return redirect()->route('crop_types.index')
                         ->with('success', 'Crop type deleted successfully.');
    }
}
