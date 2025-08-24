@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Order #{{ $order->id }}</h4>

    <div class="card shadow-sm rounded-3">
        <div class="card-body">

            {{-- Buyer & Payment --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <p class="mb-1 text-muted">Buyer:</p>
                    <h6>{{ $order->user->fullname ?? '—' }}</h6>
                </div>
                <div class="col-md-6">
                    <p class="mb-1 text-muted">Payment Method:</p>
                    <h6>{{ $order->paymentMethod->name ?? '—' }}</h6>
                </div>
            </div>

            {{-- Items --}}
            <div class="mb-3">
                <p class="mb-1 text-muted">Items:</p>
                @if($order->items->count())
                    <ul class="list-group list-group-flush">
                        @foreach($order->items as $item)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $item->crop->name ?? $item->name }} 
                                <span class="badge bg-primary">
                                    {{ $item->quantity }} × ${{ number_format($item->price, 2) }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <h6>—</h6>
                @endif
            </div>

            {{-- Status & Delivery --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <p class="mb-1 text-muted">Status:</p>
                    <h6>
                        <span class="badge bg-{{ 
                            $order->status === 'completed' ? 'success' : 
                            ($order->status === 'pending' ? 'warning text-dark' : 
                            ($order->status === 'cancelled' ? 'danger' : 'secondary')) }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </h6>
                </div>
                <div class="col-md-6">
                    <p class="mb-1 text-muted">Delivery Status:</p>
                    <h6>
                        <span class="badge bg-{{ $order->delivery_status === 'delivered' ? 'success' : 'danger' }}">
                            {{ ucfirst($order->delivery_status) }}
                        </span>
                    </h6>
                </div>
            </div>

            {{-- Amount & Dates --}}
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

            {{-- Description --}}
            <div class="mb-3">
                <p class="mb-1 text-muted">Description:</p>
                <h6>{{ $order->description ?? '—' }}</h6>
            </div>
        </div>
    </div>

    <a href="{{ route('orders.index') }}" class="btn btn-secondary mt-3">Back to Orders</a>
</div>
@endsection
