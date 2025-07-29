<?php

namespace App\Http\Controllers;

use App\Models\PriceHistory;
use App\Models\Crop;
use App\Models\Region;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;

class PriceHistoryController extends Controller
{
    /**
     * Display the price history table or return JSON for DataTables.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $priceHistory = PriceHistory::with(['crop', 'region']);

            // ✅ Apply filters
            if ($request->filled('crop_id')) {
                $priceHistory->where('crop_id', $request->crop_id);
            }

            if ($request->filled('region_id')) {
                $priceHistory->where('region_id', $request->region_id);
            }

            if ($request->filled('from_date') && $request->filled('to_date')) {
                $priceHistory->whereBetween('created_at', [
                    $request->from_date . ' 00:00:00',
                    $request->to_date . ' 23:59:59'
                ]);
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

        // Load crops and regions for filter dropdowns
        $crops = Crop::orderBy('name')->get(['id', 'name']);
        $regions = Region::orderBy('name')->get(['id', 'name']);

        return view('pages.price_history.index', compact('crops', 'regions'));
    }

    /**
     * Export the filtered report as a downloadable PDF.
     */
    public function report(Request $request)
    {
        $query = PriceHistory::with(['crop', 'region']);

        // ✅ Apply same filters as DataTable
        if ($request->filled('crop_id')) {
            $query->where('crop_id', $request->crop_id);
        }

        if ($request->filled('region_id')) {
            $query->where('region_id', $request->region_id);
        }

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('created_at', [
                $request->from_date . ' 00:00:00',
                $request->to_date . ' 23:59:59'
            ]);
        }

        $data = $query->orderBy('created_at', 'desc')->get();

        if ($data->isEmpty()) {
            return back()->with('error', 'No records found for the selected filters.');
        }

        $pdf = Pdf::loadView('pages.price_history.report.pdf', compact('data'))->setPaper('a4', 'landscape');

        return $pdf->download('price_history_report_' . now()->format('Ymd_His') . '.pdf');
    }

    
}


