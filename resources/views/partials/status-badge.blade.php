@php
    $statusClass = match ($status) {
        'Diajukan', 'Ditinjau', 'Ditinjau Ulang' => 'status-info',
        'Revisi' => 'status-warning',
        'Disetujui', 'Terjadwal' => 'status-success',
        default => 'status-purple',
    };
@endphp

<span class="badge {{ $statusClass }}">
    <span class="dot"></span>
    {{ $status }}
</span>
