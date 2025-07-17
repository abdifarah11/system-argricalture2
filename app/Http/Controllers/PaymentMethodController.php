<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class PaymentMethodController extends Controller
{
    /* ───────────── Index ───────────── */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $methods = PaymentMethod::select(['id', 'name', 'status', ]);

            return DataTables::of($methods)
                ->addIndexColumn()
                ->editColumn('status', fn($row) => $this->badge($row->status))
                // ->editColumn('created_at', fn($row) => $row->created_at->format('Y-m-d H:i'))
                ->addColumn('action', fn($row) => view('pages.payment_methods.acctions', compact('row'))->render())
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('pages.payment_methods.index');
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

    /* ───────────── Destroy ───────────── */
    public function destroy($id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);
        $paymentMethod->delete();

        return redirect()->route('payment_methods.index')
            ->with('success', 'Payment method deleted successfully.');
    }
}
