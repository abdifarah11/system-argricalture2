<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $transactions = Transaction::query()
                ->with(['user', 'order.items.crop', 'paymentMethod']); // preload items & crops

            // ✅ Apply filters
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

                // ✅ Matches Blade names
                ->addColumn('customer', fn(Transaction $t) => ucfirst($t->user->username ?? '—'))

                // ✅ List order items like "Tomato, Banana"
                ->addColumn('order_items', function (Transaction $t) {
                    if ($t->order && $t->order->items->count()) {
                        return $t->order->items
                            ->map(fn($item) => ucfirst($item->crop->name ?? $item->name))
                            ->implode(', ');
                    }
                    return '—';
                })

                ->addColumn('payment_method', fn(Transaction $t) => ucfirst($t->paymentMethod->name ?? 'N/A'))
                ->editColumn('amount', fn(Transaction $t) => '$' . number_format($t->amount, 2))
                ->editColumn('status', fn(Transaction $t) => $this->statusBadge($t->status))
                ->editColumn('transaction_date', fn(Transaction $t) =>
                    $t->transaction_date ? $t->transaction_date->format('Y-m-d H:i') : '-')
                ->addColumn('description', fn(Transaction $t) => ucfirst($t->description ?? '-'))

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
