<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Crop;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        // Optional: Enable middleware for access control
        // $this->middleware(['auth', 'verified', 'role:admin']);
    }

    public function index()
    {
        return view('dashboard', [
                'totalUsers' => User::count(),
        'totalCrops' => Crop::count(),
        'totalOrders' => Order::count(),
        'totalTransactions' => Transaction::count(),
        'orders' => Order::latest()->with('user')->take(5)->get(),
        'transactions' => Transaction::latest()->with('user')->take(5)->get(),
    ]);
    }
}
