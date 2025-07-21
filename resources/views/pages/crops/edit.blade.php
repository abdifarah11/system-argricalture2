@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">✏️ Edit Crop</h3>

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

    <form action="{{ route('crops.update', $crop->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Crop Name --}}
        <div class="mb-3">
            <label for="name" class="form-label">Crop Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $crop->name) }}" required>
        </div>

        {{-- Crop Type --}}
        <div class="mb-3">
            <label for="crop_type_id" class="form-label">Crop Type</label>
            <select name="crop_type_id" id="crop_type_id" class="form-select" required>
                <option value="">-- Select Type --</option>
                @foreach ($cropTypes as $type)
                    <option value="{{ $type->id }}" {{ (old('crop_type_id', $crop->crop_type_id) == $type->id) ? 'selected' : '' }}>
                        {{ $type->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Region --}}
        <div class="mb-3">
            <label for="region_id" class="form-label">Region (Optional)</label>
            <select name="region_id" id="region_id" class="form-select">
                <option value="">-- Select Region --</option>
                @foreach ($regions as $region)
                    <option value="{{ $region->id }}" {{ (old('region_id', $crop->region_id) == $region->id) ? 'selected' : '' }}>
                        {{ $region->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Existing Image --}}
        @if ($crop->image)
            <div class="mb-3">
                <label class="form-label">Current Image:</label><br>
                <img src="{{ asset('storage/' . $crop->image) }}" alt="Crop Image" width="150" class="img-thumbnail">
            </div>
        @endif

        {{-- New Image --}}
        <div class="mb-3">
            <label for="image" class="form-label">Change Image (Optional)</label>
            <input type="file" name="image" id="image" class="form-control" accept="image/*">
        </div>

        {{-- Description --}}
        <div class="mb-4">
            <label for="description" class="form-label">Description (Optional)</label>
            <textarea name="description" id="description" rows="4" class="form-control">{{ old('description', $crop->description) }}</textarea>
        </div>

        {{-- Buttons --}}
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-pencil-square"></i> Update Crop
        </button>
        <a href="{{ route('crops.index') }}" class="btn btn-secondary ms-2">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </form>
</div>
@endsection

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endpush
