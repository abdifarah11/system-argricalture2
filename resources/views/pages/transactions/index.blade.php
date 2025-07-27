@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row align-items-end mb-3 gy-2">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Transactions</h1>
        </div>
    </div>

    {{-- ✅ Filter Dropdowns --}}
    <div class="row mb-3">
        <div class="col-md-4">
            <select id="statusFilter" class="form-select">
                <option value="">All Statuses</option>
                @foreach($statuses as $status)
                    <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <select id="paymentMethodFilter" class="form-select">
                <option value="">All Payment Methods</option>
                @foreach($paymentMethods as $method)
                    <option value="{{ $method->name }}">{{ $method->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <table id="transactionsTable" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Crop</th>
                        <th>Order</th>
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
    var table = $('#transactionsTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "{{ route('transactions.index') }}",
            data: function (d) {
                d.status = $('#statusFilter').val();
                d.payment_method = $('#paymentMethodFilter').val();
            }
        },
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'user', name: 'user.name' },
            { data: 'crop', name: 'crop.name' },
            { data: 'order', name: 'order.id' },
            { data: 'payment_method', name: 'paymentMethod.name' },
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

    $('#statusFilter, #paymentMethodFilter').on('change', function () {
        table.draw();
    });
});
</script>
@endpush
