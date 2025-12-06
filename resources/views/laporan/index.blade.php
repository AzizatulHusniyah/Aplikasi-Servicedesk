@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
<div class="row justify-content-center" style="margin: 0; padding-top: 20px;">
    <div class="col-12">
        <div class="page-header mb-5">
            <div>
                <h4 class="page-title">Data Laporan</h4>
                <div class="current-time-info">
                    <small><i class="fas fa-clock me-1"></i> Waktu Server: <span id="server-time">Loading...</span> WIB</small>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                @can('create laporan')
                <a href="{{ route('laporan.create') }}" class="btn btn-primary custom-btn-add">
                    <i class="fas fa-plus me-2"></i> Tambah Laporan
                </a>
                @endcan
                
                <!-- Tombol Export - Hanya untuk Administrator -->
                @if(auth()->user()->hasRole('administrator'))
                <div class="btn-group">
                    <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-download me-2"></i> Export
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ route('cetak-laporan.export-excel') }}">
                                <i class="fas fa-file-excel me-2 text-success"></i> Export Excel
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('cetak-laporan.export-pdf') }}">
                                <i class="fas fa-file-pdf me-2 text-danger"></i> Export PDF
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('cetak-laporan.index') }}">
                                <i class="fas fa-print me-2 text-primary"></i> Cetak Laporan
                            </a>
                        </li>
                    </ul>
                </div>
                @endif
            </div>
        </div>

        {{-- TAMBAH: Alert untuk profil tidak lengkap --}}
        @if(auth()->user()->hasRole('user') && !auth()->user()->isProfileComplete())
            <div class="alert alert-warning alert-dismissible fade show mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle me-3 fs-4"></i>
                    <div>
                        <h6 class="alert-heading mb-1">Profil Belum Lengkap</h6>
                        <p class="mb-1">Anda tidak dapat membuat laporan karena profil Anda belum lengkap.</p>
                        <ul class="mb-2">
                            @foreach(auth()->user()->getIncompleteFields() as $field)
                                <li>{{ $field }}</li>
                            @endforeach
                        </ul>
                        <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-warning mt-2">
                            <i class="fas fa-user-edit me-1"></i> Lengkapi Profil Sekarang
                        </a>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card custom-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table custom-table">
                        <thead class="custom-thead">
                            <tr>
                                <th>#</th>
                                <th>Kode Tiket</th>
                                <th>Judul Laporan</th>
                                <th>Kategori</th>
                                <th>Layanan</th>
                                @if(auth()->user()->hasRole(['administrator', 'teknisi', 'eselon']))
                                <th>Dibuat Oleh</th>
                                @endif
                                <th>Tanggal & Waktu</th>
                                <th>Status</th>
                                <th>Balasan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($laporans as $laporan)
                            <tr class="custom-table-row">
                                <td class="serial-number">{{ $loop->iteration }}</td>
                                <td class="ticket-code">{{ $laporan->kode_tiket }}</td>
                                <td class="report-title">{{ $laporan->judul_laporan }}</td>
                                <td>
                                    <span class="badge custom-badge-category">
                                        {{ $laporan->kategoriLayanan->nama }}
                                    </span>
                                </td>
                                <td class="service-name">{{ $laporan->layanan->nama }}</td>
                                @if(auth()->user()->hasRole(['administrator', 'teknisi', 'eselon']))
                                <td class="creator-name">{{ $laporan->user->name ?? 'N/A' }}</td>
                                @endif
                                <td class="datetime">
                                    {{ \Carbon\Carbon::parse($laporan->tanggal_laporan)->format('d/m/Y') }} 
                                    {{ $laporan->waktu_laporan ? \Carbon\Carbon::parse($laporan->waktu_laporan)->format('H:i') : '00:00' }} WIB
                                </td>
                                <td>
                                    <span class="badge custom-badge-status status-{{ $laporan->status }}">
                                        {{ ucfirst($laporan->status) }}
                                    </span>
                                </td>
                                <td>
                                    @if($laporan->balasan)
                                    <span class="badge custom-badge-replied">
                                        <i class="fas fa-check-circle me-1"></i> Sudah Dibalas
                                    </span>
                                    @else
                                    <span class="badge custom-badge-pending">
                                        <i class="fas fa-clock me-1"></i> Belum Dibalas
                                    </span>
                                    @endif
                                </td>
                                    <td class="action-buttons">
                                    <a href="{{ route('laporan.show', $laporan->id) }}" class="btn btn-sm custom-btn-detail" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    @if($laporan->balasan && $laporan->lampiran_balasan_path)
                                    <a href="{{ route('balasan-laporan.view-lampiran-balasan', $laporan->id) }}"
                                    target="_blank"
                                    class="btn btn-sm custom-btn-reply"
                                    title="Lihat Lampiran Balasan">
                                        <i class="fas fa-file-alt"></i>
                                    </a>
                                    @endif

                                    @can('edit laporan')
                                    <a href="{{ route('laporan.edit', $laporan->id) }}" class="btn btn-sm custom-btn-edit" title="Edit">
                                        <i class="fas fa-wrench"></i>
                                    </a>
                                    @endcan

                                    @can('delete laporan')
                                    <form action="{{ route('laporan.destroy', $laporan->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm custom-btn-delete"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus laporan {{ $laporan->judul_laporan }}? Aksi ini tidak dapat dibatalkan.')"
                                                title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="role-info-alert">
                    <h6>
                        <i class="fas fa-info-circle me-2"></i> Informasi
                    </h6>
                    <p>
                        @if(auth()->user()->hasRole('administrator'))
                            Anda memiliki akses penuh untuk mengelola semua laporan. Waktu server: <span id="current-time">{{ \Carbon\Carbon::now()->timezone('Asia/Jakarta')->format('H:i:s') }}</span> WIB
                        @elseif(auth()->user()->hasRole('user'))
                            Anda hanya dapat melihat laporan yang Anda buat sendiri dan tidak dapat mengedit atau menghapus laporan yang sudah dibuat. 
                            @if(!auth()->user()->isProfileComplete())
                                <strong class="text-warning">Profil Anda belum lengkap. Lengkapi profil untuk dapat membuat laporan.</strong>
                            @endif
                            Waktu server: <span id="current-time">{{ \Carbon\Carbon::now()->timezone('Asia/Jakarta')->format('H:i:s') }}</span> WIB
                        @elseif(auth()->user()->hasRole('teknisi'))
                            Anda dapat melihat semua laporan namun tidak dapat membuat, mengedit, atau menghapus laporan. Waktu server: <span id="current-time">{{ \Carbon\Carbon::now()->timezone('Asia/Jakarta')->format('H:i:s') }}</span> WIB
                        @elseif(auth()->user()->hasRole('eselon'))
                            Anda dapat melihat semua laporan namun tidak dapat membuat, mengedit, atau menghapus laporan. Waktu server: <span id="current-time">{{ \Carbon\Carbon::now()->timezone('Asia/Jakarta')->format('H:i:s') }}</span> WIB
                        @endif
                    </p>
                </div>

                @if($laporans->isEmpty())
                <div class="empty-data-alert">
                    <h6>
                        <i class="fas fa-exclamation-triangle me-2"></i> Tidak ada data
                    </h6>
                    <p>Belum ada laporan yang tersedia.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
