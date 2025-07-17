@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Edit Order #{{ $order->id }}</h4>

    <form action="{{ route('orders.update', $order) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- user --}}
        <div class="mb-3">
            <label for="user_id" class="form-label">user</label>
            <select name="user_id" id="user_id" class="form-select" required>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ $order->user_id == $user->id ? 'selected' : '' }}>
                        {{ $user->fullname }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Crop --}}
        <div class="mb-3">
            <label for="crop_id" class="form-label">Crop</label>
            <select name="crop_id" id="crop_id" class="form-select" required>
                @foreach ($crops as $crop)
                    <option value="{{ $crop->id }}" {{ $order->crop_id == $crop->id ? 'selected' : '' }}>
                        {{ $crop->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Payment Method --}}
        <div class="mb-3">
            <label for="payment_method_id" class="form-label">Payment Method</label>
            <select name="payment_method_id" id="payment_method_id" class="form-select">
                <option value="">None</option>
                @foreach ($payments as $method)
                    <option value="{{ $method->id }}" {{ $order->payment_method_id == $method->id ? 'selected' : '' }}>
                        {{ $method->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Status --}}
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select" required>
                @foreach ($statuses as $status)
                    <option value="{{ $status }}" {{ $order->status == $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
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
