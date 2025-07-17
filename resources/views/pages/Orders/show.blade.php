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
