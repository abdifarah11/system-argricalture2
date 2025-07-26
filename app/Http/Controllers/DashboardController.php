<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Crop;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;

use Illuminate\Routing\Controller as BaseController;

class DashboardController extends BaseController
{

    public function __construct()
    {
        // $this->middleware(['auth', 'verified', 'role:admin']);
    }
    public function index()
    {

        return view('dashboard', [
            'totalUsers' => User::count(),
            'totalCrops' => Crop::count(),
            'totalOrders' => Order::count(),
            'totalTransactions' => Transaction::count(),
            'cropOrders' => Crop::withCount('orders')
                ->orderByDesc('orders_count')
                ->take(10)
                ->get()
                ->pluck('orders_count', 'name'),
        ]);
    }
}
