<?php

namespace App\Http\Controllers;

use App\Models\PriceHistory;
use App\Models\Region;
use App\Models\Crop;
use Illuminate\Http\Request;

class PriceHistoryController extends Controller
{
    public function index()
    {
        $histories = PriceHistory::with(['region', 'crop'])->get();
        return view('price_history.index', compact('histories'));
    }

    public function create()
    {
        $regions = Region::all();
        $crops = Crop::all();
        return view('price_history.create', compact('regions', 'crops'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'region_id' => 'required|exists:regions,id',
            'crop_id' => 'required|exists:crops,id',
            'price' => 'required|numeric|min:0',
            'unit' => 'required|string|max:20',
        ]);

        PriceHistory::create($request->all());

        return redirect()->route('price-history.index')->with('success', 'Price history recorded.');
    }

    public function edit(PriceHistory $priceHistory)
    {
        $regions = Region::all();
        $crops = Crop::all();
        return view('price_history.edit', compact('priceHistory', 'regions', 'crops'));
    }

    public function update(Request $request, PriceHistory $priceHistory)
    {
        $request->validate([
            'region_id' => 'required|exists:regions,id',
            'crop_id' => 'required|exists:crops,id',
            'price' => 'required|numeric|min:0',
            'unit' => 'required|string|max:20',
        ]);

        $priceHistory->update($request->all());

        return redirect()->route('price-history.index')->with('success', 'Price history updated.');
    }

    public function destroy(PriceHistory $priceHistory)
    {
        $priceHistory->delete();
        return redirect()->route('price-history.index')->with('success', 'Price history deleted.');
    }
}
