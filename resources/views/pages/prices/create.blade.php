@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">
            <h4 class="mb-4 fw-bold">➕ Add New Price</h4>

            <form action="{{ route('prices.store') }}" method="POST">
                @csrf

                {{-- Crop --}}
                <div class="mb-3">
                    <label for="crop_id" class="form-label">Crop <span class="text-danger">*</span></label>
                    <select name="crop_id" id="crop_id" class="form-select" required>
                        <option value="">Select Crop</option>
                        @foreach($crops as $crop)
                            <option value="{{ $crop->id }}">{{ $crop->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Region --}}
                <div class="mb-3">
                    <label for="region_id" class="form-label">Region <span class="text-danger">*</span></label>
                    <select name="region_id" id="region_id" class="form-select" required>
                        <option value="">Select Region</option>
                        @foreach($regions as $region)
                            <option value="{{ $region->id }}">{{ $region->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Unit --}}
                <div class="mb-3">
                    <label for="unit" class="form-label">Unit <span class="text-danger">*</span></label>
                    <select name="unit" id="unit" class="form-select" required>
                        <option value="">Select Unit</option>
                        <option value="kg">Kilogram (kg)</option>
                        <option value="piece">Piece</option>
                        <option value="litre">Litre</option>
                    </select>
                </div>

                <div id="unit-note" class="mb-2 text-muted fw-semibold" style="display: none;"></div>

                {{-- Quantity --}}
                <div class="mb-3" id="quantity-group" style="display: none;">
                    <label for="quantity" class="form-label">Quantity <span class="text-danger">*</span></label>
                    <input type="number" name="quantity" id="quantity" class="form-control" min="1" placeholder="Enter quantity">
                </div>

                {{-- Price --}}
                <div class="mb-3">
                    <label for="price" class="form-label">Price (in USD) <span class="text-danger">*</span></label>
                            <input type="number" name="quantity" id="quantity" class="form-control" min="1" placeholder="Enter quantity">
                </div>

