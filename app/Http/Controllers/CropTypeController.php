<?php

namespace App\Http\Controllers;

use App\Models\CropType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class CropTypeController extends Controller
{
    /**
     * Display a listing of the crop types (DataTable AJAX or initial view).
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $cropTypes = CropType::select(['id', 'name', 'description', 'image', 'created_at']);

            return DataTables::of($cropTypes)
                ->addIndexColumn()
                ->editColumn('created_at', fn($row) => $row->created_at->format('Y-m-d H:i'))
                ->addColumn('image', function ($row) {
                    if ($row->image) {
                        return '<img src="' . asset('storage/' . $row->image) . '" alt="' . e($row->name) . '" style="height:40px; width:auto; border-radius:4px;">';
                    }
                    return '-';
                })
                ->addColumn('action', function ($row) {
                    return view('pages.crop_types.crop_type_actions', compact('row'))->render();
                })
                ->rawColumns(['image', 'action'])
                ->make(true);
        }

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
     * Store a newly created crop type.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:crop_types,name',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048', // max 2MB
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('crop_types', 'public');
        }

        CropType::create($validated);

        return redirect()->route('crop_types.index')
                         ->with('success', 'Crop type created successfully.');
    }

    /**
     * Show the form for editing the specified crop type.
     */
    public function edit($id)
    {
        $cropType = CropType::findOrFail($id);
        return view('pages.crop_types.edit', compact('cropType'));
    }

    /**
     * Update the specified crop type.
     */
    public function update(Request $request, $id)
    {
        $cropType = CropType::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:crop_types,name,' . $cropType->id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($cropType->image && Storage::disk('public')->exists($cropType->image)) {
                Storage::disk('public')->delete($cropType->image);
            }
            $validated['image'] = $request->file('image')->store('crop_types', 'public');
        }

        $cropType->update($validated);

        return redirect()->route('crop_types.index')
                         ->with('success', 'Crop type updated successfully.');
    }

    /**
     * Remove the specified crop type.
     */
    public function destroy($id)
    {
        $cropType = CropType::findOrFail($id);

        if ($cropType->image && Storage::disk('public')->exists($cropType->image)) {
            Storage::disk('public')->delete($cropType->image);
        }

        $cropType->delete();

        return redirect()->route('crop_types.index')
                         ->with('success', 'Crop type deleted successfully.');
    }
}
