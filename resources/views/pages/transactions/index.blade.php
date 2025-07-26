@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row align-items-end mb-3 gy-2">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Transactions</h4>
            {{-- Uncomment if you want a create button --}}
            {{-- <a href="{{ route('transactions.create') }}" class="btn btn-success d-inline-flex align-items-center gap-2">
                <i class="bi bi-cash-coin"></i> Create Transaction
            </a> --}}
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-3">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <table id="transactionsTable" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Crop</th>
                        <th>Order</th>
                        <th>Payment Method</th>
                        <th>Amount</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Transaction Date</th>
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
            $('#transactionsTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ route("transactions.index") }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'user', name: 'user' },
                    { data: 'crop', name: 'crop' },
                    { data: 'order', name: 'order' },
                    { data: 'payment_method', name: 'payment_method' },
                    { data: 'amount', name: 'amount' },
                    { data: 'description', name: 'description' },
                    { data: 'status', name: 'status' },
                    { data: 'transaction_date', name: 'transaction_date' }
                ],
                columnDefs: [
                    { responsivePriority: 1, targets: 1 }
                ],
                order: [[8, 'desc']], // sort by transaction_date
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
                    searchPlaceholder: "Search transactions..."
                }
            });
        });
    </script>
@endpush
