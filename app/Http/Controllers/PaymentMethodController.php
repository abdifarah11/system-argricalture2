<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class PaymentMethodController extends Controller
{
    /* ───────────── Index (with Filters + DataTables) ───────────── */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $methods = PaymentMethod::query();

            // ✅ Apply Filter: Status
            if ($request->filled('status')) {
                $methods->where('status', $request->status);
            }

            return DataTables::of($methods)
                ->addIndexColumn()
                ->editColumn('status', fn(PaymentMethod $row) => $this->badge($row->status))
                ->addColumn('action', fn(PaymentMethod $row) =>
                    view('pages.payment_methods.acctions', compact('row'))->render()
                )
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        $statuses = ['active', 'inactive'];
        return view('pages.payment_methods.index', compact('statuses'));
    }

    /* ───────────── Create ───────────── */
    public function create()
    {
        return view('pages.payment_methods.create');
    }

    /* ───────────── Store ───────────── */
    public function store(Request $request)
    {
        $validated = $this->validateData($request);
        PaymentMethod::create($validated);

        return redirect()->route('payment_methods.index')
            ->with('success', 'Payment method created successfully.');
    }

    /* ───────────── Edit ───────────── */
    public function edit($id)
    {
        $payment_method = PaymentMethod::findOrFail($id);
        return view('pages.payment_methods.edit', compact('payment_method'));
    }

    /* ───────────── Update ───────────── */
    public function update(Request $request, $id)
    {
        $payment_method = PaymentMethod::findOrFail($id);
        $validated = $this->validateData($request);
        $payment_method->update($validated);

        return redirect()->route('payment_methods.index')
            ->with('success', 'Payment method updated successfully.');
    }

    /* ───────────── Destroy ───────────── */
    public function destroy($id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);
        $paymentMethod->delete();

        return redirect()->route('payment_methods.index')
            ->with('success', 'Payment method deleted successfully.');
    }

    /* ───────────── Helpers ───────────── */
    private function validateData(Request $request)
    {
        return $request->validate([
            'name'   => 'required|string|max:255',
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ]);
    }

    private function badge(string $status): string
    {
        $class = $status === 'active' ? 'success' : 'secondary';
        return '<span class="badge bg-' . $class . '">' . ucfirst($status) . '</span>';
    }
}
