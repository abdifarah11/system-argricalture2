<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    /* ───────────────────────── Index ───────────────────────── */

    public function index(Request $request)
    {
        // Ajax: server‑side DataTables
        if ($request->ajax()) {
            $orders = Order::with('buyer:id,fullname')
                ->select('orders.*');

            return DataTables::of($orders)
                ->addIndexColumn()
                ->addColumn('buyer', fn (Order $o) => $o->buyer->fullname ?? '—')
                ->addColumn('status', fn (Order $o) => $this->statusBadge($o->status))
                ->addColumn('action', fn (Order $o) => $this->actionButtons($o))
                ->addColumn('total_amount', fn ($o) => '$' . number_format($o->total_amount, 2))

                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        // Blade: first page load
        $buyers = User::select('id', 'fullname')->orderBy('fullname')->get();

        return view('pages.Orders.index', compact('buyers'));
    }

    /* ───────────────────────── Create ───────────────────────── */

    public function create()
    {
        $buyers   = User::select('id', 'fullname')->orderBy('fullname')->get();
        $statuses = $this->statuses();

        return view('pages.Orders.create', compact('buyers', 'statuses'));
    }

    public function store(Request $request)
    {
        Order::create($this->validated($request));

        return redirect()
            ->route('orders.index')
            ->with('success', 'Order created successfully.');
    }

    /* ───────────────────────── Show / Edit ───────────────────────── */

    public function show(Order $order)
    {
        $order->load('buyer');

        return view('pages.Orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $buyers   = User::select('id', 'fullname')->orderBy('fullname')->get();
        $statuses = $this->statuses();

        return view('pages.Orders.edit', compact('order', 'buyers', 'statuses'));
    }

    public function update(Request $request, Order $order)
    {
        $order->update($this->validated($request));

        return redirect()
            ->route('orders.index')
            ->with('success', 'Order updated successfully.');
    }

    /* ───────────────────────── Destroy ───────────────────────── */

    public function destroy(Order $order)
    {
        $order->delete();

        return back()->with('success', 'Order deleted successfully.');
    }

    /* ───────────────────────── Helpers ───────────────────────── */

    /** Re‑useable validation */
    private function validated(Request $request): array
    {
        return $request->validate([
            'buyer_id'     => ['required', 'exists:users,id'],
            'status'       => ['required', Rule::in($this->statuses())],
            'total_amount' => ['required', 'numeric', 'min:0'],
        ]);
    }

    /** Status list (single source of truth) */
    private function statuses(): array
    {
        return ['pending', 'confirmed', 'cancelled', 'completed', 'incompleted'];
    }

    /** Build a coloured badge for DataTables */
    private function statusBadge(string $status): string
    {
        $colors = [
            'pending'      => 'warning text-dark',
            'confirmed'    => 'primary',
            'cancelled'    => 'danger',
            'completed'    => 'success',
            'incompleted'  => 'secondary',
        ];

        $class = $colors[$status] ?? 'light text-dark';

        return '<span class="badge bg-' . $class . '">' . ucfirst($status) . '</span>';
    }

    /** Quick inline action buttons */
    private function actionButtons(Order $o): string
    {
        return '
            <a href="' . route('orders.show', $o) . '" class="btn btn-sm btn-info me-1">
                <i class="bi bi-eye"></i>
            </a>
            <a href="' . route('orders.edit', $o) . '" class="btn btn-sm btn-primary me-1">
                <i class="bi bi-pencil"></i>
            </a>
            <form action="' . route('orders.destroy', $o) . '" method="POST" class="d-inline"
                  onsubmit="return confirm(\'Delete this order?\');">
                ' . csrf_field() . method_field('DELETE') . '
                <button class="btn btn-sm btn-danger">
                    <i class="bi bi-trash"></i>
                </button>
            </form>
        ';
    }
}
