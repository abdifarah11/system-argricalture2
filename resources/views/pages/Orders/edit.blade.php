@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Edit Order #{{ $order->id }}</h4>

    <form action="{{ route('orders.update', $order) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Buyer --}}
        <div class="mb-3">
            <label for="user_id" class="form-label">User</label>
            <select name="user_id" id="user_id" class="form-select" required>
                <option value="">Select user</option>
                <option value="1" {{ $order->user_id == 1 ? 'selected' : '' }}>John Doe</option>
                <option value="2" {{ $order->user_id == 2 ? 'selected' : '' }}>Jane Smith</option>
            </select>
        </div>

        {{-- Crop --}}
        <div class="mb-3">
            <label for="crop_id" class="form-label">Crop</label>
            <select name="crop_id" id="crop_id" class="form-select" required>
                <option value="">Select crop</option>
                <option value="1" {{ $order->crop_id == 1 ? 'selected' : '' }}>Maize</option>
                <option value="2" {{ $order->crop_id == 2 ? 'selected' : '' }}>Sorghum</option>
            </select>
        </div>

        {{-- Payment Method --}}
        <div class="mb-3">
            <label for="payment_method_id" class="form-label">Payment Method</label>
            <select name="payment_method_id" id="payment_method_id" class="form-select">
                <option value="">None</option>
                <option value="1" {{ $order->payment_method_id == 1 ? 'selected' : '' }}>Cash</option>
                <option value="2" {{ $order->payment_method_id == 2 ? 'selected' : '' }}>Mobile Money</option>
            </select>
        </div>

        {{-- Status --}}
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select" required>
                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>

        {{-- Total Amount --}}
        <div class="mb-3">
            <label for="total_amount" class="form-label">Total Amount</label>
            <input type="number" name="total_amount" id="total_amount" class="form-control" step="0.01" min="0"
                value="{{ $order->total_amount }}" required>
        </div>

        {{-- Description --}}
        <div class="mb-3">
            <label for="description" class="form-label">Description (optional)</label>
            <textarea name="description" id="description" class="form-control" rows="3">{{ $order->description }}</textarea>
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn btn-primary">Update Order</button>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
