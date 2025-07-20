@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row align-items-end mb-3 gy-2">
        {{-- <div class="col-sm-3">
            <label class="form-label">Filter by Region</label>
            <select id="regionFilter" class="form-select">
                <option value="">All Regions</option>
                @foreach ($regions as $region)
                    <option value="{{ $region->name }}">{{ $region->name }}</option>
                @endforeach
            </select>
        </div> --}}

        {{-- <div class="col-sm-3">
            <label class="form-label">Filter by User Type</label>
            <select id="typeFilter" class="form-select">
                <option value="">All Types</option>
                @foreach ($userTypes as $type)
                    <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                @endforeach
            </select>
        </div> --}}
{{--  --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('users.create') }}" class="btn btn-success d-inline-flex align-items-center gap-2">
                <i class="bi bi-person-plus-fill"></i> Add User
            </a>
        </div>
    </div>

    {{-- ── Users Table ───────────────────────────────────────── --}}
    <div class="table-responsive">
        <table id="usersTable" class="table table-striped table-bordered dt-responsive nowrap" style="width: 100%">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Full Name</th>
                      <th>username</th>
                    <th>Email</th>
                    <th>rule User</th>
                    <th>Region</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@push('scripts')
    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    {{-- DataTables core & extensions --}}
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
                responsive: {
                    details: {
                        type: 'column',
                        target: 'tr'
                    }
                },
                ajax: '{{ route('users.index') }}', // This should return JSON for users
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'fullname', name: 'fullname' },
                    { data: 'username', name: 'username' },
                    { data: 'email', name: 'email' },
                    { data: 'user_type', name: 'user_type' },
                    { data: 'region',     name: 'regions.name' }, // display “region”, sort on DB fiel
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                columnDefs: [
                    { responsivePriority: 1, targets: 1 },
                    { responsivePriority: 2, targets: -1 }
                ],
                dom: `<"row align-items-start mb-3"
                        <"col-md-6 col-sm-12"l>
                        <"col-md-6 col-sm-12 text-md-end text-sm-start"f>
                    >
                    <"row"<"col-sm-12"tr>>
                    <"row mt-2"
                        <"col-md-5 col-sm-12"i>
                        <"col-md-7 col-sm-12 text-md-end text-sm-start"p>
                    >`,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search users..."
                }
            });

            $('#regionFilter').on('change', function () {
                table.column(4).search(this.value).draw();
            });

            $('#typeFilter').on('change', function () {
                table.column(3).search(this.value).draw();
            });
        });
    </script>
@endpush
