<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    /* ───────────── Index ───────────── */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $orders = Order::with('buyer')->select('orders.*');

            return DataTables::of($orders)
                ->addIndexColumn()
                ->addColumn('buyer', fn($row) => $row->buyer->fullname ?? '-')
                ->addColumn('status', fn($row) => ucfirst($row->status))
                ->addColumn('total_amount', fn($row) => number_format($row->total_amount, 2) . ' $')
                ->addColumn('action', function ($row) {
                    return view('orders.partials.actions', compact('row'))->render();
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('orders.index');
    }

    /* ───────────── Create ───────────── */
    public function create()
    {
        $buyers = User::where('user_type', 'buyer')->orderBy('fullname')->get();
        return view('orders.create', compact('buyers'));
    }

    /* ───────────── Store ───────────── */
    public function store(Request $request)
    {
        $request->validate([
            'buyer_id'     => 'required|exists:users,id',
            'status'       => 'required|in:pending,confirmed,cancelled,completed',
            'total_amount' => 'required|numeric|min:0',
        ]);

        Order::create($request->only('buyer_id', 'status', 'total_amount'));

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    /* ───────────── Edit ───────────── */
    public function edit($id)
    {
        $order  = Order::findOrFail($id);
        $buyers = User::where('user_type', 'buyer')->orderBy('fullname')->get();
        return view('orders.edit', compact('order', 'buyers'));
    }

    /* ───────────── Update ───────────── */
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'buyer_id'     => 'required|exists:users,id',
            'status'       => 'required|in:pending,confirmed,cancelled,completed',
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
