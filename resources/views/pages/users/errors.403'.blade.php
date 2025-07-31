@extends('layouts.app')

@section('content')
<div class="container mt-5 d-flex justify-content-center">
    <div class="card border-danger shadow-sm" style="max-width: 500px; width: 100%;">
        <div class="card-header bg-danger text-white">
            <h4 class="mb-0"><i class="bi bi-exclamation-triangle-fill"></i> 403 Forbidden</h4>
        </div>
        <div class="card-body text-center">
            <p class="lead">🚫 You cannot change the password for this user.</p>
            <a href="{{ route('users.index') }}" class="btn btn-outline-danger">
                <i class="bi bi-arrow-left-circle"></i> Go to Users
            </a>
        </div>
    </div>
</div>
@endsection
