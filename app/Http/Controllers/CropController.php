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
use Session;
use Yajra\DataTables\Facades\DataTables;

class CropController extends Controller
{
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

        // ✅ Add these lines (just like UserController)
        $regions   = Region::orderBy('name')->get(['id', 'name']);
        $cropTypes = CropType::orderBy('name')->get(['id', 'name']);

        return view('pages.crops.index', compact('regions', 'cropTypes'));
    }

    public function create()
    {
        $cropTypes = CropType::orderBy('name')->get();
        $regions = Region::orderBy('name')->get();
        return view('pages.crops.create', compact('cropTypes', 'regions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'crop_type_id' => 'required|exists:crop_types,id',
            'region_id' => 'nullable|exists:regions,id',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',

            'price' => 'required|numeric|min:0|max:999999.99',
            'unit' => ['required', Rule::in(['kg', 'piece', 'litre'])],
            'kg' => 'required_if:unit,kg|nullable|numeric|min:0',
            'litre' => 'required_if:unit,litre|nullable|numeric|min:0',
            'quantity' => 'required_if:unit,piece|nullable|numeric|min:0',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('crops', 'public');
        }

        $crop = Crop::create([
            'name' => $request->name,
            'crop_type_id' => $request->crop_type_id,
            'region_id' => $request->region_id,
            'user_id' => Auth::id(),
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        $unit = $request->unit;
        $quantity = match ($unit) {
            'kg' => $request->kg,
            'litre' => $request->litre,
            'piece' => $request->quantity,
        };

        Price::create([
            'crop_id' => $crop->id,
            'region_id' => $request->region_id,
            'price' => $request->price,
            'unit' => $unit,
            'quantity' => $quantity,
        ]);

        return redirect()->route('crops.index')->with('success', 'Crop and price saved successfully!');
    }

    public function show($id)
    {
        $crop = Crop::with(['cropType', 'region', 'user'])->findOrFail($id);
        return view('pages.crops.show', compact('crop'));
    }

    public function edit($id)
    {
        $crop = Crop::findOrFail($id);
        $cropTypes = CropType::orderBy('name')->get();
        $regions = Region::orderBy('name')->get();
        return view('pages.crops.edit', compact('crop', 'cropTypes', 'regions'));
    }

    public function update(Request $request, $id)
    {
        $crop = Crop::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'crop_type_id' => 'required|exists:crop_types,id',
            'region_id' => 'nullable|exists:regions,id',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1048576',
        ]);

        $imagePath = $crop->image;

        if ($request->hasFile('image')) {
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

    public function destroy($id)
    {
        $crop = Crop::findOrFail($id);

        if ($crop->image && Storage::disk('public')->exists($crop->image)) {
            Storage::disk('public')->delete($crop->image);
        }

        $crop->delete();

        return redirect()->route('crops.index')->with('success', 'Crop deleted successfully.');
    }
}
