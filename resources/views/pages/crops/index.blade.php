@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row align-items-end mb-3 gy-2">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('crops.create') }}" class="btn btn-success d-inline-flex align-items-center gap-2">
                <i class="bi bi-plus-circle"></i> Add New Crop
            </a>
        </div>
    </div>

    {{-- ✅ Filters --}}
    <div class="card mb-3">
        <div class="card-body">
            <div class="row gy-2">
                <div class="col-md-3">
                    <select id="regionFilter" class="form-select">
                        <option value="">All Regions</option>
                        @foreach($regions as $region)
                            <option value="{{ $region->name }}">{{ $region->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <select id="typeFilter" class="form-select">
                        <option value="">All Crop Types</option>
                        @foreach($cropTypes as $type)
                            <option value="{{ $type->name }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 d-flex gap-2">
                    <button type="button" class="btn btn-primary w-50" id="applyFilters">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                    <button type="button" class="btn btn-secondary w-50" id="resetFilters">
                        <i class="bi bi-arrow-repeat"></i> Reset
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ✅ Flash Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ✅ Table --}}
    <div class="card">
        <div class="card-body">
            <table id="crops-table" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Region</th>
                        <th>Added By</th>
                        <th>Created At</th>
                        <th>Actions</th>
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
    var table = $('#crops-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: '{{ route('crops.index') }}',
            data: function (d) {
                d.region = $('#regionFilter').val();
                d.type   = $('#typeFilter').val();
            }
        },
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            {
                data: 'image',
                orderable: false,
                searchable: false,
                render: function (data) {
                    if (data) {
                        return `<img src="/storage/${data}" alt="Crop Image" style="height:40px;width:auto;border-radius:4px;" />`;
                    }
                    return 'not found';
                }
            },
            { data: 'name', name: 'name' },
            { data: 'cropType', name: 'cropType.name' },
            { data: 'region', name: 'region.name' },
            { data: 'user', name: 'user.fullname' },
            { data: 'created_at', name: 'created_at' },
            { data: 'action', orderable: false, searchable: false }
        ],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search crops..."
        }
    });

    // ✅ Apply Filters
    $('#applyFilters').on('click', function () {
        table.draw();
    });

    // ✅ Reset Filters
    $('#resetFilters').on('click', function () {
        $('#regionFilter').val('');
        $('#typeFilter').val('');
        table.draw();
    });
});
</script>
@endpush
