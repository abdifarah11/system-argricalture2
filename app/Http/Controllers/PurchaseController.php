<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Region;
use App\Models\Crop;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with(['region', 'crop'])->get();
        return view('purchases.index', compact('purchases'));
    }

    public function create()
    {
        $regions = Region::all();
        $crops = Crop::all();
        return view('purchases.create', compact('regions', 'crops'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'region_id' => 'required|exists:regions,id',
            'crop_id' => 'required|exists:crops,id',
            'quantity' => 'required|numeric|min:0',
            'price_per_unit' => 'required|numeric|min:0',
        ]);

        $total = $request->quantity * $request->price_per_unit;

        Purchase::create([
            'region_id' => $request->region_id,
            'crop_id' => $request->crop_id,
            'quantity' => $request->quantity,
            'price_per_unit' => $request->price_per_unit,
            'total_price' => $total,
        ]);

        return redirect()->route('purchases.index')->with('success', 'Purchase recorded successfully.');
    }

    public function edit(Purchase $purchase)
    {
        $regions = Region::all();
        $crops = Crop::all();
        return view('purchases.edit', compact('purchase', 'regions', 'crops'));
    }

    public function update(Request $request, Purchase $purchase)
    {
        $request->validate([
            'region_id' => 'required|exists:regions,id',
            'crop_id' => 'required|exists:crops,id',
            'quantity' => 'required|numeric|min:0',
            'price_per_unit' => 'required|numeric|min:0',
        ]);

        $total = $request->quantity * $request->price_per_unit;

        $purchase->update([
            'region_id' => $request->region_id,
            'crop_id' => $request->crop_id,
            'quantity' => $request->quantity,
            'price_per_unit' => $request->price_per_unit,
            'total_price' => $total,
        ]);

        return redirect()->route('purchases.index')->with('success', 'Purchase updated.');
    }

    public function destroy(Purchase $purchase)
    {
        $purchase->delete();
        return redirect()->route('purchases.index')->with('success', 'Purchase deleted.');
    }
}
