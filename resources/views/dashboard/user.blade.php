@extends('layouts.app')

@section('title', 'Dashboard User')

@section('content')
<div class="container-fluid">
    {{-- Card Sambutan --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient-primary text-white py-3 d-flex align-items-center">
                    <i class="fas fa-home fa-lg me-3"></i>
                    <h5 class="m-0 fw-bold">Selamat Datang</h5>
                </div>
                <div class="card-body">
                    <h4 class="text-dark fw-bold mb-3">Halo, {{ Auth::user()->name }}!</h4>
                    <p class="mb-0 text-muted" style="font-size: 1.1rem; line-height: 1.6;">
                        Ini adalah halaman dashboard aplikasi manajemen laporan Diskominfo Gresik.
                        Di sini Anda dapat memantau status dan progress laporan yang telah Anda buat.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- Alert Status Laporan -->
    @if($laporanStats['total'] > 0)
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-primary alert-dismissible fade show" role="alert" style="
                border-left: 4px solid #1E3C72;
                border-radius: 8px;
                background: #f8f9fa;
                box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            " id="mainStatusAlert">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-chart-bar fa-lg me-3" style="color: #1E3C72;"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="alert-heading mb-2" style="color: #495057; font-weight: 600;">
                            STATUS LAPORAN ANDA
                        </h5>
                        <p class="mb-2" style="color: #6c757d;">
                            Anda memiliki total <strong class="text-primary">{{ $laporanStats['total'] }} laporan</strong>,
                            dengan <strong class="text-success">{{ $laporanStats['selesai'] }}</strong> laporan telah selesai.
                        </p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-info alert-dismissible fade show" role="alert" style="
                border-left: 4px solid #17a2b8;
                border-radius: 8px;
                background: #f8f9fa;
                box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            ">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-clipboard-list fa-lg me-3" style="color: #17a2b8;"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="alert-heading mb-1" style="color: #495057; font-weight: 600;">
                            Belum Ada Laporan
                        </h5>
                        <p class="mb-0" style="color: #6c757d;">
                            Anda belum membuat laporan. Mulai buat laporan pertama Anda sekarang.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row mb-4 g-3 justify-content-center">
        <div class="col-auto">
            <div class="card border-start-primary border-start-4 shadow h-100" style="width: 200px;">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs fw-semibold text-primary text-uppercase mb-1">
                                Total
                            </div>
                            <div class="h5 mb-0 fw-bold text-gray-800">
                                {{ $totalLaporan }}
                            </div>
                        </div>
                        <div class="ms-2">
                            <i class="fas fa-clipboard-list fa-lg text-primary-soft"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Laporan Baru -->
        <div class="col-auto">
            <div class="card border-start-warning border-start-4 shadow h-100" style="width: 200px;">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs fw-semibold text-warning text-uppercase mb-1">
                                Baru
                            </div>
                            <div class="h5 mb-0 fw-bold text-gray-800">
                                {{ $laporanBaru }}
                            </div>
                        </div>
                        <div class="ms-2">
                            <i class="fas fa-plus-circle fa-lg text-warning-soft"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: Dalam Proses -->
        <div class="col-auto">
            <div class="card border-start-info border-start-4 shadow h-100" style="width: 200px;">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs fw-semibold text-info text-uppercase mb-1">
                                Proses
                            </div>
                            <div class="h5 mb-0 fw-bold text-gray-800">
                                {{ $laporanDiproses }}
                            </div>
                        </div>
                        <div class="ms-2">
                            <i class="fas fa-spinner fa-lg text-info-soft"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 4: Selesai -->
        <div class="col-auto">
            <div class="card border-start-success border-start-4 shadow h-100" style="width: 200px;">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs fw-semibold text-success text-uppercase mb-1">
                                Selesai
                            </div>
                            <div class="h5 mb-0 fw-bold text-gray-800">
                                {{ $laporanSelesai }}
                            </div>
                        </div>
                        <div class="ms-2">
                            <i class="fas fa-check-circle fa-lg text-success-soft"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Progress & Status Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient-primary text-white py-3 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-chart-line fa-lg me-3"></i>
                        <h5 class="m-0 fw-bold">Progress & Status Laporan</h5>
                    </div>
                    @if($laporanStats['total'] > 0)
                    <span class="badge bg-white text-primary fw-bold px-3 py-2 rounded-pill">
                        {{ $laporanStats['total'] }} Laporan
                    </span>
                    @endif
                </div>
                <div class="card-body p-0">
                    @if($laporanStats['total'] > 0)
                        <div class="p-4">
                            {{-- Progress Bar Keseluruhan --}}
                            <div class="mb-4">
                                <h6 class="fw-bold text-dark mb-3" style="font-size: 1.1rem;">Progress Keseluruhan</h6>
                                <div class="progress" style="
                                    height: 40px; 
                                    border-radius: 10px; 
                                    border: 1px solid #e9ecef;
                                    overflow: hidden;
                                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
                                ">
                                    {{-- Selesai (Hijau) --}}
                                    <div class="progress-bar d-flex align-items-center justify-content-center"
                                         style="
                                             width: {{ $laporanStats['persentase_selesai'] }}%; 
                                             background-color: #28a745 !important; 
                                             font-weight: 600; 
                                             font-size: 14px;
                                             transition: all 0.3s ease;
                                         ">
                                        <span>Selesai: {{ $laporanStats['persentase_selesai'] }}%</span>
                                    </div>
                                    {{-- Proses (Biru Diskominfo) --}}
                                    <div class="progress-bar d-flex align-items-center justify-content-center"
                                         style="
                                             width: {{ $laporanStats['persentase_proses'] }}%; 
                                             background-color: #1E3C72 !important; 
                                             font-weight: 600; 
                                             font-size: 14px;
                                             transition: all 0.3s ease;
                                         ">
                                        <span>Proses: {{ $laporanStats['persentase_proses'] }}%</span>
                                    </div>
                                    {{-- Draft (Abu-abu) --}}
                                    <div class="progress-bar d-flex align-items-center justify-content-center"
                                         style="
                                             width: {{ $laporanStats['persentase_draft'] }}%; 
                                             background-color: #6c757d !important; 
                                             font-weight: 600; 
                                             font-size: 14px;
                                             transition: all 0.3s ease;
                                         ">
                                        <span>Draft: {{ $laporanStats['persentase_draft'] }}%</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Statistik Detail --}}
                            <div class="row mt-4">
                                <div class="col-md-4 text-center">
                                    <div class="card border-start-success border-start-4 shadow-sm h-100 py-3">
                                        <div class="card-body">
                                            <div class="h2 fw-bold text-success mb-2">{{ $laporanStats['selesai'] }}</div>
                                            <div class="text-muted">Laporan Selesai</div>
                                            <small class="text-success fw-semibold">{{ $laporanStats['persentase_selesai'] }}%</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 text-center">
                                    <div class="card border-start-primary border-start-4 shadow-sm h-100 py-3">
                                        <div class="card-body">
                                            <div class="h2 fw-bold text-primary mb-2">{{ $laporanStats['proses'] }}</div>
                                            <div class="text-muted">Dalam Proses</div>
                                            <small class="text-primary fw-semibold">{{ $laporanStats['persentase_proses'] }}%</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 text-center">
                                    <div class="card border-start-secondary border-start-4 shadow-sm h-100 py-3">
                                        <div class="card-body">
                                            <div class="h2 fw-bold text-secondary mb-2">{{ $laporanStats['draft'] }}</div>
                                            <div class="text-muted">Draft</div>
                                            <small class="text-secondary fw-semibold">{{ $laporanStats['persentase_draft'] }}%</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <div class="avatar-lg bg-info-soft text-info rounded-circle d-inline-flex align-items-center justify-content-center">
                                    <i class="fas fa-clipboard-list fa-3x"></i>
                                </div>
                            </div>
                            <h4 class="text-info fw-bold mb-2">Belum ada laporan</h4>
                            <p class="text-muted mb-4">Mulai buat laporan pertama Anda untuk melihat progress di sini</p>
                            <a href="{{ route('laporan.create') }}" class="btn btn-primary btn-lg" style="
                                background-color: #1E3C72;
                                border-color: #1E3C72;
                                border-radius: 8px;
                                font-weight: 600;
                                padding: 0.75rem 2rem;
                                transition: all 0.3s ease;
                            ">
                                <i class="fas fa-plus me-2"></i>Buat Laporan Pertama
                            </a>
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

    .bg-gradient-primary {
        background: linear-gradient(135deg, #1E3C72 0%, #3B62A4 100%);
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

    .avatar-lg {
        width: 80px;
        height: 80px;
    }

    .border-start-primary {
        border-left-color: #1E3C72 !important;
    }

    .border-start-warning {
        border-left-color: #f6c23e !important;
    }

    .border-start-info {
        border-left-color: #36b9cc !important;
    }

    .border-start-success {
        border-left-color: #1cc88a !important;
    }
    
    .border-start-secondary {
        border-left-color: #6c757d !important;
    }
</style>

<!-- JavaScript -->
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Hover effect for the create report button
        const createBtn = document.querySelector('a[href="{{ route('laporan.create') }}"]');
        if (createBtn) {
            createBtn.addEventListener('mouseenter', function() {
                this.style.backgroundColor = '#3B62A4';
                this.style.borderColor = '#3B62A4';
                this.style.boxShadow = '0 4px 10px rgba(30, 60, 114, 0.4)';
            });
            
            createBtn.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '#1E3C72';
                this.style.borderColor = '#1E3C72';
                this.style.boxShadow = 'none';
            });
        }
        
        // Initialize tooltips if any
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush

@endsection