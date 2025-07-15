/* ───────────── resources/views/pages/orders/index.blade.php ───────────── */
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Orders List</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('orders.create') }}" class="btn btn-primary mb-3">+ Add Order</a>

    <table class="table table-bordered" id="orders-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Buyer</th>
                <th>Status</th>
                <th>Total Amount</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
</div>

@push('scripts')
<script>
$(function() {
    $('#orders-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('orders.index') }}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'buyer', name: 'buyer' },
            { data: 'status', name: 'status' },
            { data: 'total_amount', name: 'total_amount' },
            { data: 'created_at', name: 'created_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });
});
</script>
@endpush
@endsection