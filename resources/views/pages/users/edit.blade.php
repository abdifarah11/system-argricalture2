@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Edit User</h4>
    <form method="POST" action="{{ route('users.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Full Name</label>
            <input type="text" name="fullname" class="form-control" value="{{ old('fullname', $user->fullname) }}">
        </div>

        <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
        </div>

        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-select">
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="market_officer" {{ $user->role == 'market_officer' ? 'selected' : '' }}>Market Officer</option>
                <option value="general" {{ $user->role == 'general' ? 'selected' : '' }}>General</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Region</label>
            <select name="region_id" class="form-select">
                <option value="">-- None --</option>
                @foreach($regions as $region)
                    <option value="{{ $region->id }}" {{ $user->region_id == $region->id ? 'selected' : '' }}>
                        {{ $region->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- <div class="mb-3">
            <label>New Password (leave blank to keep current)</label>
            <input type="password" name="password" class="form-control">
        </div> --}}

        {{-- <div class="mb-3">
            <label>Confirm New Password</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div> --}}

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
