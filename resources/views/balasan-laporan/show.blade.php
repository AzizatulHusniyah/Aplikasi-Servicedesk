@extends('layouts.app')

@section('title', 'Detail Laporan & Balasan - Teknisi')

@section('content')
<div class="row justify-content-center" style="margin: 0; padding-top: 20px;">
    <div class="col-md-10">
        <div class="card" style="
            border: none;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            font-family: 'Arial', sans-serif;
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
                        <i class="fas fa-file-alt me-2" style="color: #3B62A4;"></i> Detail Laporan & Balasan
                    </h5>
                    <span class="badge px-3 py-2" style="
                        background-color: {{ $laporan->balasan ? '#28a745' : '#ffc107' }};
                        color: {{ $laporan->balasan ? 'white' : '#212529' }};
                        font-size: 0.8rem;
                        border-radius: 20px;
                        font-weight: 600;
                    ">
                        {{ $laporan->balasan ? 'Sudah Dibalas' : 'Belum Dibalas' }}
                    </span>
                </div>
            </div>

            <div class="card-body" style="padding: 2rem;">
                <!-- Informasi Laporan -->
                <div class="card mb-4" style="
                    border: none;
                    border-radius: 10px;
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
                ">
                    <div class="card-header" style="
                        background: linear-gradient(135deg, #1E3C72 0%, #3B62A4 100%);
                        color: white;
                        border-radius: 10px 10px 0 0 !important;
                        padding: 1rem 1.5rem;
                    ">
                        <h6 class="card-title mb-0" style="font-weight: 600;">
                            <i class="fas fa-user me-2"></i> Laporan dari User
                        </h6>
                    </div>
                    <div class="card-body" style="padding: 1.5rem;">
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold" style="color: #495057;">User:</div>
                            <div class="col-md-8">{{ $laporan->user->name }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold" style="color: #495057;">Judul:</div>
                            <div class="col-md-8">{{ $laporan->judul_laporan }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold" style="color: #495057;">Kategori:</div>
                            <div class="col-md-8">{{ $laporan->kategoriLayanan->nama }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold" style="color: #495057;">Layanan:</div>
                            <div class="col-md-8">{{ $laporan->layanan->nama }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold" style="color: #495057;">Deskripsi:</div>
                            <div class="col-md-8">
                                <div class="p-3 rounded" style="
                                    background-color: #f8f9fa;
                                    border-radius: 8px;
                                    border-left: 4px solid #1E3C72;
                                    line-height: 1.6;
                                ">
                                    <p class="mb-0">{{ $laporan->deskripsi }}</p>
                                </div>
                            </div>
                        </div>
                        @if($laporan->lampiran_path)
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold" style="color: #495057;">Lampiran Laporan:</div>
                            <div class="col-md-8">
                                <div class="d-flex gap-2 mb-2">
                                    <a href="{{ route('laporan.download', $laporan->id) }}" class="btn btn-sm px-3 py-2" style="
                                        background-color: #1E3C72;
                                        border-color: #1E3C72;
                                        color: white;
                                        border-radius: 6px;
                                        font-weight: 500;
                                        transition: all 0.3s ease;
                                    "
                                    onmouseover="this.style.backgroundColor='#3B62A4'; this.style.borderColor='#3B62A4'"
                                    onmouseout="this.style.backgroundColor='#1E3C72'; this.style.borderColor='#1E3C72'">
                                        <i class="fas fa-download me-1"></i> Download
                                    </a>
                                    <a href="{{ route('balasan-laporan.view-lampiran-laporan', $laporan->id) }}"
                                       target="_blank"
                                       class="btn btn-sm px-3 py-2" style="
                                        background-color: #28a745;
                                        border-color: #28a745;
                                        color: white;
                                        border-radius: 6px;
                                        font-weight: 500;
                                        transition: all 0.3s ease;
                                    "
                                    onmouseover="this.style.backgroundColor='#218838'; this.style.borderColor='#218838'"
                                    onmouseout="this.style.backgroundColor='#28a745'; this.style.borderColor='#28a745'">
                                        <i class="fas fa-eye me-1"></i> Lihat Langsung
                                    </a>
                                </div>
                                <div>
                                    <small class="text-muted" style="font-size: 0.875rem;">
                                        <i class="fas fa-file me-1"></i> File: {{ basename($laporan->lampiran_path) }}
                                    </small>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                @if($laporan->balasan)
                <!-- Balasan dari Teknisi/Admin -->
                <div class="card mb-4" style="
                    border: none;
                    border-radius: 10px;
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
                ">
                    <div class="card-header" style="
                        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
                        color: white;
                        border-radius: 10px 10px 0 0 !important;
                        padding: 1rem 1.5rem;
                    ">
                        <h6 class="card-title mb-0" style="font-weight: 600;">
                            <i class="fas fa-reply me-2"></i> Balasan
                            @if($laporan->teknisi && $laporan->teknisi->hasRole('administrator'))
                                <span class="badge ms-2 px-2 py-1" style="
                                    background-color: #17a2b8;
                                    color: white;
                                    border-radius: 15px;
                                    font-size: 0.75rem;
                                ">Administrator</span>
                            @elseif($laporan->teknisi)
                                <span class="badge ms-2 px-2 py-1" style="
                                    background-color: #ffc107;
                                    color: #212529;
                                    border-radius: 15px;
                                    font-size: 0.75rem;
                                ">Teknisi</span>
                            @endif
                        </h6>
                    </div>
                    <div class="card-body" style="padding: 1.5rem;">
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold" style="color: #495057;">Dibalas Oleh:</div>
                            <div class="col-md-8">
                                <span style="color: #1E3C72; font-weight: 600;">{{ $laporan->teknisi->name ?? 'N/A' }}</span>
                                @if($laporan->teknisi && $laporan->teknisi->hasRole('administrator'))
                                    <span class="badge ms-2 px-2 py-1" style="
                                        background-color: #17a2b8;
                                        color: white;
                                        border-radius: 15px;
                                        font-size: 0.75rem;
                                    ">Administrator</span>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold" style="color: #495057;">Tanggal Balasan:</div>
                            <div class="col-md-8" style="color: #1E3C72; font-weight: 500;">
                                {{ $laporan->dibalas_pada->format('d/m/Y H:i') }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold" style="color: #495057;">Status:</div>
                            <div class="col-md-8">
                                <span class="badge px-3 py-2" style="
                                    background-color: {{ $laporan->status == 'selesai' ? '#28a745' : ($laporan->status == 'proses' ? '#ffc107' : '#6c757d') }};
                                    color: {{ $laporan->status == 'proses' ? '#212529' : 'white' }};
                                    border-radius: 20px;
                                    font-weight: 500;
                                ">
                                    {{ ucfirst($laporan->status) }}
                                </span>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-12">
                                <strong style="color: #495057;">Balasan:</strong>
                                <div class="mt-2 p-3 rounded" style="
                                    background-color: #f8f9fa;
                                    border-radius: 8px;
                                    border-left: 4px solid #28a745;
                                    line-height: 1.6;
                                ">
                                    {!! nl2br(e($laporan->balasan)) !!}
                                </div>
                            </div>
                        </div>

                        {{-- TAMPILKAN LAMPIRAN BALASAN --}}
                        @if($laporan->lampiran_balasan_path)
                        <div class="row">
                            <div class="col-12">
                                <strong style="color: #495057;">Lampiran Balasan:</strong>
                                <div class="mt-2">
                                    <div class="d-flex flex-wrap gap-2 mb-2">
                                        <a href="{{ route('balasan-laporan.download-lampiran', $laporan->id) }}" class="btn btn-sm px-3 py-2" style="
                                            background-color: #1E3C72;
                                            border-color: #1E3C72;
                                            color: white;
                                            border-radius: 6px;
                                            font-weight: 500;
                                            transition: all 0.3s ease;
                                        "
                                        onmouseover="this.style.backgroundColor='#3B62A4'; this.style.borderColor='#3B62A4'"
                                        onmouseout="this.style.backgroundColor='#1E3C72'; this.style.borderColor='#1E3C72'">
                                            <i class="fas fa-download me-1"></i> Download
                                        </a>
                                        <a href="{{ route('balasan-laporan.view-lampiran-balasan', $laporan->id) }}"
                                           target="_blank"
                                           class="btn btn-sm px-3 py-2" style="
                                            background-color: #28a745;
                                            border-color: #28a745;
                                            color: white;
                                            border-radius: 6px;
                                            font-weight: 500;
                                            transition: all 0.3s ease;
                                        "
                                        onmouseover="this.style.backgroundColor='#218838'; this.style.borderColor='#218838'"
                                        onmouseout="this.style.backgroundColor='#28a745'; this.style.borderColor='#28a745'">
                                            <i class="fas fa-eye me-1"></i> Lihat Langsung
                                        </a>

                                        {{-- Hanya teknisi pemilik balasan atau admin yang bisa menghapus lampiran --}}
                                        @if((auth()->user()->hasRole('teknisi') && $laporan->teknisi_id == auth()->id()) || auth()->user()->hasRole('administrator'))
                                        <form action="{{ route('balasan-laporan.hapus-lampiran', $laporan->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm px-3 py-2" style="
                                                background-color: #dc3545;
                                                border-color: #dc3545;
                                                color: white;
                                                border-radius: 6px;
                                                font-weight: 500;
                                                transition: all 0.3s ease;
                                            "
                                            onmouseover="this.style.backgroundColor='#c82333'; this.style.borderColor='#c82333'"
                                            onmouseout="this.style.backgroundColor='#dc3545'; this.style.borderColor='#dc3545'"
                                            onclick="return confirm('Yakin ingin menghapus lampiran?')">
                                                <i class="fas fa-trash me-1"></i> Hapus Lampiran
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                    <div>
                                        <small class="text-muted" style="font-size: 0.875rem;">
                                            <i class="fas fa-file me-1"></i> File: {{ basename($laporan->lampiran_balasan_path) }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                    <a href="{{ route('balasan-laporan.index') }}" class="btn px-4 py-2" style="
                        background-color: #6c757d;
                        border-color: #6c757d;
                        color: white;
                        border-radius: 8px;
                        font-weight: 500;
                        transition: all 0.3s ease;
                    "
                    onmouseover="this.style.backgroundColor='#5a6268'; this.style.borderColor='#5a6268'"
                    onmouseout="this.style.backgroundColor='#6c757d'; this.style.borderColor='#6c757d'">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </a>

                    @if(!$laporan->balasan)
                    <a href="{{ route('balasan-laporan.create', $laporan->id) }}" class="btn px-4 py-2" style="
                        background-color: #28a745;
                        border-color: #28a745;
                        color: white;
                        border-radius: 8px;
                        font-weight: 500;
                        transition: all 0.3s ease;
                    "
                    onmouseover="this.style.backgroundColor='#218838'; this.style.borderColor='#218838'; this.style.boxShadow='0 4px 10px rgba(40, 167, 69, 0.4)'"
                    onmouseout="this.style.backgroundColor='#28a745'; this.style.borderColor='#28a745'; this.style.boxShadow='none'">
                        <i class="fas fa-reply me-2"></i> Balas Laporan
                    </a>
                    @elseif($laporan->teknisi_id == auth()->id() || auth()->user()->hasRole('administrator'))
                    <a href="{{ route('balasan-laporan.edit', $laporan->id) }}" class="btn px-4 py-2" style="
                        background-color: #ffc107;
                        border-color: #ffc107;
                        color: #212529;
                        border-radius: 8px;
                        font-weight: 500;
                        transition: all 0.3s ease;
                    "
                    onmouseover="this.style.backgroundColor='#e0a800'; this.style.borderColor='#e0a800'; this.style.boxShadow='0 4px 10px rgba(255, 193, 7, 0.4)'"
                    onmouseout="this.style.backgroundColor='#ffc107'; this.style.borderColor='#ffc107'; this.style.boxShadow='none'">
                        <i class="fas fa-edit me-2"></i> Edit Balasan
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection