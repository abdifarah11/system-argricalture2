@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('crops.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Add New Crop
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table id="crops-table" class="table table-bordered table-striped align-middle w-100">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Image</th> {{-- NEW IMAGE COLUMN --}}
                    <th>Name</th>
                    <th>Type</th>
                    <th>Region</th>
                    <th>Added By</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
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
            var table = $('#crops-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: {
                    details: {
                        type: 'column',
                        target: 'tr'
                    }
                },
                ajax: '{{ route('crops.index') }}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },

                    // IMAGE COLUMN
                    { 
                        data: 'image', 
                        name: 'image',
                        orderable: false, 
                        searchable: false,
                        render: function(data, type, full, meta) {
                            if(data) {
                                return `<img src="{{ asset('storage') }}/${data}" alt="Crop Image" style="height:40px; width:auto; border-radius:4px;" />`;
                            }
                            return '-';
                        }
                    },

                    { data: 'name', name: 'name' },
                    { data: 'cropType', name: 'cropType.name' },
                    { data: 'region', name: 'region.name' },
                    { data: 'user', name: 'user.fullname' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                columnDefs: [
                    { responsivePriority: 1, targets: 2 }, // Name priority 1 (adjust due to image added)
                    { responsivePriority: 2, targets: -1 }
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
                    searchPlaceholder: "Search users..."
                }
            });

            // Filters - adjust if you add filter inputs later
            $('#regionFilter').on('change', function () {
                table.column(5).search(this.value).draw();
            });

            $('#typeFilter').on('change', function () {
                table.column(4).search(this.value).draw();
            });
        });
    </script>
@endpush
