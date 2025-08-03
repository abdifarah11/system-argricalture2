@extends('layouts.app')

@section('title', 'Reports')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0 text-primary fw-bold">📊 Completed Reports</h3>
        <div>
            <a href="{{ route('reports.export_pdf', request()->query()) }}" target="_blank"
               class="btn btn-outline-primary me-2 shadow-sm">
                <i class="bi bi-file-earmark-pdf-fill me-1"></i> Export PDF
            </a>
            <button id="resetFilters" class="btn btn-outline-danger shadow-sm">
                <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Filters
            </button>
        </div>
    </div>

    {{-- Filter Form --}}
    <form id="filterForm">
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="row g-3 align-items-end">
                    {{-- Date Range --}}
                    <div class="col-md-6">
                        <label class="form-label text-muted">Date Range</label>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-calendar-date text-primary"></i>
                            </span>
                            <input type="date" name="from_date" id="from_date" value="{{ request('from_date') }}"
                                class="form-control border-start-0">
                            <span class="input-group-text bg-white">to</span>
                            <input type="date" name="to_date" id="to_date" value="{{ request('to_date') }}"
                                class="form-control">
                            <button class="btn btn-outline-secondary" type="button" id="clearDateRange"
                                title="Clear Date Range">
                                <i class="bi bi-x-circle-fill"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Order ID --}}
                    <div class="col-md-4">
                        <label class="form-label text-muted">Order</label>
                        <select id="order_id" class="form-select shadow-sm" name="order_id">
                            <option value="">All Orders</option>
                            @foreach ($orders as $order)
                                <option value="{{ $order->id }}" {{ request('order_id') == $order->id ? 'selected' : '' }}>
                                    #{{ $order->id }} - {{ $order->user->fullname ?? 'No Customer' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- Data Table --}}
    <div class="card border-0 shadow-lg">
        <div class="card-body">
            <table id="reportsTable"
                   class="table table-hover table-bordered table-striped align-middle text-center nowrap w-100">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Customer</th>
                        <th>Order Items</th>
                        <th>Payment Method</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<style>
    input[type="date"]::-webkit-calendar-picker-indicator {
        filter: invert(0.5);
    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<script>
    $(function () {
        const table = $('#reportsTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: '{{ route('reports.index') }}',
                data: function (d) {
                    d.from_date = $('#from_date').val();
                    d.to_date = $('#to_date').val();
                    d.order_id = $('#order_id').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'customer', name: 'customer' },
                { data: 'order_items', name: 'order_items' },
                { data: 'payment_method', name: 'payment_method' },
                { data: 'amount', name: 'amount' },
                { data: 'status', name: 'status' },
                { data: 'created_at', name: 'created_at' },
            ],
            language: {
                emptyTable: "No data available for selected filters.",
                search: "_INPUT_",
                searchPlaceholder: "Search records...",
                paginate: {
                    previous: '<i class="bi bi-chevron-double-left"></i> Prev',
                    next: 'Next <i class="bi bi-chevron-double-right"></i>'
                }
            },
            drawCallback: function () {
                $('#reportsTable_paginate').addClass('d-flex justify-content-center mt-3');
            }
        });

        // Auto-refresh on filter change
        $('#from_date, #to_date, #order_id').on('change', function () {
            table.draw();
            updateExportLink();
        });

        $('#resetFilters, #clearDateRange').on('click', function () {
            $('#from_date, #to_date, #order_id').val('');
            table.draw();
            updateExportLink();
        });

        function updateExportLink() {
            const params = new URLSearchParams({
                from_date: $('#from_date').val(),
                to_date: $('#to_date').val(),
                order_id: $('#order_id').val(),
            }).toString();

            const exportUrl = '{{ route("reports.export_pdf") }}' + '?' + params;
            $('a[href^="{{ route("reports.export_pdf") }}"]').attr('href', exportUrl);
        }

        $.fn.dataTable.ext.errMode = 'none';
    });
</script>
@endpush
