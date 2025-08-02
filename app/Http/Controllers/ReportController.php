<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * Display the report listing (AJAX for DataTable)
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Transaction::with(['user', 'order', 'order.items.crop', 'paymentMethod'])
                ->where('status', 'completed') // ✅ Only completed transactions
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
                ->addColumn('customer', fn(Transaction $t) => ucfirst($t->user->fullname ?? '—'))
                ->addColumn('order_items', function (Transaction $t) {
                    if ($t->order && $t->order->items->count()) {
                        return $t->order->items
                            ->map(fn($item) => ucfirst($item->crop->name ?? $item->name))
                            ->implode(', ');
                    }
                    return '—';
                })
                ->editColumn('payment_method', fn($t) => $t->paymentMethod->name ?? 'N/A')
                ->editColumn('amount', fn($t) => number_format($t->amount, 2))
                ->editColumn('status', fn($t) => ucfirst($t->status))
                ->editColumn('created_at', fn($t) => $t->created_at->format('Y-m-d H:i'))
                ->make(true);
        }

        $orders = Order::orderByDesc('id')->get();

        return view('pages.reports.index', compact('orders'));
    }

    /**
     * Export filtered reports to PDF
     */
    public function exportPdf(Request $request)
    {
        $query = Transaction::with(['user', 'order.items.crop', 'paymentMethod'])
            ->where('status', 'completed'); // ✅ Only completed

        if ($request->filled('order_id')) {
            $query->where('order_id', $request->order_id);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $reports = $query->get();

        $pdf = Pdf::loadView('pages.reports.pdf', compact('reports'))->setPaper('a4', 'landscape');
        return $pdf->download('reports_' . now()->format('Ymd_His') . '.pdf');
    }
}
