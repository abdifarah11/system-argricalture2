<?php

namespace App\Http\Controllers;

use App\Models\PriceHistory;
use App\Models\Crop;
use App\Models\Region;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PriceHistoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $priceHistory = PriceHistory::with(['crop', 'region']);

            // ✅ Apply Filters
            if ($request->filled('crop_id')) {
                $priceHistory->where('crop_id', $request->crop_id);
            }

            if ($request->filled('region_id')) {
                $priceHistory->where('region_id', $request->region_id);
            }

            return DataTables::of($priceHistory)
                ->addIndexColumn()
                ->addColumn('crop', fn(PriceHistory $p) => $p->crop->name ?? '—')
                ->addColumn('region', fn(PriceHistory $p) => $p->region->name ?? '—')
                ->editColumn('price', fn(PriceHistory $p) => '$' . number_format($p->price, 2))
                ->editColumn('unit', fn(PriceHistory $p) => strtoupper($p->unit))
                ->editColumn('quantity', fn(PriceHistory $p) => $p->quantity ?? '-')
                ->editColumn('created_at', fn(PriceHistory $p) => $p->created_at->format('Y-m-d H:i'))
                ->make(true);
        }

        $crops   = Crop::orderBy('name')->get(['id', 'name']);
        $regions = Region::orderBy('name')->get(['id', 'name']);

        return view('pages.price_history.index', compact('crops', 'regions'));
    }
}
