@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">✏️ Edit Payment Method</h3>

    {{-- Error Messages --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('payment_methods.update', $payment_method->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Payment Method Name --}}
        <div class="mb-3">
            <label for="name" class="form-label">Payment Method Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $payment_method->name) }}" required>
        </div>

        {{-- Status --}}
        <div class="mb-4">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-select" required>
                <option value="active" {{ $payment_method->status === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $payment_method->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        {{-- Buttons --}}
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-circle"></i> Update
        </button>
        <a href="{{ route('payment_methods.index') }}" class="btn btn-secondary ms-2">
            <i class="bi bi-arrow-left"></i> Cancel
        </a>
    </form>
</div>
@endsection

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endpush
