@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-4">
                <h4 class="mb-4 fw-bold">🌾 Add New Crop</h4>

                <form action="{{ route('crops.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Name --}}
                    <div class="mb-3">
                        <label for="name" class="form-label">Crop Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control" required placeholder="e.g. Tomato" value="{{ old('name') }}">
                    </div>

                    {{-- Crop Type --}}
                    <div class="mb-3">
                        <label for="crop_type_id" class="form-label">Crop Type <span class="text-danger">*</span></label>
                        <select name="crop_type_id" id="crop_type_id" class="form-select" required>
                            <option value="">Select type</option>
                            @foreach($cropTypes as $type)
                                <option value="{{ $type->id }}" {{ old('crop_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Region --}}
                    <div class="mb-3">
                        <label for="region_id" class="form-label">Region</label>
                        <select name="region_id" id="region_id" class="form-select">
                            <option value="">Select region</option>
                            @foreach($regions as $region)
                                <option value="{{ $region->id }}" {{ old('region_id') == $region->id ? 'selected' : '' }}>{{ $region->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Description --}}
                    <div class="mb-3">
                        <label for="description" class="form-label">Description (Optional)</label>
                        <textarea name="description" id="description" class="form-control" rows="3" placeholder="Short description...">{{ old('description') }}</textarea>
                    </div>

                    {{-- Image Upload --}}
                    <div class="mb-3">
                        <label for="image" class="form-label">Crop Image (Optional)</label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/*">
                    </div>

                    {{-- Unit --}}
                    <div class="mb-3">
                        <label for="unit" class="form-label">Unit <span class="text-danger">*</span></label>
                        <select name="unit" id="unit" class="form-select" required>
                            <option value="">Select Unit</option>
                            <option value="kg" {{ old('unit') == 'kg' ? 'selected' : '' }}>Kilogram (kg)</option>
                            <option value="litre" {{ old('unit') == 'litre' ? 'selected' : '' }}>Litre (L)</option>
                            <option value="piece" {{ old('unit') == 'piece' ? 'selected' : '' }}>Piece</option>
                        </select>
                    </div>

                    {{-- Quantity for KG --}}
                    <div class="mb-3 quantity-group" id="kg-group" style="display: none;">
                        <label for="kg" class="form-label">Quantity (kg) <span class="text-danger">*</span></label>
                        <input type="number" name="kg" id="kg" class="form-control" min="1" placeholder="Enter in kilograms" value="{{ old('kg') }}">
                    </div>

                    {{-- Quantity for Litre --}}
                    <div class="mb-3 quantity-group" id="litre-group" style="display: none;">
                        <label for="litre" class="form-label">Quantity (litres) <span class="text-danger">*</span></label>
                        <input type="number" name="litre" id="litre" class="form-control" min="1" placeholder="Enter quantity in litres" value="{{ old('litre') }}">
                    </div>

                    {{-- Quantity for Piece --}}
                    <div class="mb-3 quantity-group" id="piece-group" style="display: none;">
                        <label for="quantity" class="form-label">Quantity (pieces) <span class="text-danger">*</span></label>
                        <input type="number" name="quantity" id="quantity" class="form-control" min="1" placeholder="Enter quantity in pieces" value="{{ old('quantity') }}">
                    </div>

                    {{-- Price --}}
                    <div class="mb-3">
                        <label for="price" class="form-label">Price (in USD) <span class="text-danger">*</span></label>
                        <input type="number" name="price" id="price" class="form-control" step="0.01" required placeholder="Enter price in USD" value="{{ old('price') }}">
                    </div>

                    {{-- Submit --}}
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('crops.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-success d-inline-flex align-items-center gap-2">
                            <i class="bi bi-check-circle-fill"></i> Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const unitSelect = document.getElementById('unit');
    const kgGroup = document.getElementById('kg-group');
    const litreGroup = document.getElementById('litre-group');
    const pieceGroup = document.getElementById('piece-group');

    function toggleQuantityGroups() {
        const selectedUnit = unitSelect.value;

        kgGroup.style.display = 'none';
        litreGroup.style.display = 'none';
        pieceGroup.style.display = 'none';

        if (selectedUnit === 'kg') {
            kgGroup.style.display = 'block';
        } else if (selectedUnit === 'litre') {
            litreGroup.style.display = 'block';
        } else if (selectedUnit === 'piece') {
            pieceGroup.style.display = 'block';
        }
    }

    unitSelect.addEventListener('change', toggleQuantityGroups);

    // Run on page load to show correct group if old value exists
    toggleQuantityGroups();
});
</script>
@endpush
