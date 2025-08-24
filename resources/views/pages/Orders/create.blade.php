@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Create Order</h1>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary d-inline-flex align-items-center gap-2">
            <i class="bi bi-arrow-left"></i> Back to Orders
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li><i class="bi bi-exclamation-triangle-fill"></i> {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('orders.store') }}" method="POST">
                @csrf

                <div class="row g-3">
                    {{-- User --}}
                    <div class="col-md-6">
                        <label for="user_id" class="form-label">User</label>
                        <select name="user_id" id="user_id" class="form-select" required>
                            <option value="">Select User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->fullname }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Crop --}}
                    <div class="col-md-6">
                        <label for="crop_id" class="form-label">Crop</label>
                        <select name="crop_id" id="crop_id" class="form-select" required>
                            <option value="">Select Crop</option>
                            @foreach($crops as $crop)
                                <option value="{{ $crop->id }}">{{ $crop->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Payment --}}
                    <div class="col-md-6">
                        <label for="payment_method_id" class="form-label">Payment Method</label>
                        <select name="payment_method_id" id="payment_method_id" class="form-select">
                            <option value="">Select Payment</option>
                            @foreach($payments as $payment)
                                <option value="{{ $payment->id }}">{{ $payment->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Status --}}
                    <div class="col-md-6">
                        <label for="status" class="form-label">Order Status</label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="">Select Status</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Delivery Status --}}
                    <div class="col-md-6">
                        <label for="delivery_status" class="form-label">Delivery Status</label>
                        <select name="delivery_status" id="delivery_status" class="form-select" required>
                            <option value="">Select Delivery Status</option>
                            @foreach($deliveryStatuses as $dstatus)
                                <option value="{{ $dstatus }}">{{ ucfirst($dstatus) }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Total Amount --}}
                    <div class="col-md-6">
                        <label for="total_amount" class="form-label">Total Amount</label>
                        <input type="number" name="total_amount" id="total_amount" class="form-control" min="0" step="0.01" required>
                    </div>

                    {{-- Description --}}
                    <div class="col-12">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                    </div>

                    {{-- Submit --}}
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-plus-circle"></i> Create Order
                        </button>
                        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endpush
