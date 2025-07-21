@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card border-0 shadow-lg rounded-4">
        <div class="card-header bg-gradient bg-success text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">🌾 Crop Details</h4>
            <a href="{{ route('crops.index') }}" class="btn btn-light btn-sm text-success fw-semibold">
                ← Back to List
            </a>
        </div>

        <div class="card-body bg-light px-5 py-4">
            <div class="row mb-3">
                {{-- Crop Name --}}
                <div class="col-md-6 mb-3">
                    <h5 class="text-muted">🌿 Name:</h5>
                    <p class="fs-5 fw-semibold text-dark">{{ $crop->name }}</p>
                </div>

                {{-- Crop Type --}}
                <div class="col-md-6 mb-3">
                    <h5 class="text-muted">🔖 Type:</h5>
                    <p class="fs-5 fw-semibold text-dark">{{ $crop->cropType->name ?? 'N/A' }}</p>
                </div>

                {{-- Unit (if exists) --}}
                @if (!empty($crop->unit))
                    <div class="col-md-6 mb-3">
                        <h5 class="text-muted">⚖️ Unit:</h5>
                        <p class="fs-5 fw-semibold text-dark">{{ $crop->unit }}</p>
                    </div>
                @endif

                {{-- Crop Image --}}
                @if (!empty($crop->image))
                    <div class="col-md-12 mb-3">
                        <h5 class="text-muted">🖼️ Crop Image:</h5>
                        <img src="{{ asset('storage/' . $crop->image) }}"
                             alt="Crop Image"
                             class="img-fluid rounded shadow-sm border border-2"
                             style="max-width: 250px;">
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