// Format angka dengan leading zero
function padZero(num) {
    return num.toString().padStart(2, '0');
}

// Format waktu dalam format Indonesia (WIB)
function formatWIBTime(date) {
    const day = padZero(date.getDate());
    const month = padZero(date.getMonth() + 1);
    const year = date.getFullYear();
    const hours = padZero(date.getHours());
    const minutes = padZero(date.getMinutes());
    const seconds = padZero(date.getSeconds());
    
    return `${day}/${month}/${year} ${hours}:${minutes}:${seconds}`;
}

// Update server time every second
function updateServerTime() {
    const now = new Date();
    
    // Format waktu untuk WIB (Asia/Jakarta)
    const wibTime = new Date(now.toLocaleString("en-US", {timeZone: "Asia/Jakarta"}));
    const timeString = formatWIBTime(wibTime);
    
    // Update waktu server di header
    document.getElementById('server-time').textContent = timeString;
    
    // Update waktu di informasi role
    const currentTimeElement = document.getElementById('current-time');
    if (currentTimeElement) {
        const timeOnly = `${padZero(wibTime.getHours())}:${padZero(wibTime.getMinutes())}:${padZero(wibTime.getSeconds())}`;
        currentTimeElement.textContent = timeOnly;
    }
}

// Update time immediately and then every second
updateServerTime();
setInterval(updateServerTime, 1000);

