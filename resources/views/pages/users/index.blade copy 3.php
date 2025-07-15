@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row align-items-end mb-3 gy-2">
            <div class="col-sm-3">
                <label class="form-label">Filter by Region</label>
                <select id="regionFilter" class="form-select">
                    <option value="">All Regions</option>
                    @foreach ($regions as $region)
                        <option value="{{ $region->name }}">{{ $region->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-sm-3">
                <label class="form-label">Filter by User Type</label>
                <select id="typeFilter" class="form-select">
                    <option value="">All Types</option>
                    @foreach ($userTypes as $type)
                        <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-sm-3 ms-auto text-end">
                <a href="{{ route('users.create') }}" class="btn btn-success d-inline-flex align-items-center gap-2">
                    <i class="bi bi-person-plus-fill"></i> Add User
                </a>
            </div>
        </div>

        <table id="myTable" class="table table-bordered">



            <thead>
                <tr>
                    <th>#</th>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>User Type</th>
                    <th>Region</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
               
               
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.js"
    integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
<script>
    let table = new DataTable('#myTable');
</script>
@endpush