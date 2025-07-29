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
{public function index(Request $request)
{
    if ($request->ajax()) {
        $crops = Crop::with(['cropType', 'region', 'user'])->select('crops.*');

        // ✅ Apply Filters
        if ($request->filled('region')) {
            $crops->whereHas('region', function ($q) use ($request) {
                $q->where('name', $request->region);
            });
        }

        if ($request->filled('type')) {
            $crops->whereHas('cropType', function ($q) use ($request) {
                $q->where('name', $request->type);
            });
        }

        return DataTables::of($crops)
            ->addIndexColumn()
            ->addColumn('image', fn($crop) => $crop->image ?? '')
            ->addColumn('cropType', fn($crop) => $crop->cropType->name ?? '—')
            ->addColumn('region', fn($crop) => $crop->region->name ?? '—')
            ->addColumn('user', fn($crop) => $crop->user->fullname ?? '—')
            ->editColumn('created_at', fn($crop) => $crop->created_at->format('Y-m-d H:i'))
            ->addColumn('action', function ($crop) {
                return '
                    <a href="'.route('crops.edit', $crop->id).'" class="btn btn-sm btn-primary">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="'.route('crops.delete', $crop->id).'" method="POST" style="display:inline;">
                        '.csrf_field().method_field('DELETE').'
                        <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm(\'Delete this crop?\')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    // ✅ For Blade View
    $regions   = Region::select('name')->orderBy('name')->get();
    $cropTypes = CropType::select('name')->orderBy('name')->get();

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
////search 
      public function search(Request $request)
    {
        $query = $request->input('q');

        $crops = Crop::where('name', 'LIKE', "%{$query}%")
                     ->orWhere('description', 'LIKE', "%{$query}%")
                     ->get();

        return view('website.ecommerce.search_results', compact('crops', 'query'));
    }
}


