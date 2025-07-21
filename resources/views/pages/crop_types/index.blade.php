@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Crop Types</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('crop_types.create') }}" class="btn btn-primary mb-3">
        <i class="bi bi-plus-circle"></i> Add New Crop Type
    </a>

    <table class="table table-bordered" id="cropTypesTable" style="width:100%">
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

{{-- DataTables & jQuery scripts --}}
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet" />
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>
$(function () {
    $('#cropTypesTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('crop_types.index') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'description', name: 'description' },
            { data: 'image', name: 'image', orderable: false, searchable: false },
            { data: 'created_at', name: 'created_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        columnDefs: [
            { responsivePriority: 1, targets: 1 },  // Name column priority
            { responsivePriority: 2, targets: -1 }  // Actions column priority
        ],
        dom:
           `<"row align-items-start mb-3"
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
});
</script>
@endpush
@endsection
