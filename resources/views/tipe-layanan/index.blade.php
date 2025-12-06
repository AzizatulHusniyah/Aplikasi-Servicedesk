@extends('layouts.app')

@section('title', 'Tipe Layanan')

@section('content')
<div class="row justify-content-center" style="margin: 0; padding-top: 20px;">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-5" style="padding-bottom: 20px; border-bottom: 1px solid #e0e0e0;">
            <h4 style="font-weight: 700; color: #1E3C72; margin: 0; font-size: 1.75rem;">Data Tipe Layanan</h4>
            <a href="{{ route('tipe-layanan.create') }}" class="btn btn-primary" style="
                background-color: #1E3C72;
                border-color: #1E3C72;
                border-radius: 10px;
                font-weight: 600;
                padding: 0.6rem 1.5rem;
                box-shadow: 0 4px 10px rgba(30, 60, 114, 0.4);
                transition: all 0.3s ease;
            "
            onmouseover="this.style.backgroundColor='#18305c'; this.style.transform='translateY(-2px)'"
            onmouseout="this.style.backgroundColor='#1E3C72'; this.style.transform='translateY(0)'">
                <i class="fas fa-plus me-2"></i> Tambah Tipe Layanan
            </a>
        </div>

        <div class="card" style="
            border: none;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            font-family: 'Arial', sans-serif;
        ">
            <div class="card-body" style="padding: 2rem;">
                <div class="table-responsive">
                    <table class="table" style="margin-bottom: 0; border-collapse: separate; border-spacing: 0;">
                        <thead style="background-color: #f1f4f8;">
                            <tr>
                                <th style="color: #495057; font-weight: 700; vertical-align: middle; border-top: none; padding: 1rem 1.5rem; width: 5%;">#</th>
                                <th style="color: #495057; font-weight: 700; vertical-align: middle; border-top: none; padding: 1rem 1.5rem; width: 25%;">Nama</th>
                                <th style="color: #495057; font-weight: 700; vertical-align: middle; border-top: none; padding: 1rem 1.5rem; width: 40%;">Keterangan</th>
                                <th style="color: #495057; font-weight: 700; vertical-align: middle; border-top: none; padding: 1rem 1.5rem; width: 10%;">Status</th>
                                <th style="color: #495057; font-weight: 700; vertical-align: middle; border-top: none; padding: 1rem 1.5rem; width: 20%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tipeLayanan as $tl)
                            <tr class="table-row" style="transition: background-color 0.2s ease;"
                                onmouseover="this.style.backgroundColor='#f9f9f9'"
                                onmouseout="this.style.backgroundColor='transparent'">
                                <td style="vertical-align: middle; padding: 1rem 1.5rem; color: #6c757d; font-weight: 500;">{{ $loop->iteration }}</td>
                                <td style="vertical-align: middle; padding: 1rem 1.5rem; font-weight: 600; color: #1E3C72;">{{ $tl->nama }}</td>
                                <td style="vertical-align: middle; padding: 1rem 1.5rem; color: #495057;">{{ $tl->keterangan ?: '-' }}</td>
                                <td style="vertical-align: middle; padding: 1rem 1.5rem;">
                                    @if($tl->status_aktivasi)
                                        <span class="badge" style="
                                            background-color: #d4edda;
                                            color: #155724;
                                            font-weight: 600;
                                            padding: 0.6em 1em;
                                            border-radius: 4px;
                                            border: 1px solid #c3e6cb;
                                        ">
                                            <i class="fas fa-check-circle me-1"></i> Aktif
                                        </span>
                                    @else
                                        <span class="badge" style="
                                            background-color: #f8d7da;
                                            color: #721c24;
                                            font-weight: 600;
                                            padding: 0.6em 1em;
                                            border-radius: 4px;
                                            border: 1px solid #f5c6cb;
                                        ">
                                            <i class="fas fa-times-circle me-1"></i> Non-Aktif
                                        </span>
                                    @endif
                                </td>
                                <td style="vertical-align: middle; white-space: nowrap; padding: 1rem 1.5rem;">
                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('tipe-layanan.edit', $tl->id) }}" class="btn btn-sm" style="
                                        background-color: #28a745; 
                                        color: #fff; 
                                        border-radius: 8px; 
                                        font-weight: 500; 
                                        transition: all 0.2s ease;
                                        margin-right: 5px;
                                        padding: 0.5rem 0.8rem;
                                    "
                                    onmouseover="this.style.backgroundColor='#1e7e34'"
                                    onmouseout="this.style.backgroundColor='#28a745'"
                                    title="Edit">
                                        <i class="fas fa-wrench"></i>
                                    </a>
                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('tipe-layanan.destroy', $tl->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" style="
                                            background-color: #dc3545; 
                                            border-color: #dc3545; 
                                            border-radius: 8px; 
                                            font-weight: 500; 
                                            transition: all 0.2s ease;
                                            padding: 0.5rem 0.8rem;
                                        "
                                        onmouseover="this.style.backgroundColor='#c82333'"
                                        onmouseout="this.style.backgroundColor='#dc3545'"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus tipe layanan {{ $tl->nama }}? Aksi ini tidak dapat dibatalkan.')"
                                        title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Optional: Teks jika data kosong --}}
                @if(count($tipeLayanan) === 0)
                    <div class="text-center py-5">
                        <i class="fas fa-list-alt fa-4x mb-3" style="color: #ccc;"></i>
                        <p class="text-muted" style="font-size: 1.1rem;">Belum ada data Tipe Layanan yang terdaftar.</p>
                        <a href="{{ route('tipe-layanan.create') }}" class="btn btn-primary mt-2" style="
                            background-color: #1E3C72;
                            border-color: #1E3C72;
                            border-radius: 8px;
                            font-weight: 600;
                            padding: 0.6rem 1.5rem;
                        ">
                            <i class="fas fa-plus me-2"></i> Tambah Tipe Layanan Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection