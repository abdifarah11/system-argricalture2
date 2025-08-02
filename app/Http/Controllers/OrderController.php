<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Crop;
use App\Models\PaymentMethod;
use App\Models\Transaction;
// use App\Models\Report;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

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
            // Optional: Fetch order_id if available and generate report
            return response()->json(['message' => 'successfully'], 200);
        } elseif ($resCode === '5306') {
            return response()->json(['message' => 'unsuccessfully'], 400);
        }

        return response()->json([
            'message' => 'unknown response',
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

            if ($request->filled('user_id')) {
                $orders->where('user_id', $request->user_id);
            }

            if ($request->filled('payment_method_id')) {
                $orders->where('payment_method_id', $request->payment_method_id);
            }

            return DataTables::of($orders)
                ->addIndexColumn()
                ->addColumn('user', fn($o) => $o->user->fullname ?? '—')
                ->filterColumn('user', function ($query, $keyword) {
                    $query->whereHas('user', fn($q) => $q->where('fullname', 'like', "%{$keyword}%"));
                })
                ->addColumn('payment_method', fn($o) => $o->paymentMethod->name ?? '—')
                ->filterColumn('payment_method', function ($query, $keyword) {
                    $query->whereHas('paymentMethod', fn($q) => $q->where('name', 'like', "%{$keyword}%"));
                })
                ->addColumn('status', fn($o) => $this->statusBadge($o->status))
                ->addColumn('total_amount', fn($o) => '$' . number_format($o->total_amount, 2))
                ->addColumn('items', function ($o) {
                    return $o->items->map(function ($item) {
                        return ($item->crop->name ?? $item->name) . ' (x' . $item->quantity . ')';
                    })->implode(', ');
                })
                ->editColumn('created_at', fn($o) => $o->created_at->format('Y-m-d H:i'))
                ->addColumn('action', fn($o) => $this->actionButtons($o))
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        $statuses = $this->statuses();
        $users = User::select('id', 'fullname')->orderBy('fullname')->get();
        $payments = PaymentMethod::select('id', 'name')->orderBy('name')->get();

        return view('pages.Orders.index', compact('statuses', 'users', 'payments'));
    }

    public function create()
    {
        $users = User::select('id', 'fullname')->orderBy('fullname')->get();
        $crops = Crop::select('id', 'name')->orderBy('name')->get();
        $payments = PaymentMethod::select('id', 'name')->orderBy('name')->get();
        $statuses = $this->statuses();

        return view('pages.Orders.create', compact('users', 'crops', 'payments', 'statuses'));
    }

    public function store(Request $request)
    {
        $order = Order::create($this->validated($request));
        // $this->generateReport($order); // New addition
        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.crop', 'paymentMethod']);
        return view('pages.Orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $users = User::select('id', 'fullname')->orderBy('fullname')->get();
        $crops = Crop::select('id', 'name')->orderBy('name')->get();
        $payments = PaymentMethod::select('id', 'name')->orderBy('name')->get();
        $statuses = $this->statuses();

        return view('pages.Orders.edit', compact('order', 'users', 'crops', 'payments', 'statuses'));
    }

    public function update(Request $request, Order $order)
    {
        $order->update($this->validated($request));
        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return back()->with('success', 'Order deleted successfully.');
    }

    /* ───────────── Place Order (Updated with Report) ───────────── */
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
            'edahab' => 1,
            'waafi' => 2,
            'zaad' => 3,
        ];

        $user = User::create([
            'fullname' => $validated['full_name'],
            'email' => $validated['email'],
            'phone' => $validated['mobile'],
            'password' => bcrypt($validated['mobile']),
        ]);

        if (!$user) {
            return back()->with('error', 'Failed to create user.');
        }

        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('homepage')->with('error', 'Your cart is empty.');
        }

        $totalAmount = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        $order = Order::create([
            'user_id' => $user->id,
            'payment_method_id' => $paymentMethodMap[$validated['payment_method']],
            'status' => 'pending',
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

        $resCode = $result['responseCode'] ?? null;

        if ($resCode === '2001') {
            Transaction::create([
                'user_id' => $user->id,
                'order_id' => $order->id,
                'payment_method_id' => $order->payment_method_id,
                'amount' => $order->total_amount,
                'status' => 'completed',
                'description' => $order->description ?? 'Order Payment',
                'transaction_date' => now(),
            ]);

            $order->update(['status' => 'completed']);

            // $this->generateReport($order); // New addition

            session()->forget('cart');
            return redirect()->route('homepage')->with('success', 'Order placed successfully.');
        }

        session()->forget('cart');
        return redirect()->route('homepage')->with('error', 'Payment failed or unexpected error.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'crop_id' => ['required', 'exists:crops,id'],
            'payment_method_id' => ['nullable', 'exists:payment_methods,id'],
            'status' => ['required', Rule::in($this->statuses())],
            'total_amount' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
        ]);
    }

    private function statuses(): array
    {
        return ['pending', 'confirmed', 'cancelled', 'completed', 'incompleted'];
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

    // /* ───────────── Report Generator ───────────── */
    // private function generateReport(Order $order): void
    // {
    //     foreach ($order->items as $item) {
    //         Report::create([
    //             'order_id' => $order->id,
    //             'crop_id' => $item->crop_id,
    //             'region_id' => $order->user->region_id ?? null,
    //             'price' => $item->price,
    //             'quantity' => $item->quantity,
    //             'total' => $item->total,
    //             'created_at' => now(),
    //         ]);
    //     }
    // }
}
