@extends('layouts.app')

@section('title', 'Dashboard Teknisi - Peringatan SLA')

@section('content')
<div class="container-fluid">
    <!-- Alert Warning SLA yang Menonjol -->
    @if($totalWarning > 0)
    <div class="row mb-3">
        <div class="col-12">
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="
                border-left: 3px solid #dc3545;
                border-radius: 6px;
                background: #f8f9fa;
                box-shadow: 0 1px 6px rgba(0,0,0,0.08);
            " id="mainWarningAlert">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle fa-sm me-2" style="color: #dc3545;"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="alert-heading mb-1" style="color: #495057; font-weight: 600;">
                            PERINGATAN SLA AKTIF
                        </h6>
                        <p class="mb-1 small" style="color: #6c757d;">
                            Anda memiliki <strong class="text-danger">{{ $totalWarning }} laporan</strong> yang membutuhkan perhatian segera:
                        </p>
                        <div class="d-flex gap-2">
                            @if($criticalWarning > 0)
                                <span class="badge bg-danger py-1 px-2">
                                    <i class="fas fa-fire me-1"></i>{{ $criticalWarning }} Terlambat
                                </span>
                            @endif
                            @if($highWarning > 0)
                                <span class="badge bg-warning text-dark py-1 px-2">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $highWarning }} Kritis
                                </span>
                            @endif
                            @if($mediumWarning > 0)
                                <span class="badge bg-info py-1 px-2">
                                    <i class="fas fa-clock me-1"></i>{{ $mediumWarning }} Peringatan
                                </span>
                            @endif
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="row mb-3">
        <div class="col-12">
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="
                border-left: 3px solid #28a745;
                border-radius: 6px;
                background: #f8f9fa;
                box-shadow: 0 1px 6px rgba(0,0,0,0.08);
            ">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle fa-sm me-2" style="color: #28a745;"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="alert-heading mb-1" style="color: #495057; font-weight: 600;">
                            Status Baik
                        </h6>
                        <p class="mb-0 small" style="color: #6c757d;">
                            Tidak ada peringatan SLA aktif. Semua laporan dalam batas waktu yang ditentukan.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Statistics Cards dengan Highlight Warning - SEMUA DALAM 1 DERET -->
    <div class="row mb-4 g-3 justify-content-center">
        <div class="col-auto">
            <div class="card border-start-primary border-start-4 shadow h-100" style="width: 150px;">
                <div class="card-body p-3">
                    <div class="d-flex flex-column align-items-center">
                        <div class="mb-2">
                            <i class="fas fa-clipboard-list fa-lg text-primary"></i>
                        </div>
                        <div class="text-center">
                            <div class="text-xs fw-semibold text-primary text-uppercase mb-1">
                                Total Laporan
                            </div>
                            <div class="h5 mb-0 fw-bold text-gray-800">
                                {{ $totalLaporan }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Laporan Baru -->
        <div class="col-auto">
            <div class="card border-start-warning border-start-4 shadow h-100" style="width: 150px;">
                <div class="card-body p-3">
                    <div class="d-flex flex-column align-items-center">
                        <div class="mb-2">
                            <i class="fas fa-plus-circle fa-lg text-warning"></i>
                        </div>
                        <div class="text-center">
                            <div class="text-xs fw-semibold text-warning text-uppercase mb-1">
                                Laporan Baru
                            </div>
                            <div class="h5 mb-0 fw-bold text-gray-800">
                                {{ $laporanBaru }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: Dalam Proses -->
        <div class="col-auto">
            <div class="card border-start-info border-start-4 shadow h-100" style="width: 150px;">
                <div class="card-body p-3">
                    <div class="d-flex flex-column align-items-center">
                        <div class="mb-2">
                            <i class="fas fa-spinner fa-lg text-info"></i>
                        </div>
                        <div class="text-center">
                            <div class="text-xs fw-semibold text-info text-uppercase mb-1">
                                Dalam Proses
                            </div>
                            <div class="h5 mb-0 fw-bold text-gray-800">
                                {{ $laporanDiproses }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 4: Selesai -->
        <div class="col-auto">
            <div class="card border-start-success border-start-4 shadow h-100" style="width: 150px;">
                <div class="card-body p-3">
                    <div class="d-flex flex-column align-items-center">
                        <div class="mb-2">
                            <i class="fas fa-check-circle fa-lg text-success"></i>
                        </div>
                        <div class="text-center">
                            <div class="text-xs fw-semibold text-success text-uppercase mb-1">
                                Selesai
                            </div>
                            <div class="h5 mb-0 fw-bold text-gray-800">
                                {{ $laporanSelesai }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 5: Total Warning -->
        <div class="col-auto">
            <div class="card border-start-danger border-start-4 shadow h-100" style="width: 150px;">
                <div class="card-body p-3">
                    <div class="d-flex flex-column align-items-center">
                        <div class="mb-2">
                            <i class="fas fa-exclamation-triangle fa-lg text-danger"></i>
                        </div>
                        <div class="text-center">
                            <div class="text-xs fw-semibold text-danger text-uppercase mb-1">
                                Total Warning
                            </div>
                            <div class="h5 mb-0 fw-bold text-gray-800" id="totalWarningCount">
                                {{ $totalWarning }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SLA Warning Section -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient-primary text-white py-2 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle fa-sm me-2"></i>
                        <h6 class="m-0 fw-bold">Daftar Peringatan SLA</h6>
                    </div>
                    <span class="badge bg-white text-danger fw-bold px-2 py-1 rounded-pill small">
                        {{ $totalWarning }} Peringatan
                    </span>
                </div>
                <div class="card-body p-0">
                    @if($warningLaporan->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0" width="100%" cellspacing="0">
                                <thead class="bg-light-blue">
                                    <tr>
                                        <th class="border-top-0 ps-3 small">#</th>
                                        <th class="border-top-0 small">No. Tiket</th>
                                        <th class="border-top-0 small">Judul Laporan</th>
                                        <th class="border-top-0 small">Layanan</th>
                                        <th class="border-top-0 small">Tanggal Dibuat</th>
                                        <th class="border-top-0 small">Target Selesai</th>
                                        <th class="border-top-0 small">Sisa Waktu</th>
                                        <th class="border-top-0 text-center small">Aksi</th>
                                    </tr>
                                </thead>
                                <!-- Ganti bagian table body untuk warningLaporan -->
                                <tbody>
                                    @foreach($warningLaporan as $index => $laporan)
                                    <tr class="border-start border-start-{{ $laporan->warna_sla }} border-start-3 hover-highlight">
                                        <td class="ps-3">
                                            <div class="fw-bold small">{{ $index + 1 }}</div>
                                        </td>
                                        <td>
                                            <div class="fw-bold text-primary small">{{ $laporan->kode_tiket }}</div>
                                        </td>
                                        <td>
                                            <div class="fw-medium small">{{ Str::limit($laporan->judul_laporan, 30) }}</div>
                                        </td>
                                        <td>
                                            <span class="badge bg-blue-soft text-primary small py-1">
                                                {{ $laporan->layanan->nama ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="text-nowrap">
                                            <div class="fw-medium small">{{ $laporan->tanggal_laporan->format('d/m/Y') }}</div>
                                            <small class="text-muted">{{ $laporan->waktu_laporan_formatted }}</small>
                                        </td>
                                        <td class="text-nowrap">
                                            @if($laporan->layanan && $laporan->layanan->sla_hari)
                                                <div class="fw-medium small">{{ $laporan->tanggal_laporan->addDays($laporan->layanan->sla_hari)->format('d/m/Y') }}</div>
                                                <small class="text-muted">{{ $laporan->waktu_laporan_formatted }}</small>
                                            @else
                                                <span class="text-muted small">Tidak ada SLA</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($laporan->sisa_sla < 0)
                                                <div class="d-flex align-items-center text-danger">
                                                    <i class="fas fa-exclamation-circle me-1 fa-sm"></i>
                                                    <span class="fw-bold small">Terlambat {{ abs($laporan->sisa_sla) }} hari</span>
                                                </div>
                                            @elseif($laporan->sisa_sla == 0)
                                                <div class="d-flex align-items-center text-warning">
                                                    <i class="fas fa-exclamation-triangle me-1 fa-sm"></i>
                                                    <span class="fw-bold small">Hari ini deadline</span>
                                                </div>
                                            @elseif($laporan->status == 'selesai')
                                                <div class="d-flex align-items-center text-success">
                                                    <i class="fas fa-check-circle me-1 fa-sm"></i>
                                                    <span class="fw-bold small">Selesai</span>
                                                </div>
                                            @else
                                                <div class="d-flex align-items-center text-{{ $laporan->warna_sla }}">
                                                    <i class="{{ $laporan->icon_sla }} me-1 fa-sm"></i>
                                                    <span class="fw-medium small">{{ $laporan->sisa_sla }} hari tersisa</span>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('laporan.show', $laporan->id) }}" 
                                                class="btn btn-xs btn-primary btn-icon rounded-circle"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                title="Lihat Detail">
                                                    <i class="fas fa-eye fa-xs"></i>
                                                </a>
                                                @if($laporan->status != 'selesai')
                                                    <a href="{{ route('balasan-laporan.create', $laporan->id) }}" 
                                                    class="btn btn-xs btn-success btn-icon rounded-circle ms-1"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    title="Balas/Tindak Lanjut">
                                                        <i class="fas fa-reply fa-xs"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-3">
                            <div class="mb-2">
                                <div class="avatar-sm bg-success-soft text-success rounded-circle d-inline-flex align-items-center justify-content-center">
                                    <i class="fas fa-check-circle fa-lg"></i>
                                </div>
                            </div>
                            <h6 class="text-success fw-bold mb-1">Tidak ada peringatan SLA</h6>
                            <p class="text-muted mb-3 small">Semua laporan masih dalam batas waktu SLA.</p>
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
    
    .bg-danger-soft {
        background-color: var(--danger-soft) !important;
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
    
    .text-danger-soft {
        color: #f28b82 !important;
    }

    .bg-gradient-primary {
        background: linear-gradient(135deg, #4a6ee0 0%, #2d4bb6 100%);
    }

    .border-start-3 {
        border-left-width: 3px !important;
    }

    .border-start-4 {
        border-left-width: 4px !important;
    }

    .text-xxs {
        font-size: 0.65rem !important;
    }

    .avatar-sm {
        width: 50px;
        height: 50px;
    }

    .btn-xs {
        padding: 0.25rem 0.5rem !important;
        font-size: 0.75rem !important;
        line-height: 1.2;
    }

    .btn-icon {
        width: 28px;
        height: 28px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .hover-highlight:hover {
        background-color: var(--light-blue) !important;
    }

    /* Warna untuk border-left berdasarkan status SLA */
    .border-start-primary { border-left-color: #4e73df !important; }
    .border-start-warning { border-left-color: #f6c23e !important; }
    .border-start-info { border-left-color: #36b9cc !important; }
    .border-start-success { border-left-color: #1cc88a !important; }
    .border-start-danger { border-left-color: #dc3545 !important; }
</style>

<!-- JavaScript -->
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Update browser tab title with warning count
        const criticalCount = {{ $criticalWarning + $highWarning }};
        if (criticalCount > 0) {
            document.title = `(${criticalCount}) Dashboard Teknisi - Peringatan SLA`;
        }
        
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush

@endsection