@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Price History</h4>
            {{-- Uncomment if you want a create button --}}
            {{-- <a href="{{ route('price_history.create') }}" class="btn btn-success d-inline-flex align-items-center gap-2">
                <i class="bi bi-clock-history"></i> Add Price History
            </a> --}}
        </div>

        @if (session('success'))
            <div class="alert alert-success mb-3">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table id="priceHistoryTable" class="table table-striped table-bordered dt-responsive nowrap" style="width: 100%">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Crop</th>
                        <th>Region</th>
                        <th>Price</th>
                        <th>Unit</th>
                        <th>Quantity</th>
                        <th>Date</th>
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
            $('#priceHistoryTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: {
                    details: {
                        type: 'column',
                        target: 'tr'
                    }
                },
                ajax: '{{ route('PriceHistory.index') }}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'crop', name: 'crop' },
                    { data: 'region', name: 'region' },
                    { data: 'price', name: 'price' },
                    { data: 'unit', name: 'unit' },
                    { data: 'quantity', name: 'quantity' },
                    { data: 'created_at', name: 'created_at' }
                ],
                columnDefs: [
                    { responsivePriority: 1, targets: 1 }
                ],
                order: [[6, 'desc']],  // Sort by Date descending (7th column, index 6)
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
                    searchPlaceholder: "Search price history..."
                }
            });
        });
    </script>
@endpush
