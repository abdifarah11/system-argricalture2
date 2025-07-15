@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Order Details</h2>

    <div class="mb-3">
        <strong>Buyer:</strong> {{ $order->buyer->fullname ?? '—' }}
    </div>

    <div class="mb-3">
        <strong>Status:</strong> {{ ucfirst($order->status) }}
    </div>

    <div class="mb-3">
        <strong>Total Amount:</strong> ${{ number_format($order->total_amount, 2) }}
    </div>

    <div class="mb-3">
        <strong>Created At:</strong> {{ $order->created_at->format('Y-m-d H:i') }}
    </div>

    <a href="{{ route('orders.index') }}" class="btn btn-secondary">Back to List</a>
    <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-primary">Edit Order</a>
</div>
@endsection
