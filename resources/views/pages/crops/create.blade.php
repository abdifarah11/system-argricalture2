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
                    <input type="text" name="name" id="name" class="form-control" required placeholder="e.g. Tomato">
                </div>

                {{-- Crop Type --}}
                <div class="mb-3">
                    <label for="crop_type_id" class="form-label">Crop Type <span class="text-danger">*</span></label>
                    <select name="crop_type_id" id="crop_type_id" class="form-select" required>
                        <option value="">Select type</option>
                        @foreach($cropTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Region --}}
                <div class="mb-3">
                    <label for="region_id" class="form-label">Region</label>
                    <select name="region_id" id="region_id" class="form-select">
                        <option value="">Select region</option>
                        @foreach($regions as $region)
                            <option value="{{ $region->id }}">{{ $region->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Description --}}
                <div class="mb-3">
                    <label for="description" class="form-label">Description (Optional)</label>
                    <textarea name="description" id="description" class="form-control" rows="3" placeholder="Short description..."></textarea>
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
                            <input type="price" name="price" id="price" class="form-control" min="1" placeholder="Enter price">
                </div>
                {{-- Submit --}}
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-success px-4 py-2">
                        <i class="bi bi-save me-1"></i> Save Crop
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

    unitSelect.addEventListener('change', function () {
        const unit = this.value;
        quantityGroup.style.display = unit ? 'block' : 'none';
        unitNote.style.display = unit ? 'block' : 'none';

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
    });
});
</script>
@endpush
