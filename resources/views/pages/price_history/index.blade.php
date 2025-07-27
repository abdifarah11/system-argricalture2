@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row align-items-end mb-3 gy-2">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Price History</h1>
        </div>
    </div>

    {{-- ✅ Filters --}}
    <div class="row mb-3">
        <div class="col-md-4">
            <select id="cropFilter" class="form-select">
                <option value="">All Crops</option>
                @foreach($crops as $crop)
                    <option value="{{ $crop->id }}">{{ $crop->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <select id="regionFilter" class="form-select">
                <option value="">All Regions</option>
                @foreach($regions as $region)
                    <option value="{{ $region->id }}">{{ $region->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table id="priceHistoryTable" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Crop</th>
                        <th>Region</th>
                        <th>Price</th>
                        <th>Unit</th>
                        <th>Quantity</th>
                        <th>Created At</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<script>
$(function () {
    var table = $('#priceHistoryTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "{{ route('PriceHistory.index') }}",
            data: function (d) {
                d.crop_id = $('#cropFilter').val();
                d.region_id = $('#regionFilter').val();
            }
        },
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'crop', name: 'crop.name' },
            { data: 'region', name: 'region.name' },
            { data: 'price', name: 'price' },
            { data: 'unit', name: 'unit' },
            { data: 'quantity', name: 'quantity' },
            { data: 'created_at', name: 'created_at' }
        ],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search price history..."
        }
    });

    $('#cropFilter, #regionFilter').on('change', function () {
        table.draw();
    });
});
</script>
@endpush
