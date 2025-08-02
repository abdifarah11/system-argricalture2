@extends('layouts.app')

@section('title', 'Reports')

@section('content')
    <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0 text-primary fw-bold">📊 Reports</h3>
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
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label for="crop_id" class="form-label text-muted">Filter by Crop</label>
                        <select id="crop_id" class="form-select shadow-sm">
                            <option value="">All Crops</option>
                            @foreach($crops as $crop)
                                <option value="{{ $crop->id }}">{{ $crop->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="region_id" class="form-label text-muted">Filter by Region</label>
                        <select id="region_id" class="form-select shadow-sm">
                            <option value="">All Regions</option>
                            @foreach($regions as $region)
                                <option value="{{ $region->id }}">{{ $region->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label text-muted">Date Range</label>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-calendar-date text-primary"></i>
                            </span>
                            <input type="date" id="from_date" class="form-control border-start-0">
                            <span class="input-group-text bg-white">to</span>
                            <input type="date" id="to_date" class="form-control">
                            <button class="btn btn-outline-secondary" type="button" id="clearDateRange"
                                title="Clear Date Range">
                                <i class="bi bi-x-circle-fill"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Data Table --}}
        <div class="card border-0 shadow-lg">
            <div class="card-body">
                <table id="reportsTable"
                    class="table table-hover table-bordered table-striped align-middle text-center nowrap w-100">
                    <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>Crop</th>
                            <th>Region</th>
                            <th>Order</th>
                            <th>Quantity</th>
                            <th>KG</th>
                            <th>Unit</th>
                            <th>Price</th>
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
            var table = $('#reportsTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: '{{ route('reports.index') }}',
                    data: function (d) {
                        d.crop_id = $('#crop_id').val();
                        d.region_id = $('#region_id').val();
                        d.from_date = $('#from_date').val();
                        d.to_date = $('#to_date').val();
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'crop', name: 'crop.name' },
                    { data: 'region', name: 'region.name' },
                    { data: 'order', name: 'order.name' },
                    { data: 'quantity', name: 'quantity' },
                    { data: 'kg', name: 'kg' },
                    { data: 'unit', name: 'unit' },
                    { data: 'price', name: 'price' },
                    { data: 'created_at', name: 'created_at' }
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

            $('#crop_id, #region_id, #from_date, #to_date').on('change', function () {
                table.draw();
            });

            $('#resetFilters, #clearDateRange').on('click', function () {
                $('#crop_id, #region_id').val('');
                $('#from_date, #to_date').val('');
                table.draw();
            });

            $.fn.dataTable.ext.errMode = 'none';
        });
    </script>
@endpush
