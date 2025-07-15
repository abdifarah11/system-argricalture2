<?php

namespace App\Http\Controllers;

use App\Models\Price;
use App\Models\Region;
use App\Models\Crop;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    public function index()
    {
        $prices = Price::with(['crop', 'region'])->get();
        return view('prices.index', compact('prices'));
    }

    public function create()
    {
        $crops = Crop::all();
        $regions = Region::all();
        return view('prices.create', compact('crops', 'regions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'crop_id' => 'required|exists:crops,id',
            'region_id' => 'required|exists:regions,id',
            'price' => 'required|numeric',
            'unit' => 'required|string|max:20',
        ]);

        Price::create($request->all());

        return redirect()->route('prices.index')->with('success', 'Price added successfully.');
    }

    public function edit(Price $price)
    {
        $crops = Crop::all();
        $regions = Region::all();
        return view('prices.edit', compact('price', 'crops', 'regions'));
    }

    public function update(Request $request, Price $price)
    {
        $request->validate([
            'crop_id' => 'required|exists:crops,id',
            'region_id' => 'required|exists:regions,id',
            'price' => 'required|numeric',
            'unit' => 'required|string|max:20',
        ]);

        $price->update($request->all());

        return redirect()->route('prices.index')->with('success', 'Price updated successfully.');
    }

    public function destroy(Price $price)
    {
        $price->delete();
        return redirect()->route('prices.index')->with('success', 'Price deleted.');
    }
}
