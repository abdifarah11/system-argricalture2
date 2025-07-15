<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    /* ───────────── Index ───────────── */
    public function index(Request $request)
    {
        /* ---------- AJAX: DataTables request ---------- */
        if ($request->ajax()) {
            // ⬇ join buyers so we can order / search on buyer name
            $orders = Order::query()
                ->leftJoin('users as buyers', 'buyers.id', '=', 'orders.buyer_id')
                ->select([
                    'orders.id',
                    'buyers.fullname as buyer',   // alias for JSON key
                    'orders.status',
                    'orders.total_amount',
                    'orders.created_at',
                ]);

            return DataTables::of($orders)
                ->addIndexColumn()                           // DT_RowIndex
                ->editColumn('status', fn($row)               // nicer status text
                    => ucfirst($row->status))
                ->editColumn('total_amount', fn($row)         // formatted money
                    => number_format($row->total_amount, 2) . ' $')
                ->editColumn('created_at', fn($row)           // date format
                    => $row->created_at->format('Y-m-d H:i'))
                ->addColumn('action', function ($row) {       // buttons / dropdown
                    return view('pages.orders.partials.actions', compact('row'))->render();
                })
                ->rawColumns(['action'])                      // allow HTML in “action”
                ->make(true);
        }

        /* ---------- First page load: Blade view ---------- */
        $buyers   = User::where('user_type', 'buyer')
                        ->orderBy('fullname')
                        ->get(['id', 'fullname']);
        $statuses = ['pending', 'confirmed', 'cancelled', 'completed'];

        return view('pages.orders.index', compact('buyers', 'statuses'));
    }

    /* ───────────── Create ───────────── */
    public function create()
    {
        $buyers   = User::where('user_type', 'buyer')->orderBy('fullname')->get();
        $statuses = ['pending', 'confirmed', 'cancelled', 'completed'];

        return view('pages.orders.create', compact('buyers', 'statuses'));
    }

    /* ───────────── Store ───────────── */
    public function store(Request $request)
    {
        $request->validate([
            'buyer_id'     => 'required|exists:users,id',
            'status'       => ['required', Rule::in(['pending', 'confirmed', 'cancelled', 'completed'])],
            'total_amount' => 'required|numeric|min:0',
        ]);

        Order::create($request->only('buyer_id', 'status', 'total_amount'));

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    /* ───────────── Edit ───────────── */
    public function edit($id)
    {
        $order    = Order::findOrFail($id);
        $buyers   = User::where('user_type', 'buyer')->orderBy('fullname')->get();
        $statuses = ['pending', 'confirmed', 'cancelled', 'completed'];

        return view('pages.orders.edit', compact('order', 'buyers', 'statuses'));
    }

    /* ───────────── Update ───────────── */
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'buyer_id'     => 'required|exists:users,id',
            'status'       => ['required', Rule::in(['pending', 'confirmed', 'cancelled', 'completed'])],
            'total_amount' => 'required|numeric|min:0',
        ]);

        $order->update($request->only('buyer_id', 'status', 'total_amount'));

        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
    }

    /* ───────────── Destroy ───────────── */
    public function destroy($id)
    {
        Order::findOrFail($id)->delete();

        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }
}
