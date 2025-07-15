<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['user', 'payment'])->get();
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $users = User::all();
        $payments = Payment::all();
        return view('transactions.create', compact('users', 'payments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'payment_id' => 'required|exists:payments,id',
            'transaction_type' => 'required|in:credit,debit',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'transaction_date' => 'nullable|date',
        ]);

        Transaction::create($request->all());

        return redirect()->route('transactions.index')->with('success', 'Transaction recorded.');
    }

    public function edit(Transaction $transaction)
    {
        $users = User::all();
        $payments = Payment::all();
        return view('transactions.edit', compact('transaction', 'users', 'payments'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'payment_id' => 'required|exists:payments,id',
            'transaction_type' => 'required|in:credit,debit',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'transaction_date' => 'nullable|date',
        ]);

        $transaction->update($request->all());

        return redirect()->route('transactions.index')->with('success', 'Transaction updated.');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Transaction deleted.');
    }
}
