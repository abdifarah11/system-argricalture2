@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">
            <h4 class="mb-4 fw-bold">Edit Price</h4>

            <form action="{{ route('prices.update', $price->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Crop --}}
                <div class="mb-3">
                    <label for="crop_id" class="form-label">Crop <span class="text-danger">*</span></label>
                    <select name="crop_id" id="crop_id" class="form-select" required>
                        <option value="">Select crop</option>
                        @foreach($crops as $crop)
                            <option value="{{ $crop->id }}" {{ $price->crop_id == $crop->id ? 'selected' : '' }}>{{ $crop->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Region --}}
                <div class="mb-3">
                    <label for="region_id" class="form-label">Region <span class="text-danger">*</span></label>
                    <select name="region_id" id="region_id" class="form-select" required>
                        <option value="">Select region</option>
                        @foreach($regions as $region)
                            <option value="{{ $region->id }}" {{ $price->region_id == $region->id ? 'selected' : '' }}>{{ $region->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Unit --}}
                <div class="mb-3">
                    <label for="unit" class="form-label">Unit <span class="text-danger">*</span></label>
                    <select name="unit" id="unit" class="form-select" required>
                        <option value="">Select unit</option>
                        <option value="kg" {{ $price->unit == 'kg' ? 'selected' : '' }}>Kilogram (kg)</option>
                        <option value="piece" {{ $price->unit == 'piece' ? 'selected' : '' }}>Piece</option>
                        <option value="litre" {{ $price->unit == 'litre' ? 'selected' : '' }}>Litre</option>
                    </select>
                </div>

                <div id="unit-note" class="mb-2 text-muted fw-semibold" style="display: none;"></div>

                {{-- Quantity --}}
                <div class="mb-3" id="quantity-group">
                    <label for="quantity" class="form-label">Quantity <span class="text-danger">*</span></label>
                    <input type="number" name="quantity" id="quantity" class="form-control" min="1" value="{{ $price->quantity }}">
                </div>

                {{-- Price --}}
                <div class="mb-3">
                    <label for="price" class="form-label">Price (in USD) <span class="text-danger">*</span></label>
                    <input type="number" name="price" id="price" class="form-control" step="0.01" value="{{ $price->price }}">
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary px-4 py-2">
                        <i class="bi bi-pencil-square me-1"></i> Update Price
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
    const unitNote = document.getElementById('unit-note');
    const quantityGroup = document.getElementById('quantity-group');

    function updateNote(unit) {
        unitNote.style.display = unit ? 'block' : 'none';
        quantityGroup.style.display = unit ? 'block' : 'none';

        switch (unit) {
            case 'kg':
                unitNote.innerText = "Quantity in kilograms (kg).";
                break;
            case 'piece':
                unitNote.innerText = "Quantity in pieces (e.g. 5 items).";
                break;
            case 'litre':
                unitNote.innerText = "Quantity in litres (e.g. 3 litres).";
                break;
            default:
                unitNote.innerText = "";
        }
    }

    unitSelect.addEventListener('change', function () {
        updateNote(this.value);
    });

    updateNote(unitSelect.value);
});
</script>
@endpush
