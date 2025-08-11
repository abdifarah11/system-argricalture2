@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4 px-2 px-md-4">

    <!-- Top Bar -->
    <div class="row align-items-end mb-3 gy-2">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
            <a href="{{ route('users.create') }}" class="btn btn-success d-inline-flex align-items-center gap-2">
                <i class="bi bi-person-plus-fill"></i> Add User
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
            <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Filters -->
    <div class="row mb-3 g-3">
        <div class="col-12 col-md-4 mb-3 mb-md-0">
            <select id="regionFilter" class="form-select" aria-label="Filter by Region">
                <option value="">All Regions</option>
                @foreach($regions as $region)
                    <option value="{{ $region->name }}">{{ $region->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-12 col-md-4 mb-3 mb-md-0">
            <select id="typeFilter" class="form-select" aria-label="Filter by Role">
                <option value="">All Roles</option>
                @foreach($userTypes as $type)
                    <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Table responsive with scrollX -->
    <div class="table-responsive">
        <table id="usersTable" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Region</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

</div>
@endsection

@push('scripts')
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

<!-- jQuery and DataTables JS -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<script>
$(function () {
    var table = $('#usersTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        scrollX: true,  // enable horizontal scroll for small screens
        ajax: {
            url: '{{ route('users.index') }}',
            data: function (d) {
                d.region = $('#regionFilter').val();
                d.role = $('#typeFilter').val();
            }
        },
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'fullname', name: 'fullname' },
            { data: 'email', name: 'email' },
            { data: 'phone', name: 'phone' },
            { data: 'role', name: 'role' },
            { data: 'region', name: 'regions.name' },
            { data: 'created_at', name: 'created_at' },
            { data: 'action', orderable: false, searchable: false }
        ],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search users...",
            paginate: {
                previous: "<i class='bi bi-chevron-left'></i>",
                next: "<i class='bi bi-chevron-right'></i>"
            }
        },
        dom:
          "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" + // length and search on same row, responsive
          "<'table-responsive'tr>" + 
          "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",  // info and pagination on bottom row, responsive
    });

    $('#regionFilter, #typeFilter').on('change', function () {
        table.draw();
    });
});
</script>
@endpush