// Inisialisasi waktu saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    updateServerTime();
});
</script>

<style>
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding-bottom: 20px;
    border-bottom: 1px solid #e0e0e0;
}

.page-title {
    font-weight: 700;
    color: #1E3C72;
    margin: 0;
    font-size: 1.75rem;
    margin-bottom: 0.5rem;
}

.current-time-info {
    color: #6c757d;
    font-size: 0.875rem;
}

#server-time, #current-time {
    font-weight: 600;
    color: #1E3C72;
    background-color: #f8f9fa;
    padding: 2px 6px;
    border-radius: 4px;
    border: 1px solid #e9ecef;
}

.custom-btn-add {
    background-color: #1E3C72;
    border-color: #1E3C72;
    border-radius: 10px;
    font-weight: 600;
    padding: 0.6rem 1.5rem;
    box-shadow: 0 4px 10px rgba(30, 60, 114, 0.4);
    transition: all 0.3s ease;
}

.custom-btn-add:hover {
    background-color: #18305c;
    border-color: #18305c;
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(30, 60, 114, 0.4);
}

/* Style untuk tombol export */
.btn-group .btn-success {
    background-color: #28a745;
    border-color: #28a745;
    border-radius: 10px;
    font-weight: 600;
    padding: 0.6rem 1.5rem;
    box-shadow: 0 4px 10px rgba(40, 167, 69, 0.4);
    transition: all 0.3s ease;
}

.btn-group .btn-success:hover {
    background-color: #218838;
    border-color: #1e7e34;
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(40, 167, 69, 0.4);
}

.dropdown-menu {
    border-radius: 8px;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    border: none;
}

.dropdown-item {
    padding: 0.75rem 1rem;
    font-weight: 500;
    transition: all 0.2s ease;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
    color: #1E3C72;
}

.custom-card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    font-family: 'Arial', sans-serif;
}

.custom-card .card-body {
    padding: 2rem;
}

.custom-table {
    margin-bottom: 0;
    border-collapse: separate;
    border-spacing: 0;
}

.custom-thead {
    background-color: #f1f4f8;
}

.custom-thead th {
    color: #495057;
    font-weight: 700;
    vertical-align: middle;
    border-top: none;
    padding: 1rem 1.5rem;
}

.custom-table-row {
    transition: background-color 0.2s ease;
}

.custom-table-row:hover {
    background-color: #f9f9f9;
}

.serial-number {
    color: #6c757d;
    font-weight: 500;
}

.ticket-code {
    font-weight: 600;
    color: #1E3C72;
}

.report-title {
    color: #495057;
}

.service-name, .department-name, .creator-name {
    color: #495057;
}

.datetime {
    color: #6c757d;
    font-size: 0.875rem;
}

.custom-badge-category {
    background-color: #e6f7ff;
    color: #1E3C72;
    font-weight: 500;
    padding: 0.5em 0.8em;
    border-radius: 4px;
    border: 1px solid #1E3C7230;
}

