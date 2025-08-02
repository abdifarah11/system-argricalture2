<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Crop;
use App\Models\Region;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ReportController extends Controller
{
    // Show reports page with crops and regions data for filters
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Report::with(['crop', 'region', 'order'])
                ->select('reports.*');

            if ($request->filled('crop_id')) {
                $query->where('crop_id', $request->crop_id);
            }

            if ($request->filled('region_id')) {
                $query->where('region_id', $request->region_id);
            }

            if ($request->filled('from_date')) {
                $query->whereDate('created_at', '>=', $request->from_date);
            }

            if ($request->filled('to_date')) {
                $query->whereDate('created_at', '<=', $request->to_date);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('crop', fn($report) => $report->crop->name ?? '-')
                ->editColumn('region', fn($report) => $report->region->name ?? '-')
                ->editColumn('order', fn($report) => $report->order->name ?? '-') // order name here
                ->editColumn('created_at', fn($report) => $report->created_at->format('Y-m-d'))
                ->make(true);
        }

        $crops = Crop::orderBy('name')->get();
        $regions = Region::orderBy('name')->get();

        return view('pages.reports.index', compact('crops', 'regions'));
    }

    // Export filtered reports to PDF
    public function export_pdf(Request $request)
    {
        $query = Report::with(['crop', 'region', 'order']);

        if ($request->filled('crop_id')) {
            $query->where('crop_id', $request->crop_id);
        }
        if ($request->filled('region_id')) {
            $query->where('region_id', $request->region_id);
        }
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $reports = $query->get();

        return view('pages.reports.pdf', compact('reports'));
    }
}
