@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4"> {{-- Changed to full-width --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Orders</h1>
        <a href="{{ route('orders.create') }}" class="btn btn-success d-inline-flex align-items-center gap-2">
            <i class="bi bi-plus-circle"></i> Add Order
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ✅ Filters --}}
    <div class="card mb-5">
        <div class="card-body">
            <div class="row gy-2">
                <div class="col-md-3">
                    <select id="statusFilter" class="form-select">
                        <option value="">All Statuses</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- <div class="col-md-3">
                    <select id="userFilter" class="form-select">
                        <option value="">All Users</option>
                        @foreach($users as $u)
                            <option value="{{ $u->fullname }}">{{ $u->fullname }}</option>
                        @endforeach
                    </select>
                </div> --}}

                <div class="col-md-5">
                    <select id="paymentFilter" class="form-select">
                        <option value="">All Payments</option>
                        @foreach($payments as $p)
                            <option value="{{ $p->name }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 d-flex gap-2">
                    <button type="button" class="btn btn-primary w-50" id="applyFilters">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                    <button type="button" class="btn btn-secondary w-50" id="resetFilters">
                        <i class="bi bi-arrow-repeat"></i> Reset
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ✅ Table --}}
    <div class="card">
        <div class="card-body">
            <table id="ordersTable" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Items</th>
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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<script>
$(function () {
    var table = $('#ordersTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "{{ route('orders.index') }}",
            data: function (d) {
                d.status  = $('#statusFilter').val();
                d.user    = $('#userFilter').val();
                d.payment = $('#paymentFilter').val();
            }
        },
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'user', name: 'user' },
            { data: 'payment_method', name: 'payment_method' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'total_amount', name: 'total_amount' },
            { data: 'items', name: 'items', orderable: false, searchable: false },
            { data: 'created_at', name: 'created_at' },
            { data: 'action', orderable: false, searchable: false }
        ],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search orders..."
        }
    });

    // ✅ Apply Filters Button
    $('#applyFilters').on('click', function () {
        table.draw();
    });

    // ✅ Reset Filters Button
    $('#resetFilters').on('click', function () {
        $('#statusFilter').val('');
        $('#userFilter').val('');
        $('#paymentFilter').val('');
        table.draw();
    });
});
</script>
@endpush
