@extends('layouts.app')

@section('title', 'Price History')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0 text-primary fw-bold">📊 Price History Report</h3>
        <div>
            <a href="{{ route('price_history.report') }}" target="_blank" class="btn btn-outline-primary me-2 shadow-sm">
                <i class="bi bi-file-earmark-pdf-fill me-1"></i> Export PDF
            </a>
            <button id="resetFilters" class="btn btn-outline-danger shadow-sm">
                <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Filters
            </button>
        </div>
    </div>

    {{-- Filter Form --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="crop_id" class="form-label text-muted">Filter by Crop</label>
                    <select id="crop_id" class="form-select shadow-sm">
                        <option value="">All Crops</option>
                        @foreach($crops as $crop)
                            <option value="{{ $crop->id }}">{{ $crop->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="region_id" class="form-label text-muted">Filter by Region</label>
                    <select id="region_id" class="form-select shadow-sm">
                        <option value="">All Regions</option>
                        @foreach($regions as $region)
                            <option value="{{ $region->id }}">{{ $region->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label text-muted">Date Range</label>
                    <div class="input-group shadow-sm">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-calendar-date text-primary"></i>
                        </span>
                        <input type="date" id="from_date" class="form-control border-start-0" placeholder="From">
                        <span class="input-group-text bg-white">to</span>
                        <input type="date" id="to_date" class="form-control" placeholder="To">
                        <button class="btn btn-outline-secondary" type="button" id="clearDateRange" title="Clear Date Range">
                            <i class="bi bi-x-circle-fill"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Data Table --}}
    <div class="card border-0 shadow-lg">
        <div class="card-body">
            <table id="priceHistoryTable" class="table table-hover table-bordered table-striped align-middle text-center nowrap w-100">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Crop</th>
                        <th>Region</th>
                        <th>Quantity</th>
                        <th>Unit</th>
                        <th>Price</th>
                        <th>Date</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@push('styles')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<!-- Custom CSS -->
<style>
    /* Table header style */
    table.dataTable thead th {
        font-weight: 600;
        color: #004085;
        background-color: #cfe2ff !important; /* Bootstrap primary lighter */
        border-bottom: 2px solid #002752 !important;
    }

    /* Table body rows */
    table.dataTable tbody td {
        vertical-align: middle;
        color: #212529;
    }

    /* Zebra striping */
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f9fbfd;
    }

    /* Hover effect */
    .table-hover tbody tr:hover {
        background-color: #eef3f7;
        cursor: pointer;
    }

    /* Rounded cards */
    .card {
        border-radius: 12px;
    }

    /* Input group icons */
    .input-group-text {
        color: #0d6efd;
    }

    /* Buttons shadow */
    .btn.shadow-sm {
        box-shadow: 0 2px 6px rgb(13 110 253 / 0.25);
        transition: box-shadow 0.3s ease-in-out;
    }

    .btn.shadow-sm:hover {
        box-shadow: 0 4px 12px rgb(13 110 253 / 0.5);
    }

    /* Label muted */
    .form-label.text-muted {
        color: #6c757d !important;
        font-weight: 500;
    }
</style>
@endpush



@push('scripts')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<script>
$(document).ready(function () {
    const table = $('#priceHistoryTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "{{ route('PriceHistory.index') }}",
            data: function (d) {
                d.crop_id = $('#crop_id').val();
                d.region_id = $('#region_id').val();
                d.from_date = $('#from_date').val();
                d.to_date = $('#to_date').val();
            }
        },
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'crop', name: 'crop.name' },
            { data: 'region', name: 'region.name' },
            { data: 'quantity', name: 'quantity' },
            { data: 'unit', name: 'unit' },
            { data: 'price', name: 'price' },
            { data: 'created_at', name: 'created_at' }
        ],
        language: {
            emptyTable: "No data available for selected filters.",
            search: "_INPUT_",
            searchPlaceholder: "Search records..."
        }
    });

    // 🔁 Reload table on filters
    $('#crop_id, #region_id, #from_date, #to_date').on('change', function () {
        table.ajax.reload();
    });

    // 🔁 Reset filters
    $('#resetFilters').click(function () {
        $('#crop_id, #region_id').val('');
        $('#from_date, #to_date').val('');
        table.ajax.reload();
    });
 $('#clearDateRange').click(function () {
    $('#from_date').val('');
    $('#to_date').val('');
    $('#priceHistoryTable').DataTable().ajax.reload();
});


});
</script>
@endpush
