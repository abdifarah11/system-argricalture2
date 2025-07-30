@extends('layouts.app')

@section('title', 'Edit System Settings')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4 text-primary">🛠️ Edit System Settings</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('settings.update', $setting->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="system_name" class="form-label">System Name</label>
            <input type="text" name="system_name" class="form-control" value="{{ $setting->system_name }}">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">System Email</label>
            <input type="email" name="email" class="form-control" value="{{ $setting->email }}">
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">System Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ $setting->phone }}">
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">System Address</label>
            <input type="text" name="address" class="form-control" value="{{ $setting->address }}">
        </div>

     

        <div class="mb-3">
            <label for="logo" class="form-label">System Logo</label><br>
            @if($setting->logo)
                <img src="{{ asset('storage/' . $setting->logo) }}" alt="Logo" height="50" class="mb-2">
            @endif
            <input type="file" name="logo" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">
            <i class="bi bi-check-circle"></i> Update Settings
        </button>
        <a href="{{ route('settings.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left-circle"></i> Back
        </a>
    </form>
</div>
@endsection
