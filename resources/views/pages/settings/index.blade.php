@extends('layouts.app')

@section('title', 'System Settings')

@section('content')

<style>
  body::before {
    content: "";
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background-image: url('{{ asset('img/logo.jpg') }}');
    background-repeat: no-repeat;
    background-position: center center;
    background-size: cover;
    opacity: 0.05;
    pointer-events: none;
    z-index: -1;
  }

  table.table {
    background-color: rgba(255, 255, 255, 0.85);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    border-radius: 8px;
    overflow: hidden;
  }

  table.table th,
  table.table td {
    vertical-align: middle;
  }

  table.table th {
    background-color: #f8f9fa;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
  }

  h2.mb-4 {
    text-shadow: 1px 1px 3px rgba(0,0,0,0.15);
  }

  a.text-decoration-none:hover {
    text-decoration: underline;
    text-shadow: 0 0 5px rgba(0, 123, 255, 0.7);
  }

  .badge.bg-secondary {
    box-shadow: 0 0 6px rgba(0,0,0,0.1);
  }
</style>

<div class="container-fluid mt-4">
    <h2 class="mb-4">
        <i class="bi bi-gear-fill me-2"></i> System Settings
    </h2>

    <div class="mb-3">
        <a href="{{ route('settings.edit', $setting->id) }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-pencil-square me-1"></i> Edit Settings
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center" role="alert" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.1);">
            <i class="bi bi-check-circle-fill me-2"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    <table class="table table-bordered table-hover align-middle">
        <tbody>
            <tr>
                <th scope="row">
                    <i class="bi bi-info-circle-fill text-primary me-2"></i> System Name
                </th>
                <td>{{ $setting->system_name }}</td>
            </tr>

            <tr>
                <th scope="row">
                    <i class="bi bi-telephone-fill text-success me-2"></i> Phone
                </th>
                <td>
                    @if($setting->phone)
                        <a href="tel:{{ $setting->phone }}" class="text-decoration-none">
                            <i class="bi bi-phone-vibrate me-1"></i> {{ $setting->phone }}
                        </a>
                    @else
                        <span class="badge bg-secondary">Not Provided</span>
                    @endif
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <i class="bi bi-whatsapp text-success me-2"></i> WhatsApp
                </th>
                <td>
                    @if($setting->whatsapp)
                        <a href="{{ $setting->whatsapp }}" target="_blank" class="text-success text-decoration-none"
                           data-bs-toggle="tooltip" data-bs-placement="top" title="Chat on WhatsApp">
                            <i class="bi bi-chat-dots-fill me-1"></i> Chat on WhatsApp
                        </a>
                    @else
                        <span class="badge bg-secondary">Not Provided</span>
                    @endif
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <i class="bi bi-geo-alt-fill text-danger me-2"></i> Address
                </th>
                <td>{{ $setting->address ?? '-' }}</td>
            </tr>

            <tr>
                <th scope="row">
                    <i class="bi bi-map-fill text-warning me-2"></i> Location (Google Maps)
                </th>
                <td>
                    @if($setting->location)
                        <a href="{{ $setting->location }}" target="_blank" class="text-warning text-decoration-none"
                           data-bs-toggle="tooltip" data-bs-placement="top" title="View on Google Maps">
                            <i class="bi bi-pin-map-fill me-1"></i> View on Map
                        </a>
                    @else
                        <span class="badge bg-secondary">Not Provided</span>
                    @endif
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <i class="bi bi-globe2 text-info me-2"></i> URL
                </th>
                <td>
                    @if($setting->url)
                        <a href="{{ $setting->url }}" target="_blank" class="text-info text-decoration-none"
                           data-bs-toggle="tooltip" data-bs-placement="top" title="Visit System Homepage">
                            <i class="bi bi-box-arrow-up-right me-1"></i> {{ $setting->url }}
                        </a>
                    @else
                        <span class="badge bg-secondary">Not Provided</span>
                    @endif
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <i class="bi bi-envelope-fill text-danger me-2"></i> Email
                </th>
                <td>
                    @if($setting->email)
                        <a href="mailto:{{ $setting->email }}" class="text-danger text-decoration-none"
                           data-bs-toggle="tooltip" data-bs-placement="top" title="Send Email">
                            <i class="bi bi-envelope-paper-fill me-1"></i> {{ $setting->email }}
                        </a>
                    @else
                        <span class="badge bg-secondary">Not Provided</span>
                    @endif
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <i class="bi bi-image-fill text-secondary me-2"></i> Logo
                </th>
                <td>
                    @if($setting->logo_path)
                        <img src="{{ asset('storage/' . $setting->logo_path) }}" alt="Logo" height="80">
                    @else
                        <span class="badge bg-secondary">No Logo Uploaded</span>
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
</div>

@endsection
