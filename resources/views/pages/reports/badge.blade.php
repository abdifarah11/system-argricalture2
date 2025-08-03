@php
    $color = match(strtolower($status)) {
        'pending'   => 'warning',
        'completed' => 'success',
        'failed'    => 'danger',
        'cancelled' => 'secondary',
        default     => 'dark',
    };
@endphp

<span class="badge bg-{{ $color }} text-capitalize px-3 py-1">
    {{ $status }}
</span>
