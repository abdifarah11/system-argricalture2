@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row align-items-end mb-3 gy-2">
       

        <div class="col-sm-3 ms-auto text-end">
            <a href="{{ route('crop_types.create') }}" class="btn btn-success d-inline-flex align-items-center gap-2">
                <i class="bi bi-person-plus-fill"></i> Add Crop Type
            </a>
        </div>
    </div>

    {{-- ── Users Table ───────────────────────────────────────── --}}
    <div class="table-responsive">
        <table id="crop_typesTable" class="table table-striped table-bordered dt-responsive nowrap" style="width: 100%">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                      <th>description</th>
                  
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
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
            var table = $('#crop_typesTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: {
                    details: {
                        type: 'column',
                        target: 'tr'
                    }
                },
                ajax: '{{ route('crop_types.index') }}', // This should return JSON for users
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'name', name: 'name' },
                    { data: 'description', name: 'description' },
                    
                    { data: 'created_at', name: 'created_at' ?? 'null'},
                    
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                columnDefs: [
                    { responsivePriority: 1, targets: 1 },
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

            // $('#regionFilter').on('change', function () {
            //     table.column(4).search(this.value).draw();
            // });

            // $('#typeFilter').on('change', function () {
            //     table.column(3).search(this.value).draw();
            // });
        });
    </script>
@endpush
