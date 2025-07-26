<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Crop;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    /* ───────────────────────── Index ───────────────────────── */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $orders = Order::with(['user:id,fullname', 'crop:id,name', 'paymentMethod:id,name'])
                ->select('orders.*');

            return DataTables::of($orders)
                ->addIndexColumn()
                ->addColumn('user', fn(Order $o) => $o->user->fullname ?? '—')
                ->addColumn('crop', fn(Order $o) => $o->crop->name ?? '—')
                ->addColumn('payment_method', fn(Order $o) => $o->paymentMethod->name ?? '—')
                ->addColumn('status', fn(Order $o) => $this->statusBadge($o->status))
                ->addColumn('total_amount', fn(Order $o) => '$' . number_format($o->total_amount, 2))
                ->addColumn('action', fn(Order $o) => $this->actionButtons($o))
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        $user = User::select('id', 'fullname')->orderBy('fullname')->get();

        return view('pages.Orders.index', compact('user'));
    }

    /* ───────────────────────── Create ───────────────────────── */
    public function create()
    {
        $user   = User::select('id', 'fullname')->orderBy('fullname')->get();
        $crops    = Crop::select('id', 'name')->orderBy('name')->get();
        $payments = PaymentMethod::select('id', 'name')->orderBy('name')->get();
        $statuses = $this->statuses();

        return view('pages.Orders.create', compact('user', 'crops', 'payments', 'statuses'));
    }

    public function store(Request $request)
    {
        Order::create($this->validated($request));

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    /* ───────────────────────── Show / Edit ───────────────────────── */
    public function show(Order $order)
    {
        $order->load(['user', 'crop', 'paymentMethod']);
        return view('pages.Orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $user   = User::select('id', 'fullname')->orderBy('fullname')->get();
        $crops    = Crop::select('id', 'name')->orderBy('name')->get();
        $payments = PaymentMethod::select('id', 'name')->orderBy('name')->get();
        $statuses = $this->statuses();

        return view('pages.Orders.edit', compact('order', 'user', 'crops', 'payments', 'statuses'));
    }

    public function update(Request $request, Order $order)
    {
        $order->update($this->validated($request));

        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
    }

    /* ───────────────────────── Destroy ───────────────────────── */
    public function destroy(Order $order)
    {
        $order->delete();

        return back()->with('success', 'Order deleted successfully.');
    }

    /* ───────────────────────── Helpers ───────────────────────── */
    private function validated(Request $request): array
    {
        return $request->validate([
            'user_id'           => ['required', 'exists:users,id'],
            'crop_id'            => ['required', 'exists:crops,id'],
            'payment_method_id'  => ['nullable', 'exists:payment_methods,id'],
            'status'             => ['required', Rule::in($this->statuses())],
            'total_amount'       => ['required', 'numeric', 'min:0'],
            'description'        => ['nullable', 'string'],
        ]);
    }

    private function statuses(): array
    {
        return ['pending', 'confirmed', 'cancelled', 'completed', 'incompleted'];
    }

    private function statusBadge(string $status): string
    {
        $colors = [
            'pending'     => 'warning text-dark',
            'confirmed'   => 'primary',
            'cancelled'   => 'danger',
            'completed'   => 'success',
            'incompleted' => 'secondary',
        ];

        $class = $colors[$status] ?? 'light text-dark';

        return '<span class="badge bg-' . $class . '">' . ucfirst($status) . '</span>';
    }

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



    // Place order function
    public function placeOrder(Request $request)
    {
        $validated = $request->validate([
            'full_name'      => 'required|string|max:255',
            'region_id'      => 'required|exists:regions,id',
            'address'        => 'required|string|max:255',
            'mobile'         => 'required|string|max:20',
            'email'          => 'required|email|max:255',
            'payment_method' => 'required|in:Credit_Card,Cash,Cash_on_Delivery',
            'order_notes'    => 'nullable|string|max:1000',
        ]);

        // Map string payment methods to IDs
        $paymentMethodMap = [
            'Cash'    => 1,
            'Credit_Card'   => 2,
            'Cash_on_Delivery' => 3,
        ];

        $user = auth()->user();

        $cart = session('cart', []);
        $totalAmount = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        $order = Order::create([
            'user_id'           => $user->id,
            'crop_id'           => null, // or assign if needed
            'payment_method_id' => $paymentMethodMap[$validated['payment_method']],
            'status'            => 'pending',
            'total_amount'      => $totalAmount,
            'description'       => $validated['order_notes'] ?? null,
        ]);

        foreach ($cart as $item) {
            $order->items()->create([
                'name'     => $item['name'],
                'crop_id'  => $item['id'] ?? null,
                'quantity' => $item['quantity'],
                'price'    => $item['price'],
                'total'    => $item['price'] * $item['quantity'],
            ]);
        }

        session()->forget('cart');

        return redirect()->route('homepage')->with('success', 'Order placed successfully.');
    }
}
