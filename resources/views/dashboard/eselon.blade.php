@extends('layouts.app')

@section('title', 'Dashboard Eselon')

@section('content')
<div class="container-fluid">
    <!-- Statistics Cards - Improved Design -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start-primary border-start-4 shadow-lg h-100 py-2 hover-lift">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs fw-semibold text-primary text-uppercase mb-1">
                                Total Laporan</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $totalLaporan }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-primary-soft"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <small class="text-muted">Semua laporan yang diterima</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start-warning border-start-4 shadow-lg h-100 py-2 hover-lift">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs fw-semibold text-warning text-uppercase mb-1">
                                Laporan Baru</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $laporanBaru }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-plus-circle fa-2x text-warning-soft"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <small class="text-muted">Menunggu penugasan</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start-info border-start-4 shadow-lg h-100 py-2 hover-lift">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs fw-semibold text-info text-uppercase mb-1">
                                Dalam Proses</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $laporanDiproses }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-spinner fa-2x text-info-soft"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <small class="text-muted">Sedang ditangani teknisi</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start-success border-start-4 shadow-lg h-100 py-2 hover-lift">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs fw-semibold text-success text-uppercase mb-1">
                                Selesai</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $laporanSelesai }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-success-soft"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <small class="text-muted">Laporan telah terselesaikan</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SLA Warning Section - Enhanced Design -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient-primary text-white py-3 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle fa-lg me-3"></i>
                        <h5 class="m-0 fw-bold">Peringatan SLA (Semua Laporan)</h5>
                    </div>
                    <span class="badge bg-white text-danger fw-bold px-3 py-2 rounded-pill">
                        {{ $warningLaporan->count() }} Peringatan
                    </span>
                </div>
                <div class="card-body p-0">
                    @if($warningLaporan->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" id="dataTable" width="100%" cellspacing="0">
                                <thead class="bg-light-blue">
                                    <tr>
                                        <th class="border-top-0 ps-4">No. Tiket</th>
                                        <th class="border-top-0">Judul Laporan</th>
                                        <th class="border-top-0">Layanan</th>
                                        <th class="border-top-0">Teknisi</th>
                                        <th class="border-top-0">Tanggal Dibuat</th>
                                        <th class="border-top-0">Target Selesai</th>
                                        <th class="border-top-0">Sisa Waktu</th>
                                        <th class="border-top-0 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($warningLaporan as $laporan)
                                    <tr class="border-start border-start-{{ $laporan->warna_sla }} border-start-4 hover-highlight">
                                        <td class="ps-4">
                                            <div class="fw-bold text-primary">{{ $laporan->kode_tiket }}</div>
                                        </td>
                                        <td>
                                            <div class="fw-medium">{{ Str::limit($laporan->judul_laporan, 40) }}</div>
                                            <small class="text-muted">#{{ $laporan->id }}</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-blue-soft text-primary">
                                                {{ $laporan->layanan->nama ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($laporan->teknisi)
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm bg-primary-soft rounded-circle d-flex align-items-center justify-content-center me-2">
                                                        <i class="fas fa-user text-primary fs-6"></i>
                                                    </div>
                                                    <span class="fw-medium">{{ $laporan->teknisi->name }}</span>
                                                </div>
                                            @else
                                                <span class="text-muted fst-italic">Belum ditetapkan</span>
                                            @endif
                                        </td>
                                        <td class="text-nowrap">
                                            <div class="fw-medium">{{ $laporan->created_at->format('d/m/Y') }}</div>
                                            <small class="text-muted">{{ $laporan->created_at->format('H:i') }}</small>
                                        </td>
                                        <td class="text-nowrap">
                                            <div class="fw-medium">{{ $laporan->created_at->addDays($laporan->layanan->sla_hari ?? 0)->format('d/m/Y') }}</div>
                                            <small class="text-muted">{{ $laporan->created_at->addDays($laporan->layanan->sla_hari ?? 0)->format('H:i') }}</small>
                                        </td>
                                        <td>
                                            @if($laporan->sisa_sla < 0)
                                                <div class="d-flex align-items-center text-danger">
                                                    <i class="fas fa-exclamation-circle me-2"></i>
                                                    <span class="fw-bold">Terlambat {{ abs($laporan->sisa_sla) }} hari</span>
                                                </div>
                                            @else
                                                <div class="d-flex align-items-center text-{{ $laporan->warna_sla }}">
                                                    <i class="{{ $laporan->icon_sla }} me-2"></i>
                                                    <span class="fw-medium">{{ $laporan->sisa_sla }} hari</span>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('laporan.show', $laporan->id) }}" 
                                               class="btn btn-sm btn-primary btn-icon rounded-circle"
                                               data-bs-toggle="tooltip"
                                               data-bs-placement="top"
                                               title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <div class="avatar-lg bg-success-soft text-success rounded-circle d-inline-flex align-items-center justify-content-center">
                                    <i class="fas fa-check-circle fa-3x"></i>
                                </div>
                            </div>
                            <h4 class="text-success fw-bold mb-2">Tidak ada peringatan SLA</h4>
                            <p class="text-muted mb-4">Semua laporan masih dalam batas waktu yang ditentukan</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CSS Tambahan untuk Aesthetic -->
<style>
    :root {
        --primary-soft: #e3f2fd;
        --warning-soft: #fff3cd;
        --info-soft: #d1ecf1;
        --success-soft: #d4edda;
        --danger-soft: #f8d7da;
        --blue-soft: #e8f4ff;
        --light-blue: #f0f8ff;
    }

    .bg-primary-soft {
        background-color: var(--primary-soft) !important;
    }
    
    .bg-warning-soft {
        background-color: var(--warning-soft) !important;
    }
    
    .bg-info-soft {
        background-color: var(--info-soft) !important;
    }
    
    .bg-success-soft {
        background-color: var(--success-soft) !important;
    }
    
    .bg-blue-soft {
        background-color: var(--blue-soft) !important;
    }
    
    .bg-light-blue {
        background-color: var(--light-blue) !important;
    }
    
    .text-primary-soft {
        color: #90caf9 !important;
    }
    
    .text-warning-soft {
        color: #ffd54f !important;
    }
    
    .text-info-soft {
        color: #4fc3f7 !important;
    }
    
    .text-success-soft {
        color: #81c784 !important;
    }

    .bg-gradient-primary {
        background: linear-gradient(135deg, #4a6ee0 0%, #2d4bb6 100%);
    }

    .border-start-4 {
        border-left-width: 4px !important;
    }

    .hover-lift {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }

    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }

    .hover-highlight:hover {
        background-color: var(--light-blue) !important;
    }

    .btn-icon {
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .badge.badge-danger {
        background-color: #dc3545 !important;
        color: white !important;
    }
    
    .badge.badge-warning {
        background-color: #ffc107 !important;
        color: #212529 !important;
    }
    
    .badge.badge-success {
        background-color: #28a745 !important;
        color: white !important;
    }

    .avatar-sm {
        width: 32px;
        height: 32px;
    }

    .avatar-lg {
        width: 80px;
        height: 80px;
    }

    .avatar-xl {
        width: 120px;
        height: 120px;
    }

    .border-start-warning {
        border-left-color: #ffc107 !important;
    }

    .border-start-info {
        border-left-color: #17a2b8 !important;
    }

    .border-start-success {
        border-left-color: #28a745 !important;
    }
</style>

<!-- JavaScript untuk auto-refresh warning SLA -->
@push('scripts')
<script>
    // Auto-refresh warning SLA setiap 5 menit
    setInterval(function() {
        fetch('{{ route("dashboard.sla-warning") }}')
            .then(response => response.json())
            .then(data => {
                // Update badge count
                const badge = document.querySelector('.badge.bg-white.text-danger');
                if (badge) {
                    badge.textContent = data.length + ' Peringatan';
                }
            })
            .catch(error => console.error('Error updating SLA warning:', error));
    }, 300000);

    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush

@endsection