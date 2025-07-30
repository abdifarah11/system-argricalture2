@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4"> {{-- Changed to full-width --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold">Prices List</h4>
                <a href="{{ route('crops.create') }}" class="btn btn-success">
                    <i class="bi bi-plus-circle me-1"></i> Add Price
                </a>
            </div>

            <table id="prices-table" class="table table-bordered table-striped dt-responsive nowrap w-100">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Crop</th>
                        <th>Region</th>
                        <th>Unit</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Created At</th>
                        <th>Action</th>
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
            var table = $('#prices-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ route('crops.index') }}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'crop.name', name: 'crop.name' },
                    { data: 'region.name', name: 'region.name' },
                    { data: 'unit', name: 'unit' },
                    { data: 'quantity', name: 'quantity' },
                    { data: 'price', name: 'price' },
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
                    searchPlaceholder: "Search prices..."
                }
            });
        });
    </script>
@endpush
