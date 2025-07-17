@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Create New Order</h4>

    <form action="{{ route('orders.store') }}" method="POST">
        @csrf

        {{-- Buyer --}}
        <div class="mb-3">
            <label for="user_id" class="form-label">User</label>
            <select name="user_id" id="user_id" class="form-select" required>
                <option value="">Select user</option>
                <!-- Replace with actual user IDs manually if needed -->
                <option value="1">John Doe</option>
                <option value="2">Jane Smith</option>
            </select>
        </div>

        {{-- Crop --}}
        <div class="mb-3">
            <label for="crop_id" class="form-label">Crop</label>
            <select name="crop_id" id="crop_id" class="form-select" required>
                <option value="">Select crop</option>
                <option value="1">Maize</option>
                <option value="2">Sorghum</option>
            </select>
        </div>

        {{-- Payment Method --}}
        <div class="mb-3">
            <label for="payment_method_id" class="form-label">Payment Method</label>
            <select name="payment_method_id" id="payment_method_id" class="form-select">
                <option value="">None</option>
                <option value="1">Cash</option>
                <option value="2">Mobile Money</option>
            </select>
        </div>

        {{-- Status --}}
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select" required>
                <option value="pending">Pending</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>

        {{-- Total Amount --}}
        <div class="mb-3">
            <label for="total_amount" class="form-label">Total Amount</label>
            <input type="number" name="total_amount" id="total_amount" class="form-control" step="0.01" min="0" required>
        </div>

        {{-- Description --}}
        <div class="mb-3">
            <label for="description" class="form-label">Description (optional)</label>
            <textarea name="description" id="description" class="form-control" rows="3"></textarea>
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn btn-primary">Create Order</button>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
