@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row g-4">
    <!-- Total Users -->
    <div class="col-md-6 col-lg-3">
        <div class="card text-bg-primary shadow-sm rounded-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-0">{{ $totalUsers }}</h2>
                    <p class="mb-0">Total Users</p>
                </div>
                <i class="bi bi-person-fill display-4 opacity-75"></i>
            </div>
            <div class="card-footer text-white text-end small fst-italic border-top-0">
                More info
            </div>
        </div>
    </div>

    <!-- Total Crops -->
    <div class="col-md-6 col-lg-3">
        <div class="card text-bg-success shadow-sm rounded-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-0">{{ $totalCrops }}</h2>
                    <p class="mb-0">Total Crops</p>
                </div>
                <i class="bi bi-flower1 display-4 opacity-75"></i>
            </div>
            <div class="card-footer text-white text-end small fst-italic border-top-0">
                More info
            </div>
        </div>
    </div>

    <!-- Total Orders -->
    <div class="col-md-6 col-lg-3">
        <div class="card text-bg-warning shadow-sm rounded-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-0">{{ $totalOrders }}</h2>
                    <p class="mb-0">Total Orders</p>
                </div>
                <i class="bi bi-bag-check-fill display-4 opacity-75"></i>
            </div>
            <div class="card-footer text-dark text-end small fst-italic border-top-0">
                More info
            </div>
        </div>
    </div>

    <!-- Total Transactions -->
    <div class="col-md-6 col-lg-3">
        <div class="card text-bg-danger shadow-sm rounded-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-0">{{ $totalTransactions }}</h2>
                    <p class="mb-0">Total Transactions</p>
                </div>
                <i class="bi bi-currency-exchange display-4 opacity-75"></i>
            </div>
            <div class="card-footer text-white text-end small fst-italic border-top-0">
                More info
            </div>
        </div>
    </div>
</div>

<!-- Latest Orders & Transactions -->
<div class="row mt-5">
    <!-- Latest Orders -->
    <div class="col-lg-7">
        <div class="card shadow-sm rounded-4">
            <div class="card-header bg-primary text-white fw-semibold">
                📦 Latest 5 Orders
            </div>
            <div class="card-body p-0">
                <table class="table table-hover table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders->take(5) as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->user->fullname ?? 'N/A' }}</td>
                                <td><span class="badge bg-info text-dark">{{ ucfirst($order->status) }}</span></td>
                                <td>{{ $order->created_at->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-3 text-muted">No recent orders found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Latest Transactions -->
    <div class="col-lg-5">
        <div class="card shadow-sm border-danger rounded-4">
            <div class="card-header bg-danger text-white fw-semibold">
                💰 Latest 5 Transactions
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered mb-0">
                    <thead class="table-danger">
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Amount</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions->take(5) as $txn)
                            <tr>
                                <td>{{ $txn->id }}</td>
                                <td>{{ $txn->user->fullname ?? 'N/A' }}</td>
                                <td><strong>${{ number_format($txn->amount, 2) }}</strong></td>
                                <td>{{ $txn->created_at->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-3 text-muted">No recent transactions found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
