<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Crop;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;
use App\Services\PaymentService;

class OrderController extends Controller
{
    protected PaymentService $payment_service;

    public function __construct(PaymentService $payment_service)
    {
        $this->payment_service = $payment_service;
    }

    /* ───────────── Send Payment ───────────── */
    public function send(Request $request)
    {
        $data = [
            'sender' => trim($request->input('sender'), '0'),
            'amount' => $request->input('amount'),
            'description' => $request->input('description'),
        ];

        $result = $this->payment_service->pay($data);
        $resCode = $result['responseCode'] ?? null;

        if ($resCode === '2001') {
            return response()->json(['message' => 'Payment successful'], 200);
        } elseif ($resCode === '5306') {
            return response()->json(['message' => 'Payment failed'], 400);
        }

        return response()->json([
            'message' => 'Unknown response',
            'data' => $result
        ], 500);
    }

    /* ───────────── Index (DataTables + Filters + Search) ───────────── */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $orders = Order::with(['user:id,fullname', 'paymentMethod:id,name', 'items.crop'])
                ->select('orders.*');

            if ($request->filled('status')) {
                $orders->where('status', $request->status);
            }

            if ($request->filled('delivery_status')) {
                $orders->where('delivery_status', $request->delivery_status);
            }

            if ($request->filled('payment')) {
                $orders->whereHas('paymentMethod', function ($q) use ($request) {
                    $q->where('name', $request->payment);
                });
            }

