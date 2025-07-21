<?php

namespace App\Http\Controllers;

use App\Models\Crop;
use App\Models\CropType;
use App\Models\Region;
use App\Models\Price;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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

    /**
     * Store a newly created crop and its initial price.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            // Crop fields
            'name' => 'required|string|max:255',
            'crop_type_id' => 'required|exists:crop_types,id',
            'region_id' => 'nullable|exists:regions,id',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            // Price fields
            'price' => 'required|numeric|min:0|max:999999.99',
            'unit' => ['required', Rule::in(['kg', 'piece', 'litre'])],

            // Unit-specific quantity validations
            'kg' => 'required_if:unit,kg|nullable|numeric|min:0',
            'litre' => 'required_if:unit,litre|nullable|numeric|min:0',
            'quantity' => 'required_if:unit,piece|nullable|numeric|min:0',
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('crops', 'public');
        }

        // Create crop
        $crop = Crop::create([
            'name' => $request->name,
            'crop_type_id' => $request->crop_type_id,
            'region_id' => $request->region_id,
            'user_id' => Auth::id(),
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        // Determine quantity based on unit
        $unit = $request->unit;
        $quantity = match ($unit) {
            'kg' => $request->kg,
            'litre' => $request->litre,
            'piece' => $request->quantity,
        };

        // Create price record
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

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'crop_type_id' => 'required|exists:crop_types,id',
            'region_id' => 'nullable|exists:regions,id',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image update: delete old image if new one uploaded
        $imagePath = $crop->image;

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('crops', 'public');
        }

        $crop->update([
            'name' => $request->name,
            'crop_type_id' => $request->crop_type_id,
            'region_id' => $request->region_id,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return redirect()->route('crops.index')->with('success', 'Crop updated successfully.');
    }

    /**
     * Remove the specified crop from storage.
     */
    public function destroy($id)
    {
        $crop = Crop::findOrFail($id);

        // Delete image file from storage if exists
        if ($crop->image && Storage::disk('public')->exists($crop->image)) {
            Storage::disk('public')->delete($crop->image);
        }

        $crop->delete();

        return redirect()->route('crops.index')->with('success', 'Crop deleted successfully.');
    }
}
