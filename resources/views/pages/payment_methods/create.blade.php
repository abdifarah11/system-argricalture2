@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Add New Payment Method</h2>

    <form action="{{ route('payment_methods.store') }}" method="POST">
        @csrf

        {{-- Name Field --}}
        <div class="mb-3">
            <label for="name" class="form-label">Payment Method Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Status Field --}}
        <div class="mb-3">
            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
            <select name="status" class="form-select" required>
                <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            @error('status')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Buttons --}}
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('payment_methods.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
