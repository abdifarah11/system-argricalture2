@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Create User</h4>
    <form method="POST" action="{{ route('users.store') }}">
        @csrf

        <div class="mb-3">
            <label>Full Name</label>
            <input type="text" name="fullname" class="form-control" required value="{{ old('fullname') }}">
        </div>

        <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required value="{{ old('username') }}">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
        </div>

        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-select" required>
                <option value="">-- Select Role --</option>
                <option value="admin">Admin</option>
                <option value="market_officer">Market Officer</option>
                <option value="general">General</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Region</label>
            <select name="region_id" class="form-select">
                <option value="">-- None --</option>
                @foreach($regions as $region)
                    <option value="{{ $region->id }}">{{ $region->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Create</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
