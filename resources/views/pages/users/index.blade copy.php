@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit User</h2>

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="fullname" class="form-label">Full Name</label>
            <input type="text" name="fullname" value="{{ $user->fullname }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" value="{{ $user->username }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" value="{{ $user->email }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="user_type" class="form-label">User Type</label>
            <select name="user_type" class="form-select" required>
                <option value="admin" {{ $user->user_type === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="market_officer" {{ $user->user_type === 'market_officer' ? 'selected' : '' }}>Market Officer</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Update User</button>
    </form>
</div>
@endsection
