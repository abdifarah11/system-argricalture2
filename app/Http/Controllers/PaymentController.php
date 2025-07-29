<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        // Load payments with order relation
        $payments = Payment::with('order')->get();
        return view('pages.payment_methods.index', compact('payments'));
    }

    public function create()
    {
        $orders = Order::all();
        return view('pages.payment_methods.create', compact('orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:255',
            'payment_status' => 'required|in:pending,paid,failed',
            'paid_at' => 'nullable|date',
        ]);

        Payment::create($request->all());

        return redirect()->route('payment_methods.index')->with('success', 'Payment recorded successfully.');
    }

    public function edit(Payment $payment)
    {
        $orders = Order::all();
        return view('pages.payment_methods.index', compact('payment', 'orders'));
    }

    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:255',
            'payment_status' => 'required|in:pending,paid,failed',
            'paid_at' => 'nullable|date',
        ]);

        $payment->update($request->all());

        return redirect()->route('payment_methods.index')->with('success', 'Payment updated successfully.');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('payment_methods.index')->with('success', 'Payment deleted.');
    }


 
}
