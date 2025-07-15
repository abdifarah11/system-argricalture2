@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h2 class="mb-4">✏️ Edit User</h2>

            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Full Name --}}
                <div class="mb-3">
                    <label for="fullname" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="fullname" name="fullname"
                        value="{{ old('fullname', $user->fullname) }}" required>
                </div>

                {{-- Username --}}
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username"
                        value="{{ old('username', $user->username) }}" required>
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email"
                        value="{{ old('email', $user->email) }}" required>
                </div>

                {{-- Region --}}
                <div class="mb-3">
                    <label for="region_id" class="form-label">Region</label>
                    <select name="region_id" id="region_id" class="form-select">
                        <option value="">-- Select Region --</option>
                        @foreach ($regions as $region)
                            <option value="{{ $region->id }}" {{ $user->region_id == $region->id ? 'selected' : '' }}>
                                {{ $region->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- User Type --}}
                <div class="mb-3">
                    <label for="user_type" class="form-label">User Type</label>
                    <select name="user_type" id="user_type" class="form-select" required>
                        <option value="admin" {{ $user->user_type == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="market_officer" {{ $user->user_type == 'market_officer' ? 'selected' : '' }}>Market Officer</option>
                        <option value="general" {{ $user->user_type == 'general' ? 'selected' : '' }}>General User</option>
                    </select>
                </div>

                

                {{-- Submit and Cancel --}}
                <button type="submit" class="btn btn-primary">Update User</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
