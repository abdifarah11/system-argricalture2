<?php

namespace App\Http\Controllers;

use App\Models\Crop;
use App\Models\CropType;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class CropController extends Controller
{
    /**
     * Display a listing of the crops (DataTable AJAX or initial view).
     */
   public function index(Request $request)
{
    if ($request->ajax()) {
        $crops = Crop::with(['cropType', 'region', 'user'])
            ->select('crops.*');

        return DataTables::of($crops)
            ->addIndexColumn()
            ->addColumn('cropType', fn($row) => $row->cropType->name ?? '-')
            ->addColumn('region', fn($row) => $row->region->name ?? '-')
            ->addColumn('user', fn($row) => $row->user->fullname ?? '-')
            ->editColumn('created_at', fn($row) => $row->created_at->format('Y-m-d H:i'))
            ->addColumn('action', function ($row) {
                return view('pages.crops.crop_actions', compact('row'))->render();
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    return view('pages.crops.index');
}


    /**
     * Show the form for creating a new crop.
     */
    public function create()
    {
        $cropTypes = CropType::orderBy('name')->get();
        $regions = Region::orderBy('name')->get();
        return view('pages.crops.create', compact('cropTypes', 'regions'));
    }

    /**
     * Store a newly created crop in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'crop_type_id' => 'required|exists:crop_types,id',
            'region_id' => 'nullable|exists:regions,id',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $request->file('image')?->store('crops', 'public');

        Crop::create([
            'name' => $request->name,
            'crop_type_id' => $request->crop_type_id,
            'region_id' => $request->region_id,
            'user_id' => Auth::id(),
            'image' => $imagePath,
            'description' => $request->description,
        ]);

        return redirect()->route('crops.index')->with('success', 'Crop added successfully.');
    }

    /**
     * Display the specified crop.
     */
    public function show($id)
    {
        $crop = Crop::with(['cropType', 'region', 'user'])->findOrFail($id);
        return view('pages.crops.show', compact('crop'));
    }

    /**
     * Show the form for editing the specified crop.
     */
    public function edit($id)
    {
        $crop = Crop::findOrFail($id);
        $cropTypes = CropType::orderBy('name')->get();
        $regions = Region::orderBy('name')->get();
        return view('pages.crops.edit', compact('crop', 'cropTypes', 'regions'));
    }

    /**
     * Update the specified crop in storage.
     */
    public function update(Request $request, $id)
    {
        $crop = Crop::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'crop_type_id' => 'required|exists:crop_types,id',
            'region_id' => 'nullable|exists:regions,id',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $crop->image = $request->file('image')->store('crops', 'public');
        }

        $crop->update([
            'name' => $request->name,
            'crop_type_id' => $request->crop_type_id,
            'region_id' => $request->region_id,
            'description' => $request->description,
        ]);

        return redirect()->route('crops.index')->with('success', 'Crop updated successfully.');
    }

    /**
     * Remove the specified crop from storage.
     */
    public function destroy($id)
    {
        $crop = Crop::findOrFail($id);
        $crop->delete();

        return redirect()->route('crops.index')->with('success', 'Crop deleted successfully.');
    }
}
