@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">✏️ Edit Crop Type</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('crop_types.update', $cropType->id) }}" method="POST" enctype="multipart/form-data" class="card shadow-sm border-0 p-4 rounded-4">
        @csrf
        @method('PUT')

        {{-- ▸ Name --}}
        <div class="mb-3">
            <label for="name" class="form-label fw-semibold">Name <span class="text-danger">*</span></label>
            <input type="text"
                   name="name"
                   id="name"
                   value="{{ old('name', $cropType->name) }}"
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
                      placeholder="Short description (optional)">{{ old('description', $cropType->description) }}</textarea>

            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- ▸ Current Image Preview --}}
        @if ($cropType->image)
            <div class="mb-3">
                <label class="form-label fw-semibold">Current Image</label>
                <div>
                    <img src="{{ asset('storage/' . $cropType->image) }}" alt="{{ $cropType->name }}" style="max-width: 200px; border-radius: 6px;">
                </div>
            </div>
        @endif

        {{-- ▸ Image Upload --}}
        <div class="mb-3">
            <label for="image" class="form-label fw-semibold">Upload New Image (optional)</label>
            <input type="file"
                   name="image"
                   id="image"
                   accept="image/*"
                   class="form-control @error('image') is-invalid @enderror">

            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- ▸ Actions --}}
        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('crop_types.index') }}" class="btn btn-secondary">Back</a>
            <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-2">
                <i class="bi bi-save2-fill"></i> Update
            </button>
        </div>
    </form>
</div>
@endsection
