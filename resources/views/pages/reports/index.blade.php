@extends('layouts.app')

@section('title', 'Reports')

@section('content')
<div class="container-fluid mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Price Reports</h4>
            <form method="GET" action="{{ route('reports.export_pdf') }}" target="_blank" id="pdfForm">
                <input type="hidden" name="crop_id" id="pdf_crop_id">
                <input type="hidden" name="region_id" id="pdf_region_id">
                <input type="hidden" name="from_date" id="pdf_from_date">
                <input type="hidden" name="to_date" id="pdf_to_date">
                <input type="hidden" name="order_id" id="pdf_order_id">
                <button type="submit" class="btn btn-danger"><i class="bi bi-file-earmark-pdf"></i> Export PDF</button>
            </form>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-2">
                    <select class="form-select" id="filter_crop">
                        <option value="">All Crops</option>
                        @foreach($crops as $crop)
                            <option value="{{ $crop->id }}">{{ $crop->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" id="filter_region">
                        <option value="">All Regions</option>
                        @foreach($regions as $region)
                            <option value="{{ $region->id }}">{{ $region->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="text" id="filter_order_id" class="form-control" placeholder="Order ID">
                </div>
                <div class="col-md-2">
                    <input type="date" id="from_date" class="form-control">
                </div>
                <div class="col-md-2">
                    <input type="date" id="to_date" class="form-control">
                </div>
                <div class="col-md-2">
                    <button id="filterBtn" class="btn btn-primary w-100"><i class="bi bi-filter"></i> Filter</button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered" id="reportTable" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Crop</th>
                            <th>Region</th>
                            <th>Order ID</th>
                            <th>Price</th>
                            <th>Unit</th>
                            <th>Quantity</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        const table = $('#reportTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('reports.index') }}",
                data: function (d) {
                    d.crop_id = $('#filter_crop').val();
                    d.region_id = $('#filter_region').val();
                    d.order_id = $('#filter_order_id').val();
                    d.from_date = $('#from_date').val();
                    d.to_date = $('#to_date').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'crop', name: 'crop' },
                { data: 'region', name: 'region' },
                { data: 'order_id', name: 'order_id' },
                { data: 'price', name: 'price' },
                { data: 'unit', name: 'unit' },
                { data: 'quantity', name: 'quantity' },
                { data: 'created_at', name: 'created_at' }
            ]
        });

        $('#filterBtn').on('click', function () {
            $('#pdf_crop_id').val($('#filter_crop').val());
            $('#pdf_region_id').val($('#filter_region').val());
            $('#pdf_from_date').val($('#from_date').val());
            $('#pdf_to_date').val($('#to_date').val());
            $('#pdf_order_id').val($('#filter_order_id').val());
            table.draw();
        });
    });
</script>
@endpush