            return DataTables::of($orders)
                ->addIndexColumn()
                ->addColumn('user', fn($o) => $o->user->fullname ?? '—')
                ->filterColumn('user', fn($query, $keyword) => $query->whereHas('user', fn($q) => $q->where('fullname', 'like', "%{$keyword}%")))
                ->addColumn('payment_method', fn($o) => $o->paymentMethod->name ?? '—')
                ->filterColumn('payment_method', fn($query, $keyword) => $query->whereHas('paymentMethod', fn($q) => $q->where('name', 'like', "%{$keyword}%")))
                ->addColumn('status', fn($o) => $this->statusBadge($o->status))
                ->addColumn('delivery_status', fn($o) => $this->deliveryBadge($o->delivery_status))
                ->addColumn('total_amount', fn($o) => '$' . number_format($o->total_amount, 2))
                ->addColumn('items', fn($o) => $o->items->map(fn($item) => ($item->crop->name ?? $item->name) . ' (x' . $item->quantity . ')')->implode(', '))
                ->editColumn('created_at', fn($o) => $o->created_at->format('Y-m-d H:i'))
                ->addColumn('action', fn($o) => $this->actionButtons($o))
                ->rawColumns(['status', 'delivery_status', 'action'])
                ->make(true);
        }

        $statuses = $this->statuses();
        $deliveryStatuses = $this->deliveryStatuses();
        $payments = PaymentMethod::select('id', 'name')->orderBy('name')->get();

        return view('pages.Orders.index', compact('statuses', 'deliveryStatuses', 'payments'));
    }

    /* ───────────── Create ───────────── */
    public function create()
    {
        $users = User::select('id', 'fullname')->orderBy('fullname')->get();
        $crops = Crop::select('id', 'name')->orderBy('name')->get();
        $payments = PaymentMethod::select('id', 'name')->orderBy('name')->get();
        $statuses = $this->statuses();
        $deliveryStatuses = $this->deliveryStatuses();

        return view('pages.Orders.create', compact('users', 'crops', 'payments', 'statuses', 'deliveryStatuses'));
    }

    /* ───────────── Store ───────────── */
    public function store(Request $request)
    {
        $validated = $this->validated($request);

        // Auto-set delivery_status if status is completed
        if ($validated['status'] === 'completed') {
            $validated['delivery_status'] = 'delivered';
        }

        $order = Order::create([
            'user_id' => $validated['user_id'],
            'payment_method_id' => $validated['payment_method_id'] ?? null,
            'status' => $validated['status'],
            'delivery_status' => $validated['delivery_status'] ?? 'not_delivered',
            'total_amount' => $validated['total_amount'],
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    /* ───────────── Show ───────────── */
    public function show(Order $order)
    {
        $order->load(['user', 'items.crop', 'paymentMethod']);
        return view('pages.Orders.show', compact('order'));
    }

    /* ───────────── Edit ───────────── */
    public function edit(Order $order)
    {
        $users = User::select('id', 'fullname')->orderBy('fullname')->get();
        $crops = Crop::select('id', 'name')->orderBy('name')->get();
        $payments = PaymentMethod::select('id', 'name')->orderBy('name')->get();
        $statuses = $this->statuses();
        $deliveryStatuses = $this->deliveryStatuses();

        return view('pages.Orders.edit', compact('order', 'users', 'crops', 'payments', 'statuses', 'deliveryStatuses'));
    }

    /* ───────────── Update ───────────── */
    public function update(Request $request, Order $order)
    {
        $validated = $this->validated($request);

        // Auto-set delivery_status if status is completed
        if ($validated['status'] === 'completed') {
            $validated['delivery_status'] = 'delivered';
        }

        $order->update($validated);
        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
    }

    /* ───────────── Destroy ───────────── */
    public function destroy(Order $order)
    {
        $order->delete();
        return back()->with('success', 'Order deleted successfully.');
    }

    /* ───────────── Frontend Place Order ───────────── */
    public function placeOrder(Request $request)
    {
        $validated = $request->validate([
            'full_name'      => 'required|string|max:255',
            'region_id'      => 'required|exists:regions,id',
            'address'        => 'required|string|max:255',
            'mobile'         => 'required|string|max:20',
            'email'          => 'required|email|max:255|unique:users,email',
            'payment_method' => 'required|in:waafi,edahab,zaad',
            'order_notes'    => 'nullable|string|max:1000',
        ]);

        $paymentMethodMap = [
            'waafi' => 2,
            'edahab' => 1,
            'zaad' => 3,
        ];

        $user = User::create([
            'fullname' => $validated['full_name'],
            'email' => $validated['email'],
            'phone' => $validated['mobile'],
            'password' => bcrypt($validated['mobile']),
        ]);

        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('homepage')->with('error', 'Your cart is empty.');
        }

        $totalAmount = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        $order = Order::create([
            'user_id' => $user->id,
            'payment_method_id' => $paymentMethodMap[$validated['payment_method']],
            'status' => 'pending',
            'delivery_status' => 'not_delivered',
            'total_amount' => $totalAmount,
            'description' => $validated['order_notes'] ?? null,
        ]);

        foreach ($cart as $item) {
            $order->items()->create([
                'name' => $item['name'],
                'crop_id' => $item['id'] ?? null,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total' => $item['price'] * $item['quantity'],
            ]);
        }

        $result = $this->payment_service->pay([
            'sender' => trim($validated['mobile'], '0'),
            'amount' => $order->total_amount,
            'description' => $order->description ?? 'Order Payment',
        ]);

        if (($result['responseCode'] ?? null) === '2001') {
            Transaction::create([
                'user_id' => $user->id,
                'order_id' => $order->id,
                'payment_method_id' => $order->payment_method_id,
                'amount' => $order->total_amount,
                'status' => 'completed',
                'description' => $order->description ?? 'Order Payment',
                'transaction_date' => now(),
            ]);

            $order->update(['status' => 'completed', 'delivery_status' => 'delivered']);
            session()->forget('cart');

            return redirect()->route('homepage')->with('success', 'Order placed successfully.');
        }

        session()->forget('cart');
        return redirect()->route('homepage')->with('error', 'Payment failed or unexpected error.');
    }

    /* ───────────── Helpers ───────────── */
    private function validated(Request $request): array
    {
        return $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'crop_id' => ['required', 'exists:crops,id'],
            'payment_method_id' => ['nullable', 'exists:payment_methods,id'],
            'status' => ['required', Rule::in($this->statuses())],
            'delivery_status' => ['required', Rule::in($this->deliveryStatuses())],
            'total_amount' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
        ]);
    }

    private function statuses(): array
    {
        return ['pending', 'confirmed', 'cancelled', 'completed', 'incompleted'];
    }

    private function deliveryStatuses(): array
    {
        return ['delivered', 'not_delivered'];
    }

    private function statusBadge(string $status): string
    {
        $colors = [
            'pending' => 'warning text-dark',
            'confirmed' => 'primary',
            'cancelled' => 'danger',
            'completed' => 'success',
            'incompleted' => 'secondary',
        ];

        $class = $colors[$status] ?? 'light text-dark';
        return '<span class="badge bg-' . $class . '">' . ucfirst($status) . '</span>';
    }

    private function deliveryBadge(string $status): string
    {
        $colors = [
            'delivered' => 'success',
            'not_delivered' => 'danger',
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
}