.custom-badge-status {
    font-weight: 600;
    padding: 0.6em 1em;
    border-radius: 4px;
}

.status-selesai {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.status-proses {
    background-color: #fff3cd;
    color: #856404;
    border: 1px solid #ffeaa7;
}

.status-draft {
    background-color: #e2e3e5;
    color: #383d41;
    border: 1px solid #d6d8db;
}

.custom-badge-replied {
    background-color: #d4edda;
    color: #155724;
    font-weight: 600;
    padding: 0.6em 1em;
    border-radius: 4px;
    border: 1px solid #c3e6cb;
}

.custom-badge-pending {
    background-color: #e2e3e5;
    color: #383d41;
    font-weight: 600;
    padding: 0.6em 1em;
    border-radius: 4px;
    border: 1px solid #d6d8db;
}

.action-buttons {
    white-space: nowrap;
    vertical-align: middle;
}

.custom-btn-detail {
    background-color: #3B62A4;
    color: #fff;
    border-radius: 6px;
    font-weight: 500;
    transition: all 0.2s ease;
    margin-right: 5px;
    margin-bottom: 5px;
    padding: 0.5rem 0.8rem;
    border: none;
}

.custom-btn-detail:hover {
    background-color: #1E3C72;
    color: #fff;
}

.custom-btn-reply {
    background-color: #28a745;
    color: #fff;
    border-radius: 6px;
    font-weight: 500;
    transition: all 0.2s ease;
    margin-right: 5px;
    margin-bottom: 5px;
    padding: 0.5rem 0.8rem;
    border: none;
}

.custom-btn-reply:hover {
    background-color: #1e7e34;
    color: #fff;
}

.custom-btn-edit {
    background-color: #28a745;
    color: #fff;
    border-radius: 6px;
    font-weight: 500;
    transition: all 0.2s ease;
    margin-right: 5px;
    margin-bottom: 5px;
    padding: 0.5rem 0.8rem;
    border: none;
}

.custom-btn-edit:hover {
    background-color: #1e7e34;
    color: #fff;
}

.custom-btn-delete {
    background-color: #dc3545;
    border-color: #dc3545;
    color: #fff;
    border-radius: 6px;
    font-weight: 500;
    transition: all 0.2s ease;
    margin-bottom: 5px;
    padding: 0.5rem 0.8rem;
}

.custom-btn-delete:hover {
    background-color: #c82333;
    border-color: #c82333;
    color: #fff;
}

.role-info-alert {
    background-color: #e6f7ff;
    color: #1E3C72;
    border: 1px solid #1E3C7230;
    border-radius: 8px;
    padding: 1.5rem;
    margin-top: 2rem;
}

.role-info-alert h6 {
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.role-info-alert p {
    margin-bottom: 0;
    font-size: 0.9rem;
}

.empty-data-alert {
    background-color: #fff3cd;
    color: #856404;
    border: 1px solid #ffeaa7;
    border-radius: 8px;
    padding: 1.5rem;
    margin-top: 2rem;
}

.empty-data-alert h6 {
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.empty-data-alert p {
    margin-bottom: 0;
    font-size: 0.9rem;
}

/* Responsive design */
@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }
    
    .d-flex {
        width: 100%;
        justify-content: space-between;
    }
    
    .btn-group {
        width: 100%;
    }
    
    .btn-group .btn {
        width: 100%;
    }
    
    #server-time, #current-time {
        font-size: 0.8rem;
        padding: 1px 4px;
    }
}

/* TAMBAH: Style untuk alert profil tidak lengkap */
.alert-warning {
    border-left: 4px solid #ffc107;
}

.alert-warning .alert-heading {
    color: #856404;
    font-weight: 600;
}

.alert-warning ul {
    margin-bottom: 0.5rem;
}

.alert-warning ul li {
    font-size: 0.9rem;
}
</style>
@endsection