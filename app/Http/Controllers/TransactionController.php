<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Crop;
use App\Models\Order;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
{
    /* ───────────── Index (DataTables + View) ───────────── */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $transactions = Transaction::query()
                ->with(['user', 'crop', 'order', 'paymentMethod']);

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
        return view('pages.transactions.index', compact('statuses'));
    }

    /* ───────────── Helpers ───────────── */
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
