@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4"> {{-- Changed to full-width --}}
    <!-- Top Bar -->
    <div class="row align-items-end mb-3 gy-2">
        <div class="d-flex justify-content-between align-items-center mb-4">
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
    <div class="row mb-3">
        <div class="col-md-4">
            <select id="regionFilter" class="form-select">
                <option value="">All Regions</option>
                @foreach($regions as $region)
                    <option value="{{ $region->name }}">{{ $region->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <select id="typeFilter" class="form-select">
                <option value="">All Roles</option>
                @foreach($userTypes as $type)
                    <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table id="usersTable" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Email</th>
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
    var table = $('#usersTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: '{{ route('users.index') }}',
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'fullname', name: 'fullname' },
            { data: 'username', name: 'username' },
            { data: 'email', name: 'email' },
            { data: 'role', name: 'role' },
            { data: 'region', name: 'regions.name' },
            { data: 'created_at', name: 'created_at' },
            { data: 'action', orderable: false, searchable: false }
        ],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search users..."
        }
    });

    $('#regionFilter').on('change', function () {
        table.column(5).search(this.value).draw();
    });

    $('#typeFilter').on('change', function () {
        table.column(4).search(this.value).draw();
    });
});
</script>
@endpush
