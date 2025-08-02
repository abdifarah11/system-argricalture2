<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Crop;
use App\Models\Region;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ReportController extends Controller
{
    /**
     * Display the report listing (AJAX for DataTable)
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Transaction::with(['user', 'order','order.items.crop', 'paymentMethod'])
                ->select('transactions.*');

            if ($request->filled('order_id')) {
                $query->where('order_id', $request->order_id);
            }

            if ($request->filled('from_date')) {
                $query->whereDate('created_at', '>=', $request->from_date);
            }

            if ($request->filled('to_date')) {
                $query->whereDate('created_at', '<=', $request->to_date);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                // ->editColumn('customer', fn($report) => $report->user->name ?? 'N/A')

                 ->addColumn('customer', content: fn(Transaction $t) => ucfirst($t->user->fullname ?? '—'))

                ->addColumn('order_items', function (Transaction $t) {
                    if ($t->order && $t->order->items->count()) {
                        return $t->order->items
                            ->map(fn($item) => ucfirst($item->crop->name ?? $item->name))
                            ->implode(', ');
                    }
                    return '—';
                })
                ->editColumn('payment_method', fn($report) => $report->paymentMethod->name ?? 'N/A')
                ->editColumn('amount', fn($report) => number_format($report->amount, 2))
                ->editColumn('status', fn($report) => ucfirst($report->status))
                ->editColumn('created_at', fn($report) => $report->created_at->format('Y-m-d H:i'))
                ->make(true);
        }

        $orders = Order::orderByDesc('id')->get();

        return view('pages.reports.index', compact('orders'));
    }

    /**
     * Export filtered reports to PDF
     */
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
