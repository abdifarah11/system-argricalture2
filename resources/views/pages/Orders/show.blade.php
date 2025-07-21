@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Order #{{ $order->id }}</h4>

    <div class="card">
        <div class="card-body">
            <p><strong>Buyer:</strong> {{ $order->user->fullname ?? '—' }}</p>
            <p><strong>Crop:</strong> {{ $order->crop->name ?? '—' }}</p>
            <p><strong>Payment Method:</strong> {{ $order->paymentMethod->name ?? '—' }}</p>
            <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
            <p><strong>Total Amount:</strong> ${{ number_format($order->total_amount, 2) }}</p>
            <p><strong>Description:</strong> {{ $order->description ?? '—' }}</p>
            <p><strong>Created At:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
        </div>
    </div>

    <a href="{{ route('orders.index') }}" class="btn btn-secondary mt-3">Back to Orders</a>
</div>
@endsection






@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Order #{{ $order->id }}</h4>

    
        <div class="card-body">

            <div class="row mb-3">
                <div class="col-md-6">
                    <p class="mb-1 text-muted">Buyer:</p>
                    <h6>{{ $order->user->fullname ?? '—' }}</h6>
                </div>
                <div class="col-md-6">
                    <p class="mb-1 text-muted">Crop:</p>
                    <h6>{{ $order->crop->name ?? '—' }}</h6>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <p class="mb-1 text-muted">Payment Method:</p>
                    <h6>{{ $order->paymentMethod->name ?? '—' }}</h6>
                </div>
                <div class="col-md-6">
                    <p class="mb-1 text-muted">Status:</p>
                    <h6>
                        <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'pending' ? 'warning' : 'secondary') }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </h6>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <p class="mb-1 text-muted">Total Amount:</p>
                    <h6 class="text-success">${{ number_format($order->total_amount, 2) }}</h6>
                </div>
                <div class="col-md-6">
                    <p class="mb-1 text-muted">Created At:</p>
                    <h6>{{ $order->created_at->format('F d, Y - H:i') }}</h6>
                </div>
            </div>

            <div class="mb-3">
                <p class="mb-1 text-muted">Description:</p>
                <h6>{{ $order->description ?? '—' }}</h6>
            </div>
        </div>
    </div>

    <a href="{{ route('orders.index') }}" class="btn btn-secondary mt-3">Back to Orders</a>
</div>
@endsection
