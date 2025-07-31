<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Crop;
use App\Models\Region;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    // Show report page or return DataTables JSON
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Report::with(['crop', 'region', 'order']);

            if ($request->filled('crop_id')) {
                $query->where('crop_id', $request->crop_id);
            }

            if ($request->filled('region_id')) {
                $query->where('region_id', $request->region_id);
            }

            if ($request->filled('order_id')) {
                $query->where('order_id', $request->order_id);
            }

            if ($request->filled('from_date') && $request->filled('to_date')) {
                $query->whereBetween('created_at', [
                    $request->from_date . ' 00:00:00',
                    $request->to_date . ' 23:59:59',
                ]);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('order_id', fn(Report $r) => $r->order->id) // if you want to show more info, use $r->order->code or similar
                ->addColumn('crop', fn(Report $r) => $r->crop->name)
                ->addColumn('region', fn(Report $r) => $r->region->name)
                ->editColumn('price', fn(Report $r) => '$' . number_format($r->price, 2))
                ->editColumn('unit', fn(Report $r) => strtoupper($r->unit))
                ->editColumn('quantity', fn(Report $r) => $r->quantity ?? '-')
                ->editColumn('created_at', fn(Report $r) => $r->created_at->format('Y-m-d H:i'))
                ->make(true);
        }

        $crops = Crop::orderBy('name')->get(['id', 'name']);
        $regions = Region::orderBy('name')->get(['id', 'name']);

        return view('pages.reports.index', compact('crops', 'regions'));
    }

    // Generate PDF report based on filters
    public function exportPdf(Request $request)
    {
        $query = Report::with(['crop', 'region', 'order']);

        if ($request->filled('crop_id')) {
            $query->where('crop_id', $request->crop_id);
        }

        if ($request->filled('region_id')) {
            $query->where('region_id', $request->region_id);
        }

        if ($request->filled('order_id')) {
            $query->where('order_id', $request->order_id);
        }

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('created_at', [
                $request->from_date . ' 00:00:00',
                $request->to_date . ' 23:59:59',
            ]);
        }

        $data = $query->orderBy('created_at', 'desc')->get();

        if ($data->isEmpty()) {
            return back()->with('error', 'No records found for the selected filters.');
        }

        $pdf = Pdf::loadView('pages.reports.pdf', compact('data'))->setPaper('a4', 'landscape');

        return $pdf->download('report_' . now()->format('Ymd_His') . '.pdf');
    }
}

