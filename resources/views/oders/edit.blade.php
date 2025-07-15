
/* ───────────── resources/views/pages/orders/edit.blade.php ───────────── */
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Edit Order</h2>
    <form method="POST" action="{{ route('orders.update', $order->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="buyer_id" class="form-label">Buyer</label>
            <select name="buyer_id" id="buyer_id" class="form-control" required>
                @foreach ($buyers as $buyer)
                    <option value="{{ $buyer->id }}" {{ $buyer->id == $order->buyer_id ? 'selected' : '' }}>
                        {{ $buyer->fullname }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control" required>
                @foreach ($statuses as $status)
                    <option value="{{ $status }}" {{ $status == $order->status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="total_amount" class="form-label">Total Amount</label>
            <input type="number" name="total_amount" id="total_amount" class="form-control" step="0.01" value="{{ $order->total_amount }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection