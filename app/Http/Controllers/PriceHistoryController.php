<?php

namespace App\Http\Controllers;

use App\Models\PriceHistory;
use App\Models\Crop;
use App\Models\Region;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PriceHistoryController extends Controller
{
    /* ───────────── Index (DataTables + View) ───────────── */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Load related crop and region models for eager loading
            $priceHistory = PriceHistory::with(['crop', 'region']);

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

        return view('pages.price_history.index');
    }
}
