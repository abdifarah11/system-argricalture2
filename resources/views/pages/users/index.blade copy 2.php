@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">Users List</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="mb-3">
            <a href="{{ route('users.create') }}" class="btn btn-primary">+ Add User</a>
        </div>


        <table id="myTable" class="table table-bordered">
            

          
            <thead >
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
                @forelse ($users as $index => $user)
                        <tr>
                            <td>{{ $users->firstItem() + $index }}</td>
                            <td>{{ $user->fullname }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ ucfirst($user->user_type) }}</td>
                            <td>{{ $user->region->name ?? '-' }}</td>
                            <td>
                                <a href=" {{ route('users.edit', $user->id) }}" class="btn btn-sm btn-info">Edit</a>
                    <form action="{{ route('users.delete', $user->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">
                            Delete
                        </button>
                    </form>
                    </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No users found.</td>
                    </tr>
                @endforelse
                <script src="https://code.jquery.com/jquery-3.7.1.js"
                    integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
                <script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
                <script>
                    let table = new DataTable('#myTable');
                </script>
                </tbody>
        </table>
    </div>
   


        <div class="d-flex justify-content-center">
            {{ $users->links() }}
        </div>
    </div>