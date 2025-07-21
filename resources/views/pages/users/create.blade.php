@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">➕ Create New User</h3>

    {{-- Show Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Please fix the following issues:
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        {{-- Full Name --}}
        <div class="mb-3">
            <label for="fullname" class="form-label">Full Name</label>
            <input type="text" name="fullname" class="form-control"
                value="{{ old('fullname') }}" required>
        </div>

        {{-- Username --}}
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" class="form-control"
                value="{{ old('username') }}" required>
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control"
                value="{{ old('email') }}" required>
        </div>

        {{-- User Type --}}
        <div class="mb-3">
            <label for="role" class="form-label">role</label>
            <select name="role" class="form-select" required>
                <option value="">-- Select Type --</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="market_officer" {{ old('role') == 'market_officer' ? 'selected' : '' }}>Market Officer</option>
                <option value="general" {{ old('role') == 'general' ? 'selected' : '' }}>General</option>
            </select>
        </div>

        {{-- Region --}}
        <div class="mb-3">
            <label for="region_id" class="form-label">Region (optional)</label>
            <select name="region_id" class="form-select">
                <option value="">-- Select Region --</option>
                @foreach ($regions as $region)
                    <option value="{{ $region->id }}" {{ old('region_id') == $region->id ? 'selected' : '' }}>
                        {{ $region->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Password --}}
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        {{-- Confirm Password --}}
        <div class="mb-4">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        {{-- Buttons --}}
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-circle"></i> Create User
        </button>

        <a href="{{ route('users.index') }}" class="btn btn-secondary ms-2">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
    </form>
</div>
@endsection

@push('scripts')
{{-- Bootstrap Icons CDN --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endpush
