@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">➕ Add Crop Type</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('crop_types.store') }}" method="POST" class="card shadow-sm border-0 p-4 rounded-4">
        @csrf

        {{-- ▸ Name --}}
        <div class="mb-3">
            <label for="name" class="form-label fw-semibold">Name <span class="text-danger">*</span></label>
            <input type="text"
                   name="name"
                   id="name"
                   value="{{ old('name') }}"
                   class="form-control @error('name') is-invalid @enderror"
                   placeholder="e.g. Cereals">

            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- ▸ Description --}}
        <div class="mb-3">
            <label for="description" class="form-label fw-semibold">Description</label>
            <textarea name="description"
                      id="description"
                      rows="3"
                      class="form-control @error('description') is-invalid @enderror"
                      placeholder="Short description (optional)">{{ old('description') }}</textarea>

            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- ▸ Actions --}}
        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('crop_types.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-success d-inline-flex align-items-center gap-2">
                <i class="bi bi-check-circle-fill"></i> Save
            </button>
        </div>
    </form>
</div>
@endsection
