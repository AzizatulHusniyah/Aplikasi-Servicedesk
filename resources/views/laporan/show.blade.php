@extends('layouts.app')

@section('title', 'Detail Laporan')

@section('content')
<div class="row justify-content-center" style="margin: 0; padding-top: 20px;">
    <div class="col-md-10">
        <div class="card custom-card">
            <div class="card-header custom-card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-0">
                            <i class="fas fa-file-alt me-2"></i> Detail Laporan
                        </h5>
                        <div class="current-time-info">
                            <small><i class="fas fa-clock me-1"></i> Waktu Server: <span id="server-time">{{ \Carbon\Carbon::now()->timezone('Asia/Jakarta')->format('d/m/Y H:i:s') }}</span> WIB</small>
                        </div>
                    </div>
                    <span class="badge custom-status-badge {{ $laporan->balasan ? 'replied' : 'pending' }}">
                        {{ $laporan->balasan ? 'Sudah Dibalas' : 'Belum Dibalas' }}
                    </span>
                </div>
            </div>

            <div class="card-body">
                <!-- Informasi Laporan -->
                <div class="info-card mb-4">
                    <div class="info-card-header">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-info-circle me-2"></i> Informasi Laporan Anda
                        </h6>
                    </div>
                    <div class="info-card-body">
                        <div class="info-row">
                            <div class="info-label">Kode Tiket:</div>
                            <div class="info-value ticket-code">{{ $laporan->kode_tiket }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Judul:</div>
                            <div class="info-value">{{ $laporan->judul_laporan }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Kategori:</div>
                            <div class="info-value">{{ $laporan->kategoriLayanan->nama }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Layanan:</div>
                            <div class="info-value">{{ $laporan->layanan->nama }}</div>
                        </div>
                        <!-- HAPUS BAGIAN PERANGKAT DAERAH -->
                        <div class="info-row">
                            <div class="info-label">Tanggal & Waktu Laporan:</div>
                            <div class="info-value">
                                {{ $laporan->tanggal_laporan->format('d/m/Y') }} 
                                {{ $laporan->waktu_laporan ? \Carbon\Carbon::parse($laporan->waktu_laporan)->timezone('Asia/Jakarta')->format('H:i') : '00:00' }} WIB
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Status:</div>
                            <div class="info-value">
                                <span class="badge custom-status-badge status-{{ $laporan->status }}">
                                    {{ ucfirst($laporan->status) }}
                                </span>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Deskripsi:</div>
                            <div class="info-value full-width">
                                <div class="description-box">
                                    <p class="mb-0">{{ $laporan->deskripsi }}</p>
                                </div>
                            </div>
                        </div>
                        @if($laporan->lampiran_path)
                        <div class="info-row">
                            <div class="info-label">Lampiran Anda:</div>
                            <div class="info-value full-width">
                                <div class="attachment-actions">
                                    <a href="{{ route('laporan.download', $laporan->id) }}" class="btn btn-sm custom-btn-download">
                                        <i class="fas fa-download me-1"></i> Download
                                    </a>
                                    <a href="{{ route('balasan-laporan.view-lampiran-laporan', $laporan->id) }}"
                                       target="_blank"
                                       class="btn btn-sm custom-btn-view">
                                        <i class="fas fa-eye me-1"></i> Lihat Langsung
                                    </a>
                                </div>
                                <div class="attachment-info">
                                    <small>
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
                <div class="reply-card mb-4">
                    <div class="reply-card-header">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-reply me-2"></i> Balasan dari Teknisi
                        </h6>
                    </div>
                    <div class="reply-card-body">
                        <div class="info-row">
                            <div class="info-label">Dibalas Oleh:</div>
                            <div class="info-value">
                                <span class="technician-name">{{ $laporan->teknisi->name ?? 'N/A' }}</span>
                                @if($laporan->teknisi && $laporan->teknisi->hasRole('administrator'))
                                    <span class="badge role-badge admin">Administrator</span>
                                @elseif($laporan->teknisi)
                                    <span class="badge role-badge technician">Teknisi</span>
                                @endif
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Tanggal Balasan:</div>
                            <div class="info-value reply-date">
                                {{ $laporan->dibalas_pada->timezone('Asia/Jakarta')->format('d/m/Y H:i') }} WIB
                            </div>
                        </div>
                        <div class="info-row full-width">
                            <div class="info-label">Balasan:</div>
                            <div class="info-value full-width">
                                <div class="reply-content">
                                    {!! nl2br(e($laporan->balasan)) !!}
                                </div>
                            </div>
                        </div>

                        @if($laporan->lampiran_balasan_path)
                        <div class="info-row full-width">
                            <div class="info-label">Lampiran Balasan dari Teknisi:</div>
                            <div class="info-value full-width">
                                <div class="attachment-actions">
                                    <a href="{{ route('balasan-laporan.download-lampiran', $laporan->id) }}" class="btn btn-sm custom-btn-download">
                                        <i class="fas fa-download me-1"></i> Download
                                    </a>
                                    <a href="{{ route('balasan-laporan.view-lampiran-balasan', $laporan->id) }}"
                                       target="_blank"
                                       class="btn btn-sm custom-btn-view">
                                        <i class="fas fa-eye me-1"></i> Lihat Langsung
                                    </a>
                                </div>
                                <div class="attachment-info">
                                    <small>
                                        <i class="fas fa-file me-1"></i> File: {{ basename($laporan->lampiran_balasan_path) }}
                                    </small>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @else
                <!-- Informasi belum ada balasan -->
                <div class="alert alert-info custom-alert-info">
                    <i class="fas fa-info-circle me-3"></i>
                    <div>
                        <strong>Informasi:</strong> Laporan Anda sedang dalam proses penanganan.
                        Teknisi akan memberikan balasan secepatnya.
                    </div>
                </div>
                @endif

                <div class="action-footer">
                    <a href="{{ route('laporan.index') }}" class="btn custom-btn-back">
                        <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar Laporan
                    </a>

                    @if(!$laporan->balasan)
                    <div class="waiting-alert">
                        <i class="fas fa-clock me-2"></i>
                        <span>Menunggu balasan dari teknisi</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Update server time every second
function updateServerTime() {
    const now = new Date();
    const options = { 
        timeZone: 'Asia/Jakarta',
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
        hour12: false,
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
    };
    
    const dateString = now.toLocaleDateString('id-ID', options);
    const timeString = now.toLocaleTimeString('id-ID', options);
    const dateTimeString = `${dateString} ${timeString}`;
    
    document.getElementById('server-time').textContent = dateTimeString;
}

// Update time immediately and then every second
updateServerTime();
setInterval(updateServerTime, 1000);
</script>

<style>
.custom-card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    font-family: 'Arial', sans-serif;
}

.custom-card-header {
    background-color: #fff;
    border-bottom: 2px solid #1E3C72;
    padding: 1.5rem 2rem;
}

.custom-card-header .card-title {
    color: #1E3C72;
    font-weight: 700;
    margin: 0;
    font-size: 1.5rem;
}

.current-time-info {
    color: #6c757d;
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

#server-time {
    font-weight: 600;
    color: #1E3C72;
}

.custom-status-badge {
    font-size: 0.8rem;
    border-radius: 20px;
    font-weight: 600;
    padding: 0.5rem 1rem;
}

.custom-status-badge.replied {
    background-color: #28a745;
    color: white;
}

.custom-status-badge.pending {
    background-color: #ffc107;
    color: #212529;
}

.info-card, .reply-card {
    border: none;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}

.info-card-header {
    background: linear-gradient(135deg, #1E3C72 0%, #3B62A4 100%);
    color: white;
    border-radius: 10px 10px 0 0 !important;
    padding: 1rem 1.5rem;
}

.reply-card-header {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
    border-radius: 10px 10px 0 0 !important;
    padding: 1rem 1.5rem;
}

.info-card-header .card-title,
.reply-card-header .card-title {
    font-weight: 600;
    margin: 0;
}

.info-card-body, .reply-card-body {
    padding: 1.5rem;
}

.info-row {
    display: flex;
    margin-bottom: 1rem;
    align-items: flex-start;
}

.info-label {
    flex: 0 0 200px;
    font-weight: 600;
    color: #495057;
}

.info-value {
    flex: 1;
    color: #333;
}

.info-value.full-width {
    width: 100%;
}

.ticket-code {
    color: #1E3C72;
    font-weight: 600;
}

.technician-name {
    color: #1E3C72;
    font-weight: 600;
}

.reply-date {
    color: #1E3C72;
    font-weight: 500;
}

.role-badge {
    border-radius: 15px;
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
    margin-left: 0.5rem;
}

.role-badge.admin {
    background-color: #17a2b8;
    color: white;
}

.role-badge.technician {
    background-color: #ffc107;
    color: #212529;
}

.description-box, .reply-content {
    background-color: #f8f9fa;
    border-radius: 8px;
    border-left: 4px solid #1E3C72;
    line-height: 1.6;
    padding: 1rem;
}

.reply-content {
    border-left-color: #28a745;
    white-space: pre-line;
}

.attachment-actions {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 0.5rem;
}

.custom-btn-download {
    background-color: #1E3C72;
    border-color: #1E3C72;
    color: white;
    border-radius: 6px;
    font-weight: 500;
    padding: 0.5rem 1rem;
    transition: all 0.3s ease;
    border: none;
}

.custom-btn-download:hover {
    background-color: #3B62A4;
    border-color: #3B62A4;
    color: white;
}

.custom-btn-view {
    background-color: #28a745;
    border-color: #28a745;
    color: white;
    border-radius: 6px;
    font-weight: 500;
    padding: 0.5rem 1rem;
    transition: all 0.3s ease;
    border: none;
}

.custom-btn-view:hover {
    background-color: #218838;
    border-color: #218838;
    color: white;
}

.attachment-info {
    color: #6c757d;
    font-size: 0.875rem;
}

.custom-alert-info {
    border-radius: 8px;
    border: 1px solid #b8daff;
    background-color: #d1ecf1;
    color: #0c5460;
    padding: 1rem 1.5rem;
    display: flex;
    align-items: center;
}

.action-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid #e9ecef;
}

.custom-btn-back {
    background-color: #6c757d;
    border-color: #6c757d;
    color: white;
    border-radius: 8px;
    font-weight: 500;
    padding: 0.75rem 1.5rem;
    transition: all 0.3s ease;
    text-decoration: none;
}

.custom-btn-back:hover {
    background-color: #5a6268;
    border-color: #5a6268;
    color: white;
}

.waiting-alert {
    background-color: #fff3cd;
    color: #856404;
    border: 1px solid #ffeaa7;
    border-radius: 8px;
    padding: 0.75rem 1.25rem;
    display: flex;
    align-items: center;
    margin: 0;
}

.status-selesai {
    background-color: #28a745;
    color: white;
}

.status-proses {
    background-color: #ffc107;
    color: #212529;
}

.status-draft {
    background-color: #6c757d;
    color: white;
}
</style>
@endsection