@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row align-items-end mb-3 gy-2">
        {{-- Example future filters
        <div class="col-sm-3">
            <label class="form-label">Filter by Status</label>
            <select id="statusFilter" class="form-select">
                <option value="">All Statuses</option>
                <option value="pending">Pending</option>
                <option value="paid">Paid</option>
                <option value="shipped">Shipped</option>
            </select>
        </div> --}}

        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('orders.create') }}" class="btn btn-success d-inline-flex align-items-center gap-2">
                <i class="bi bi-cart-plus-fill"></i> Add Order
            </a>
        </div>
    </div>

    {{-- ── Orders Table ───────────────────────────────────── --}}
    <div class="table-responsive">
        <table id="ordersTable"
               class="table table-striped table-bordered dt-responsive nowrap"
               style="width: 100%">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Buyer</th>
                    <th>Status</th>
                    <th>Total&nbsp;Amount</th>
                    <th>Created&nbsp;At</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@push('scripts')
    {{-- Bootstrap Icons --}}
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    {{-- DataTables core & responsive extension --}}
    <link rel="stylesheet"
          href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet"
          href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <script>
        $(function () {
            const table = $('#ordersTable').DataTable({
                processing : true,
                serverSide : true,
                responsive : {
                    details: { type: 'column', target: 'tr' }
                },
                ajax       : '{{ route('orders.index') }}', // controller must JSON‑return orders
                columns    : [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'buyer',       name: 'buyer.fullname' },
                    { data: 'status',      name: 'status' },
                    { data: 'total_amount',name: 'total_amount' },
                    { data: 'created_at',  name: 'created_at' },
                    { data: 'action',      name: 'action', orderable: false, searchable: false }
                ],
                columnDefs: [
                    { responsivePriority: 1, targets: 1 },   // keep buyer visible
                    { responsivePriority: 2, targets: -1 }   // keep action visible
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
                    searchPlaceholder: "Search orders..."
                }
            });

            // Example filter hooks (uncomment if you add the selects above)
            // $('#statusFilter').on('change', function () {
            //     table.column(2).search(this.value).draw();
            // });
        });
    </script>
@endpush
