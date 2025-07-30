@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4"> {{-- Changed to full-width --}}
        <div class="row align-items-end mb-3 gy-2">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="mb-0">Crop Types</h1>
                <a href="{{ route('crop_types.create') }}" class="btn btn-success d-inline-flex align-items-center gap-2">
                    <i class="bi bi-plus-circle"></i> Add New Crop Type
                </a>
            </div>
        </div>

        {{-- ✅ Filter --}}
        <div class="row mb-3">
            <div class="col-md-4">
                <select id="typeFilter" class="form-select">
                    <option value="">All Crop Types</option>
                    @foreach($allTypes as $type)
                        <option value="{{ $type->name }}">{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body">
                <table class="table table-striped table-bordered dt-responsive nowrap" id="cropTypesTable"
                    style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Image</th>
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
            var table = $('#cropTypesTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('crop_types.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'name', name: 'name' },
                    { data: 'description', name: 'description' },
                    {
                        data: 'image',
                        name: 'image',
                        orderable: false,
                        searchable: false
                    },
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
                    searchPlaceholder: "Search crop types..."
                }
            });

            // ✅ Filter event
            $('#typeFilter').on('change', function () {
                table.column(1).search(this.value).draw();
            });
        });
    </script>
@endpush
