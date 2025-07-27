<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Crop;
use App\Models\Order;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $transactions = Transaction::query()
                ->with(['user', 'crop', 'order', 'paymentMethod']);

            // ✅ Filters
            if ($request->filled('status')) {
                $transactions->where('status', $request->status);
            }

            if ($request->filled('payment_method')) {
                $transactions->whereHas('paymentMethod', function ($q) use ($request) {
                    $q->where('name', $request->payment_method);
                });
            }

            return DataTables::of($transactions)
                ->addIndexColumn()
                ->addColumn('user', fn(Transaction $t) => $t->user->name ?? '—')
                ->addColumn('crop', fn(Transaction $t) => $t->crop->name ?? '—')
                ->addColumn('order', fn(Transaction $t) => 'Order #' . ($t->order->id ?? '—'))
                ->addColumn('payment_method', fn(Transaction $t) => $t->paymentMethod->name ?? 'N/A')
                ->editColumn('amount', fn(Transaction $t) => '$' . number_format($t->amount, 2))
                ->editColumn('status', fn(Transaction $t) => $this->statusBadge($t->status))
                ->editColumn('transaction_date', fn(Transaction $t) =>
                    $t->transaction_date ? $t->transaction_date->format('Y-m-d H:i') : '-')
                ->addColumn('description', fn(Transaction $t) => $t->description ?? '-')
                ->rawColumns(['status'])
                ->make(true);
        }

        $statuses = ['pending', 'completed', 'failed', 'cancelled'];
        $paymentMethods = PaymentMethod::orderBy('name')->get(['id', 'name']);

        return view('pages.transactions.index', compact('statuses', 'paymentMethods'));
    }

    private function statusBadge(string $status): string
    {
        $colors = [
            'pending'   => 'warning text-dark',
            'completed' => 'success',
            'failed'    => 'danger',
            'cancelled' => 'secondary',
        ];

        $class = $colors[$status] ?? 'light text-dark';

        return '<span class="badge bg-' . $class . '">' . ucfirst($status) . '</span>';
    }
}
