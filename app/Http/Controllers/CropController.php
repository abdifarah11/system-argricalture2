<?php

namespace App\Http\Controllers;

use App\Models\Crop;
use App\Models\CropType;
use App\Models\Region;
use App\Models\Price;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
            $crops = Crop::with(['cropType', 'region', 'user'])->select('crops.*');

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

            public function store(Request $request)
            {
                // Step 1: Validate request data
                $validated = $request->validate([
                    // Crop fields
                    'name' => 'required|string|max:255',
                    'crop_type_id' => 'required|exists:crop_types,id',
                    'region_id' => 'nullable|exists:regions,id',
                    'description' => 'nullable|string',

                    // Price fields
                    'price' => 'required|numeric|min:0|max:999999.99',
                    'unit' => ['required', Rule::in(['kg', 'piece', 'litre'])],

                    // Unit-specific quantity validations
                    'kg' => 'required_if:unit,kg|nullable|numeric|min:0',
                    'litre' => 'required_if:unit,litre|nullable|numeric|min:0',
                    'quantity' => 'required_if:unit,piece|nullable|numeric|min:0',
                ]);

                // Step 2: Create the crop
                $crop = Crop::create([
                    'name' => $request->name,
                    'crop_type_id' => $request->crop_type_id,
                    'region_id' => $request->region_id,
                    'user_id' => Auth::id(),
                    'description' => $request->description,
                ]);

                // Step 3: Determine quantity value based on unit
                $unit = $request->unit;
                $quantity = match($unit) {
                    'kg' => $request->kg,
                    'litre' => $request->litre,
                    'piece' => $request->quantity,
                };

                // Step 4: Create the price entry
                Price::create([
                    'crop_id' => $crop->id,
                    'region_id' => $request->region_id,
                    'price' => $request->price,
                    'unit' => $unit,
                    'quantity' => $quantity,
                ]);

                return redirect()->route('crops.index')->with('success', 'Crop and price saved successfully!');
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
            // 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // $imagePath = $crop->image;

        // if ($request->hasFile('image')) {
        //     $imagePath = $request->file('image')->store('crops', 'public');
        // }

        $crop->update([
            'name' => $request->name,
            'crop_type_id' => $request->crop_type_id,
            'region_id' => $request->region_id,
            'description' => $request->description,
            // 'image' => $imagePath,
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




//



