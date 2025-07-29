@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Transactions</h1>
    </div>

    {{-- ✅ Filters --}}
    <div class="row mb-3">
        <div class="col-md-4">
            <select id="status_filter" class="form-select">
                <option value="">All Statuses</option>
                @foreach($statuses as $status)
                    <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <select id="payment_method_filter" class="form-select">
                <option value="">All Payment Methods</option>
                @foreach($paymentMethods as $method)
                    <option value="{{ $method->name }}">{{ ucfirst($method->name) }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4 d-flex gap-2">
            <button id="apply_filters" class="btn btn-primary">Filter</button>
            <button id="reset_filters" class="btn btn-secondary">Reset</button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <table id="transactions_table" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Customer</th>
                        <th>Order Items</th>
                        <th>Payment Method</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Transaction Date</th>
                        <th>Description</th>
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
    var table = $('#transactions_table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "{{ route('transactions.index') }}",
            data: function (d) {
                d.status = $('#status_filter').val();
                d.payment_method = $('#payment_method_filter').val();
            }
        },
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'customer', name: 'customer' },
            { data: 'order_items', name: 'order_items' },
            { data: 'payment_method', name: 'payment_method' },
            { data: 'amount', name: 'amount' },
            { data: 'status', name: 'status' },
            { data: 'transaction_date', name: 'transaction_date' },
            { data: 'description', name: 'description' }
        ],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search transactions..."
        }
    });

    $('#apply_filters').on('click', function () {
        table.draw();
    });

    $('#reset_filters').on('click', function () {
        $('#status_filter').val('');
        $('#payment_method_filter').val('');
        table.draw();
    });
});
</script>
@endpush
