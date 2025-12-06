@extends('layouts.app')

@section('title', 'Balasan Laporan')

@section('content')
<div class="row justify-content-center" style="margin: 0; padding-top: 20px;">
    <div class="col-12">
        <!-- Header Section -->
        <div class="card mb-4" style="
            border: none;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        ">
            <div class="card-header" style="
                background-color: #fff;
                border-bottom: 2px solid #1E3C72;
                padding: 1.5rem 2rem;
            ">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title" style="
                        color: #1E3C72;
                        font-weight: 700;
                        margin: 0;
                        font-size: 1.5rem;
                    ">
                        <i class="fas fa-reply-all me-2" style="color: #3B62A4;"></i> Manajemen Balasan Laporan
                    </h5>
                    <a href="{{ route('laporan.index') }}" class="btn px-4 py-2" style="
                        background-color: #6c757d;
                        border-color: #6c757d;
                        color: white;
                        border-radius: 8px;
                        font-weight: 500;
                        transition: all 0.3s ease;
                    "
                    onmouseover="this.style.backgroundColor='#5a6268'; this.style.borderColor='#5a6268'"
                    onmouseout="this.style.backgroundColor='#6c757d'; this.style.borderColor='#6c757d'">
                        <i class="fas fa-arrow-left me-2"></i> Kembali ke Laporan
                    </a>
                </div>
            </div>
        </div>

        <!-- Informasi Role -->
        @if(auth()->user()->hasRole('administrator'))
        <div class="alert alert-info d-flex align-items-center mb-4" style="
            border-radius: 8px;
            border: 1px solid #b8daff;
            background-color: #d1ecf1;
            color: #0c5460;
            padding: 1rem 1.5rem;
        ">
            <i class="fas fa-user-shield me-3" style="font-size: 1.25rem;"></i>
            <div>
                <strong>Mode Administrator:</strong> Anda dapat melihat dan mengelola semua balasan laporan.
            </div>
        </div>
        @elseif(auth()->user()->hasRole('teknisi'))
        <div class="alert alert-warning d-flex align-items-center mb-4" style="
            border-radius: 8px;
            border: 1px solid #ffeaa7;
            background-color: #fff3cd;
            color: #856404;
            padding: 1rem 1.5rem;
        ">
            <i class="fas fa-tools me-3" style="font-size: 1.25rem;"></i>
            <div>
                <strong>Mode Teknisi:</strong> Anda hanya dapat melihat laporan yang terkait dengan layanan Anda.
            </div>
        </div>
        @elseif(auth()->user()->hasRole('eselon'))
        <div class="alert alert-secondary d-flex align-items-center mb-4" style="
            border-radius: 8px;
            border: 1px solid #d6d8db;
            background-color: #e2e3e5;
            color: #383d41;
            padding: 1rem 1.5rem;
        ">
            <i class="fas fa-eye me-3" style="font-size: 1.25rem;"></i>
            <div>
                <strong>Mode Eselon:</strong> Anda dapat melihat semua balasan laporan (view-only).
            </div>
        </div>
        @else
        <div class="alert alert-success d-flex align-items-center mb-4" style="
            border-radius: 8px;
            border: 1px solid #c3e6cb;
            background-color: #d4edda;
            color: #155724;
            padding: 1rem 1.5rem;
        ">
            <i class="fas fa-user me-3" style="font-size: 1.25rem;"></i>
            <div>
                <strong>Mode User:</strong> Anda hanya dapat melihat balasan laporan yang Anda buat.
            </div>
        </div>
        @endif

        <!-- Statistik -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card text-white mb-3" style="
                    background: linear-gradient(135deg, #1E3C72 0%, #3B62A4 100%);
                    border: none;
                    border-radius: 10px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                ">
                    <div class="card-body" style="padding: 1.5rem;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 style="font-weight: 700; margin: 0;">{{ $laporansBelumDibalas->count() + $laporansSudahDibalas->count() }}</h4>
                                <p style="margin: 0.5rem 0 0 0; opacity: 0.9;">Total Laporan</p>
                            </div>
                            <div>
                                <i class="fas fa-file-alt fa-2x" style="opacity: 0.8;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white mb-3" style="
                    background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
                    border: none;
                    border-radius: 10px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                ">
                    <div class="card-body" style="padding: 1.5rem;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 style="font-weight: 700; margin: 0;">{{ $laporansBelumDibalas->count() }}</h4>
                                <p style="margin: 0.5rem 0 0 0; opacity: 0.9;">Belum Dibalas</p>
                            </div>
                            <div>
                                <i class="fas fa-clock fa-2x" style="opacity: 0.8;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white mb-3" style="
                    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
                    border: none;
                    border-radius: 10px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                ">
                    <div class="card-body" style="padding: 1.5rem;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 style="font-weight: 700; margin: 0;">{{ $laporansSudahDibalas->count() }}</h4>
                                <p style="margin: 0.5rem 0 0 0; opacity: 0.9;">Sudah Dibalas</p>
                            </div>
                            <div>
                                <i class="fas fa-check-circle fa-2x" style="opacity: 0.8;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white mb-3" style="
                    background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%);
                    border: none;
                    border-radius: 10px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                ">
                    <div class="card-body" style="padding: 1.5rem;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 style="font-weight: 700; margin: 0;">{{ $laporansSudahDibalas->where('status', 'selesai')->count() }}</h4>
                                <p style="margin: 0.5rem 0 0 0; opacity: 0.9;">Selesai</p>
                            </div>
                            <div>
                                <i class="fas fa-flag-checkered fa-2x" style="opacity: 0.8;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Pencarian -->
        <div class="card mb-4" style="
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        ">
            <div class="card-body" style="padding: 1.5rem;">
                <form method="GET" action="{{ route('balasan-laporan.index') }}" id="searchForm">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="input-group">
                                <input type="text"
                                       class="form-control"
                                       name="search"
                                       id="searchInput"
                                       placeholder="Cari berdasarkan nama teknisi atau email..."
                                       value="{{ request('search') }}"
                                       autocomplete="off"
                                       style="
                                           border-radius: 8px 0 0 8px;
                                           padding: 0.75rem 1rem;
                                           border: 1px solid #ced4da;
                                           transition: border-color 0.3s ease, box-shadow 0.3s ease;
                                       "
                                       onfocus="this.style.borderColor='#1E3C72'; this.style.boxShadow='0 0 0 0.2rem rgba(30, 60, 114, 0.1)'"
                                       onblur="this.style.borderColor='#ced4da'; this.style.boxShadow='none'">
                                <button class="btn px-4" type="submit" style="
                                    background-color: #1E3C72;
                                    border-color: #1E3C72;
                                    color: white;
                                    border-radius: 0 8px 8px 0;
                                    font-weight: 500;
                                    transition: all 0.3s ease;
                                "
                                onmouseover="this.style.backgroundColor='#3B62A4'; this.style.borderColor='#3B62A4'"
                                onmouseout="this.style.backgroundColor='#1E3C72'; this.style.borderColor='#1E3C72'">
                                    <i class="fas fa-search me-1"></i> Cari
                                </button>
                                @if(request('search'))
                                <a href="{{ route('balasan-laporan.index') }}" class="btn px-4" style="
                                    background-color: #dc3545;
                                    border-color: #dc3545;
                                    color: white;
                                    border-radius: 0 8px 8px 0;
                                    margin-left: 5px;
                                    font-weight: 500;
                                    transition: all 0.3s ease;
                                "
                                onmouseover="this.style.backgroundColor='#c82333'; this.style.borderColor='#c82333'"
                                onmouseout="this.style.backgroundColor='#dc3545'; this.style.borderColor='#dc3545'">
                                    <i class="fas fa-times me-1"></i> Clear
                                </a>
                                @endif
                            </div>
                            <div class="form-text mt-2" style="color: #6c757d; font-size: 0.875rem;">
                                <i class="fas fa-info-circle me-1"></i> Ketik nama teknisi atau email untuk mencari laporan yang ditangani oleh teknisi tertentu.
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Hasil Pencarian -->
                @if(request('search'))
                <div class="mt-3">
                    <div class="alert alert-info d-flex align-items-center mb-0" style="
                        border-radius: 8px;
                        border: 1px solid #b8daff;
                        background-color: #d1ecf1;
                        color: #0c5460;
                        padding: 0.75rem 1.25rem;
                    ">
                        <i class="fas fa-info-circle me-2"></i>
                        <div>
                            Menampilkan hasil pencarian untuk: <strong>"{{ request('search') }}"</strong>
                            <span class="badge ms-2 px-2 py-1" style="
                                background-color: #1E3C72;
                                color: white;
                                border-radius: 15px;
                                font-size: 0.75rem;
                            ">
                                Total: {{ $laporansBelumDibalas->count() + $laporansSudahDibalas->count() }} laporan
                            </span>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Tabs untuk navigasi -->
        <div class="card mb-4" style="
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        ">
            <div class="card-body" style="padding: 0;">
                <ul class="nav nav-tabs" id="myTab" role="tablist" style="
                    border-bottom: 1px solid #dee2e6;
                    padding: 0 1.5rem;
                ">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active px-4 py-3" id="belum-dibalas-tab" data-bs-toggle="tab" data-bs-target="#belum-dibalas" type="button" role="tab" style="
                            border: none;
                            border-bottom: 3px solid transparent;
                            font-weight: 600;
                            color: #6c757d;
                            transition: all 0.3s ease;
                        "
                        onmouseover="this.style.color='#1E3C72'"
                        onmouseout="if(this.classList.contains('active')) {this.style.color='#1E3C72'} else {this.style.color='#6c757d'}">
                            Belum Dibalas
                            @if($laporansBelumDibalas->count() > 0)
                            <span class="badge ms-2 px-2 py-1" style="
                                background-color: #dc3545;
                                color: white;
                                border-radius: 15px;
                                font-size: 0.75rem;
                            ">{{ $laporansBelumDibalas->count() }}</span>
                            @endif
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link px-4 py-3" id="sudah-dibalas-tab" data-bs-toggle="tab" data-bs-target="#sudah-dibalas" type="button" role="tab" style="
                            border: none;
                            border-bottom: 3px solid transparent;
                            font-weight: 600;
                            color: #6c757d;
                            transition: all 0.3s ease;
                        "
                        onmouseover="this.style.color='#1E3C72'"
                        onmouseout="if(this.classList.contains('active')) {this.style.color='#1E3C72'} else {this.style.color='#6c757d'}">
                            Sudah Dibalas
                            <span class="badge ms-2 px-2 py-1" style="
                                background-color: #28a745;
                                color: white;
                                border-radius: 15px;
                                font-size: 0.75rem;
                            ">{{ $laporansSudahDibalas->count() }}</span>
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent" style="padding: 1.5rem;">
                    <!-- Tab Belum Dibalas -->
                    <div class="tab-pane fade show active" id="belum-dibalas" role="tabpanel">
                        @if($laporansBelumDibalas->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover" style="
                                border-radius: 8px;
                                overflow: hidden;
                                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
                            ">
                                <thead style="
                                    background: linear-gradient(135deg, #1E3C72 0%, #3B62A4 100%);
                                    color: white;
                                ">
                                    <tr>
                                        <th style="padding: 1rem; border: none; font-weight: 600;">#</th>
                                        <th style="padding: 1rem; border: none; font-weight: 600;">Kode Tiket</th>
                                        <th style="padding: 1rem; border: none; font-weight: 600;">Judul Laporan</th>
                                        <th style="padding: 1rem; border: none; font-weight: 600;">User</th>
                                        <th style="padding: 1rem; border: none; font-weight: 600;">Teknisi</th>
                                        <th style="padding: 1rem; border: none; font-weight: 600;">Kategori</th>
                                        <th style="padding: 1rem; border: none; font-weight: 600;">Layanan</th>
                                        <th style="padding: 1rem; border: none; font-weight: 600;">Perangkat Daerah</th>
                                        <th style="padding: 1rem; border: none; font-weight: 600;">Tanggal</th>
                                        <th style="padding: 1rem; border: none; font-weight: 600;">Status</th>
                                        <th style="padding: 1rem; border: none; font-weight: 600; width: 180px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($laporansBelumDibalas as $laporan)
                                    <tr style="border-bottom: 1px solid #dee2e6;">
                                        <td style="padding: 1rem; vertical-align: middle;">{{ $loop->iteration }}</td>
                                        <td style="padding: 1rem; vertical-align: middle;">
                                            <span class="badge px-3 py-2" style="
                                                background-color: #1E3C72;
                                                color: white;
                                                border-radius: 20px;
                                                font-weight: 500;
                                            ">{{ $laporan->kode_tiket }}</span>
                                        </td>
                                        <td style="padding: 1rem; vertical-align: middle;">{{ $laporan->judul_laporan }}</td>
                                        <td style="padding: 1rem; vertical-align: middle;">{{ $laporan->user->name }}</td>
                                        <td style="padding: 1rem; vertical-align: middle;">
                                            @if($laporan->teknisi)
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <strong>{{ $laporan->teknisi->name }}</strong>
                                                        <br>
                                                        <small class="text-muted">{{ $laporan->teknisi->email }}</small>
                                                    </div>
                                                    @if(auth()->id() == $laporan->teknisi_id)
                                                        <span class="badge ms-2 px-2 py-1" style="
                                                            background-color: #17a2b8;
                                                            color: white;
                                                            border-radius: 15px;
                                                            font-size: 0.75rem;
                                                        ">Anda</span>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-muted">Belum ditetapkan</span>
                                            @endif
                                        </td>
                                        <td style="padding: 1rem; vertical-align: middle;">{{ $laporan->kategoriLayanan->nama }}</td>
                                        <td style="padding: 1rem; vertical-align: middle;">{{ $laporan->layanan->nama }}</td>
                                        <td style="padding: 1rem; vertical-align: middle;">
                                            {{ $laporan->perangkatDaerah ? $laporan->perangkatDaerah->nama : 'Tidak tersedia' }}
                                        </td>
                                        <td style="padding: 1rem; vertical-align: middle;">{{ $laporan->tanggal_laporan->format('d/m/Y') }}</td>
                                        <td style="padding: 1rem; vertical-align: middle;">
                                            <span class="badge px-3 py-2" style="
                                                background-color: {{ $laporan->status == 'selesai' ? '#28a745' : ($laporan->status == 'proses' ? '#ffc107' : '#6c757d') }};
                                                color: {{ $laporan->status == 'proses' ? '#212529' : 'white' }};
                                                border-radius: 20px;
                                                font-weight: 500;
                                            ">
                                                {{ $laporan->status }}
                                            </span>
                                        </td>
                                        <td style="padding: 1rem; vertical-align: middle;">
                                            <div class="d-flex flex-column gap-1">
                                                <a href="{{ route('balasan-laporan.show', $laporan->id) }}" class="btn btn-sm px-3 py-2 d-flex align-items-center justify-content-center" style="
                                                    background-color: #17a2b8;
                                                    border-color: #17a2b8;
                                                    color: white;
                                                    border-radius: 6px;
                                                    font-weight: 500;
                                                    transition: all 0.3s ease;
                                                "
                                                onmouseover="this.style.backgroundColor='#138496'; this.style.borderColor='#138496'"
                                                onmouseout="this.style.backgroundColor='#17a2b8'; this.style.borderColor='#17a2b8'"
                                                title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>

                                                @canany(['balas laporan', 'edit balasan-laporan'])
                                                    @if(auth()->user()->hasRole('administrator') || (auth()->user()->hasRole('teknisi') && $laporan->teknisi_id == auth()->id()))
                                                    <a href="{{ route('balasan-laporan.create', $laporan->id) }}" class="btn btn-sm px-3 py-2 d-flex align-items-center justify-content-center" style="
                                                        background-color: #28a745;
                                                        border-color: #28a745;
                                                        color: white;
                                                        border-radius: 6px;
                                                        font-weight: 500;
                                                        transition: all 0.3s ease;
                                                    "
                                                    onmouseover="this.style.backgroundColor='#218838'; this.style.borderColor='#218838'"
                                                    onmouseout="this.style.backgroundColor='#28a745'; this.style.borderColor='#28a745'"
                                                    title="Balas Laporan">
                                                        <i class="fas fa-reply"></i>
                                                    </a>
                                                    @endif
                                                @endcanany
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="alert alert-{{ request('search') ? 'warning' : 'success' }} d-flex align-items-center" style="
                            border-radius: 8px;
                            border: 1px solid {{ request('search') ? '#ffeaa7' : '#c3e6cb' }};
                            background-color: {{ request('search') ? '#fff3cd' : '#d4edda' }};
                            color: {{ request('search') ? '#856404' : '#155724' }};
                            padding: 1rem 1.5rem;
                        ">
                            <i class="fas fa-{{ request('search') ? 'exclamation-triangle' : 'check-circle' }} me-3" style="font-size: 1.25rem;"></i>
                            <div>
                                @if(request('search'))
                                    Tidak ditemukan laporan yang ditangani oleh teknisi dengan kata kunci "{{ request('search') }}"
                                @else
                                    Semua laporan sudah ditanggapi!
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Tab Sudah Dibalas -->
                    <div class="tab-pane fade" id="sudah-dibalas" role="tabpanel">
                        @if($laporansSudahDibalas->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover" style="
                                border-radius: 8px;
                                overflow: hidden;
                                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
                            ">
                                <thead style="
                                    background: linear-gradient(135deg, #1E3C72 0%, #3B62A4 100%);
                                    color: white;
                                ">
                                    <tr>
                                        <th style="padding: 1rem; border: none; font-weight: 600;">#</th>
                                        <th style="padding: 1rem; border: none; font-weight: 600;">Kode Tiket</th>
                                        <th style="padding: 1rem; border: none; font-weight: 600;">Judul Laporan</th>
                                        <th style="padding: 1rem; border: none; font-weight: 600;">User Pelapor</th>
                                        <th style="padding: 1rem; border: none; font-weight: 600;">Teknisi</th>
                                        <th style="padding: 1rem; border: none; font-weight: 600;">Dibalas Oleh</th>
                                        <th style="padding: 1rem; border: none; font-weight: 600;">Perangkat Daerah</th>
                                        <th style="padding: 1rem; border: none; font-weight: 600;">Tanggal Balasan</th>
                                        <th style="padding: 1rem; border: none; font-weight: 600;">Status</th>
                                        <th style="padding: 1rem; border: none; font-weight: 600; width: 220px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($laporansSudahDibalas as $laporan)
                                    <tr style="border-bottom: 1px solid #dee2e6;">
                                        <td style="padding: 1rem; vertical-align: middle;">{{ $loop->iteration }}</td>
                                        <td style="padding: 1rem; vertical-align: middle;">
                                            <span class="badge px-3 py-2" style="
                                                background-color: #1E3C72;
                                                color: white;
                                                border-radius: 20px;
                                                font-weight: 500;
                                            ">{{ $laporan->kode_tiket }}</span>
                                        </td>
                                        <td style="padding: 1rem; vertical-align: middle;">{{ $laporan->judul_laporan }}</td>
                                        <td style="padding: 1rem; vertical-align: middle;">{{ $laporan->user->name }}</td>
                                        <td style="padding: 1rem; vertical-align: middle;">
                                            @if($laporan->teknisi)
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <strong>{{ $laporan->teknisi->name }}</strong>
                                                        <br>
                                                        <small class="text-muted">{{ $laporan->teknisi->email }}</small>
                                                    </div>
                                                    @if(auth()->id() == $laporan->teknisi_id)
                                                        <span class="badge ms-2 px-2 py-1" style="
                                                            background-color: #17a2b8;
                                                            color: white;
                                                            border-radius: 15px;
                                                            font-size: 0.75rem;
                                                        ">Anda</span>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-muted">Belum ditetapkan</span>
                                            @endif
                                        </td>
                                        <td style="padding: 1rem; vertical-align: middle;">
                                            @if($laporan->teknisi)
                                                {{ $laporan->teknisi->name }}
                                                @if(auth()->id() == $laporan->teknisi_id)
                                                    <span class="badge ms-2 px-2 py-1" style="
                                                        background-color: #17a2b8;
                                                        color: white;
                                                        border-radius: 15px;
                                                        font-size: 0.75rem;
                                                    ">Anda</span>
                                                @elseif($laporan->teknisi->hasRole('administrator'))
                                                    <span class="badge ms-2 px-2 py-1" style="
                                                        background-color: #6f42c1;
                                                        color: white;
                                                        border-radius: 15px;
                                                        font-size: 0.75rem;
                                                    ">Administrator</span>
                                                @else
                                                    <span class="badge ms-2 px-2 py-1" style="
                                                        background-color: #6c757d;
                                                        color: white;
                                                        border-radius: 15px;
                                                        font-size: 0.75rem;
                                                    ">Teknisi</span>
                                                @endif
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td style="padding: 1rem; vertical-align: middle;">
                                            {{ $laporan->perangkatDaerah ? $laporan->perangkatDaerah->nama : 'Tidak tersedia' }}
                                        </td>
                                        <td style="padding: 1rem; vertical-align: middle;">{{ $laporan->dibalas_pada->format('d/m/Y H:i') }}</td>
                                        <td style="padding: 1rem; vertical-align: middle;">
                                            <span class="badge px-3 py-2" style="
                                                background-color: {{ $laporan->status == 'selesai' ? '#28a745' : ($laporan->status == 'proses' ? '#ffc107' : '#6c757d') }};
                                                color: {{ $laporan->status == 'proses' ? '#212529' : 'white' }};
                                                border-radius: 20px;
                                                font-weight: 500;
                                            ">
                                                {{ $laporan->status }}
                                            </span>
                                        </td>
                                        <td style="padding: 1rem; vertical-align: middle;">
                                            <div class="d-flex flex-column gap-1">
                                                <div class="d-flex gap-1">
                                                    <a href="{{ route('balasan-laporan.show', $laporan->id) }}" class="btn btn-sm px-3 py-2 flex-fill d-flex align-items-center justify-content-center" style="
                                                        background-color: #17a2b8;
                                                        border-color: #17a2b8;
                                                        color: white;
                                                        border-radius: 6px;
                                                        font-weight: 500;
                                                        transition: all 0.3s ease;
                                                    "
                                                    onmouseover="this.style.backgroundColor='#138496'; this.style.borderColor='#138496'"
                                                    onmouseout="this.style.backgroundColor='#17a2b8'; this.style.borderColor='#17a2b8'"
                                                    title="Lihat Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>

                                                    @canany(['balas laporan', 'edit balasan-laporan'])
                                                        @if(auth()->user()->hasRole('administrator') || $laporan->teknisi_id == auth()->id())
                                                        <a href="{{ route('balasan-laporan.edit', $laporan->id) }}" class="btn btn-sm px-3 py-2 flex-fill d-flex align-items-center justify-content-center" style="
                                                            background-color: #ffc107;
                                                            border-color: #ffc107;
                                                            color: #212529;
                                                            border-radius: 6px;
                                                            font-weight: 500;
                                                            transition: all 0.3s ease;
                                                        "
                                                        onmouseover="this.style.backgroundColor='#e0a800'; this.style.borderColor='#e0a800'"
                                                        onmouseout="this.style.backgroundColor='#ffc107'; this.style.borderColor='#ffc107'"
                                                        title="Edit Balasan">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        @endif
                                                    @endcanany
                                                </div>

                                                {{-- Tombol untuk melihat lampiran --}}
                                                <div class="d-flex gap-1">
                                                    @if($laporan->lampiran_path)
                                                    <a href="{{ route('balasan-laporan.view-lampiran-laporan', $laporan->id) }}"
                                                    target="_blank"
                                                    class="btn btn-sm px-3 py-2 flex-fill d-flex align-items-center justify-content-center" style="
                                                        background-color: #6c757d;
                                                        border-color: #6c757d;
                                                        color: white;
                                                        border-radius: 6px;
                                                        font-weight: 500;
                                                        transition: all 0.3s ease;
                                                    "
                                                    onmouseover="this.style.backgroundColor='#5a6268'; this.style.borderColor='#5a6268'"
                                                    onmouseout="this.style.backgroundColor='#6c757d'; this.style.borderColor='#6c757d'"
                                                    title="Lihat Lampiran Laporan">
                                                        <i class="fas fa-file"></i>
                                                    </a>
                                                    @endif

                                                    @if($laporan->lampiran_balasan_path)
                                                    <a href="{{ route('balasan-laporan.view-lampiran-balasan', $laporan->id) }}"
                                                    target="_blank"
                                                    class="btn btn-sm px-3 py-2 flex-fill d-flex align-items-center justify-content-center" style="
                                                        background-color: #28a745;
                                                        border-color: #28a745;
                                                        color: white;
                                                        border-radius: 6px;
                                                        font-weight: 500;
                                                        transition: all 0.3s ease;
                                                    "
                                                    onmouseover="this.style.backgroundColor='#218838'; this.style.borderColor='#218838'"
                                                    onmouseout="this.style.backgroundColor='#28a745'; this.style.borderColor='#28a745'"
                                                    title="Lihat Lampiran Balasan">
                                                        <i class="fas fa-file-alt"></i>
                                                    </a>
                                                    @endif
                                                </div>

                                                @can('delete balasan-laporan')
                                                <form action="{{ route('balasan-laporan.destroy', $laporan->id) }}" method="POST" class="w-100">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm px-3 py-2 w-100 d-flex align-items-center justify-content-center" style="
                                                        background-color: #dc3545;
                                                        border-color: #dc3545;
                                                        color: white;
                                                        border-radius: 6px;
                                                        font-weight: 500;
                                                        transition: all 0.3s ease;
                                                    "
                                                    onmouseover="this.style.backgroundColor='#c82333'; this.style.borderColor='#c82333'"
                                                    onmouseout="this.style.backgroundColor='#dc3545'; this.style.borderColor='#dc3545'"
                                                    onclick="return confirm('Hapus balasan laporan ini? Tindakan ini akan menghapus balasan dan mengembalikan laporan ke status belum dibalas.')"
                                                    title="Hapus Balasan">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="alert alert-{{ request('search') ? 'warning' : 'info' }} d-flex align-items-center" style="
                            border-radius: 8px;
                            border: 1px solid {{ request('search') ? '#ffeaa7' : '#b8daff' }};
                            background-color: {{ request('search') ? '#fff3cd' : '#d1ecf1' }};
                            color: {{ request('search') ? '#856404' : '#0c5460' }};
                            padding: 1rem 1.5rem;
                        ">
                            <i class="fas fa-{{ request('search') ? 'exclamation-triangle' : 'info-circle' }} me-3" style="font-size: 1.25rem;"></i>
                            <div>
                                @if(request('search'))
                                    Tidak ditemukan laporan yang sudah dibalas oleh teknisi dengan kata kunci "{{ request('search') }}"
                                @else
                                    Belum ada laporan yang sudah dibalas.
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Inisialisasi tab
    document.addEventListener('DOMContentLoaded', function() {
        var triggerTabList = [].slice.call(document.querySelectorAll('#myTab button'))
        triggerTabList.forEach(function (triggerEl) {
            var tabTrigger = new bootstrap.Tab(triggerEl)
            triggerEl.addEventListener('click', function (event) {
                event.preventDefault()
                tabTrigger.show()
            })
        })

        // Auto-submit form setelah 1 detik tanpa mengetik (debounce)
        let searchTimeout;
        const searchInput = document.getElementById('searchInput');
        const searchForm = document.getElementById('searchForm');

        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function() {
                // Hanya submit jika ada nilai (lebih dari 2 karakter) atau kosong (untuk clear)
                if (searchInput.value.length === 0 || searchInput.value.length >= 2) {
                    searchForm.submit();
                }
            }, 1000); // 1 detik delay
        });

        // Submit form ketika tekan Enter
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                clearTimeout(searchTimeout);
                searchForm.submit();
            }
        });

        // Focus pada input pencarian
        searchInput.focus();

        // Highlight teks yang dicari dalam tabel
        @if(request('search'))
        const searchTerm = "{{ request('search') }}";
        const tables = document.querySelectorAll('table');

        tables.forEach(table => {
            const rows = table.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm.toLowerCase())) {
                    row.style.backgroundColor = '#fff3cd'; // Highlight warna kuning
                }
            });
        });
        @endif
    });
</script>
@endsection