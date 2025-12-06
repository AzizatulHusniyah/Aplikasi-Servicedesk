<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Laporan - Diskominfo Gresik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #1E3C72;
            --secondary-color: #3B62A4;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
            --light-bg: #f5f7fa;
        }

        body {
            background-color: var(--light-bg);
            font-family: 'Arial', sans-serif;
            color: #333;
        }

        .custom-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .custom-card-header {
            background-color: #fff;
            border-bottom: 2px solid var(--primary-color);
            padding: 1.5rem 2rem;
        }

        .custom-card-title {
            color: var(--primary-color);
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
            color: var(--primary-color);
        }

        .status-badge {
            font-size: 0.8rem;
            border-radius: 20px;
            font-weight: 600;
            padding: 0.5rem 1rem;
        }

        .status-replied {
            background-color: var(--success-color);
            color: white;
        }

        .status-pending {
            background-color: var(--warning-color);
            color: #212529;
        }

        .info-section {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            margin-bottom: 1.5rem;
        }

        .info-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            border-radius: 10px 10px 0 0 !important;
            padding: 1rem 1.5rem;
        }

        .reply-header {
            background: linear-gradient(135deg, var(--success-color) 0%, #20c997 100%);
            color: white;
            border-radius: 10px 10px 0 0 !important;
            padding: 1rem 1.5rem;
        }

        .info-title {
            font-weight: 600;
            margin: 0;
        }

        .info-body {
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

        .ticket-code {
            color: var(--primary-color);
            font-weight: 600;
        }

        .description-box {
            background-color: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid var(--primary-color);
            line-height: 1.6;
            padding: 1rem;
        }

        .reply-box {
            background-color: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid var(--success-color);
            line-height: 1.6;
            white-space: pre-line;
            padding: 1rem;
        }

        .attachment-actions {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .btn-custom-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            border-radius: 6px;
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-custom-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            color: white;
        }

        .btn-custom-success {
            background-color: var(--success-color);
            border-color: var(--success-color);
            color: white;
            border-radius: 6px;
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-custom-success:hover {
            background-color: #218838;
            border-color: #218838;
            color: white;
        }

        .btn-custom-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            color: white;
            border-radius: 8px;
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-custom-secondary:hover {
            background-color: #5a6268;
            border-color: #5a6268;
            color: white;
        }

        .attachment-info {
            color: #6c757d;
            font-size: 0.875rem;
        }

        .custom-alert {
            border-radius: 8px;
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
        }

        .alert-info-custom {
            border: 1px solid #b8daff;
            background-color: #d1ecf1;
            color: #0c5460;
        }

        .alert-warning-custom {
            border: 1px solid #ffeaa7;
            background-color: #fff3cd;
            color: #856404;
        }

        .action-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e9ecef;
        }

        .status-badge-small {
            background-color: var(--success-color);
            color: white;
            border-radius: 20px;
            font-weight: 500;
            padding: 0.5rem 1rem;
        }

        .status-proses {
            background-color: var(--warning-color);
            color: #212529;
        }

        .status-draft {
            background-color: #6c757d;
            color: white;
        }

        .role-badge {
            border-radius: 15px;
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            margin-left: 0.5rem;
        }

        .badge-admin {
            background-color: var(--info-color);
            color: white;
        }

        .badge-technician {
            background-color: var(--warning-color);
            color: #212529;
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card custom-card">
                    <div class="card-header custom-card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="custom-card-title">
                                    <i class="fas fa-file-alt me-2"></i> Detail Laporan
                                </h5>
                                <div class="current-time-info">
                                    <small><i class="fas fa-clock me-1"></i> Waktu Server: <span id="server-time">{{ \Carbon\Carbon::now()->timezone('Asia/Jakarta')->format('d/m/Y H:i:s') }}</span> WIB</small>
                                </div>
                            </div>
                            <span class="status-badge {{ $laporan->balasan ? 'status-replied' : 'status-pending' }}">
                                {{ $laporan->balasan ? 'Sudah Dibalas' : 'Belum Dibalas' }}
                            </span>
                        </div>
                    </div>

                    <div class="card-body" style="padding: 2rem;">
                        <!-- Informasi Laporan -->
                        <div class="card info-section">
                            <div class="card-header info-header">
                                <h6 class="info-title mb-0">
                                    <i class="fas fa-info-circle me-2"></i> Informasi Laporan
                                </h6>
                            </div>
                            <div class="card-body info-body">
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
                                        {{ \Carbon\Carbon::parse($laporan->tanggal_laporan)->format('d/m/Y') }} 
                                        {{ $laporan->waktu_laporan ? \Carbon\Carbon::parse($laporan->waktu_laporan)->timezone('Asia/Jakarta')->format('H:i') : '00:00' }} WIB
                                    </div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Status:</div>
                                    <div class="info-value">
                                        <span class="status-badge status-badge-small status-{{ $laporan->status }}">
                                            {{ ucfirst($laporan->status) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Deskripsi:</div>
                                    <div class="info-value">
                                        <div class="description-box">
                                            <p class="mb-0">{{ $laporan->deskripsi }}</p>
                                        </div>
                                    </div>
                                </div>
                                @if($laporan->lampiran_path)
                                <div class="info-row">
                                    <div class="info-label">Lampiran Laporan:</div>
                                    <div class="info-value">
                                        <div class="attachment-actions">
                                            <a href="{{ route('laporan.download.public', $laporan->id) }}" class="btn-custom-primary">
                                                <i class="fas fa-download me-1"></i> Download
                                            </a>
                                            @php
                                                $extension = pathinfo($laporan->lampiran_path, PATHINFO_EXTENSION);
                                                $isViewable = in_array(strtolower($extension), ['pdf', 'jpg', 'jpeg', 'png', 'gif']);
                                            @endphp
                                            @if($isViewable)
                                            <a href="{{ route('laporan.download.public', $laporan->id) }}" target="_blank" class="btn-custom-success">
                                                <i class="fas fa-eye me-1"></i> Lihat Langsung
                                            </a>
                                            @endif
                                        </div>
                                        <div class="attachment-info">
                                            <i class="fas fa-file me-1"></i> File: {{ basename($laporan->lampiran_path) }}
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        @if($laporan->balasan)
                        <!-- Balasan dari Teknisi/Admin -->
                        <div class="card info-section">
                            <div class="card-header reply-header">
                                <h6 class="info-title mb-0">
                                    <i class="fas fa-reply me-2"></i> Balasan dari Teknisi
                                </h6>
                            </div>
                            <div class="card-body info-body">
                                <div class="info-row">
                                    <div class="info-label">Dibalas Oleh:</div>
                                    <div class="info-value">
                                        <span style="color: var(--primary-color); font-weight: 600;">{{ $laporan->teknisi->name ?? 'N/A' }}</span>
                                        @if($laporan->teknisi && $laporan->teknisi->hasRole('administrator'))
                                            <span class="role-badge badge-admin">Administrator</span>
                                        @elseif($laporan->teknisi)
                                            <span class="role-badge badge-technician">Teknisi</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Tanggal Balasan:</div>
                                    <div class="info-value" style="color: var(--primary-color); font-weight: 500;">
                                        {{ \Carbon\Carbon::parse($laporan->dibalas_pada)->timezone('Asia/Jakarta')->format('d/m/Y H:i') }} WIB
                                    </div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Balasan:</div>
                                    <div class="info-value">
                                        <div class="reply-box">
                                            {{ $laporan->balasan }}
                                        </div>
                                    </div>
                                </div>

                                @if($laporan->lampiran_balasan_path)
                                <div class="info-row">
                                    <div class="info-label">Lampiran Balasan:</div>
                                    <div class="info-value">
                                        <div class="attachment-actions">
                                            <a href="{{ route('laporan.download.balasan.public', $laporan->id) }}" class="btn-custom-primary">
                                                <i class="fas fa-download me-1"></i> Download
                                            </a>
                                            @php
                                                $extensionBalasan = pathinfo($laporan->lampiran_balasan_path, PATHINFO_EXTENSION);
                                                $isViewableBalasan = in_array(strtolower($extensionBalasan), ['pdf', 'jpg', 'jpeg', 'png', 'gif']);
                                            @endphp
                                            @if($isViewableBalasan)
                                            <a href="{{ route('laporan.download.balasan.public', $laporan->id) }}" target="_blank" class="btn-custom-success">
                                                <i class="fas fa-eye me-1"></i> Lihat Langsung
                                            </a>
                                            @endif
                                        </div>
                                        <div class="attachment-info">
                                            <i class="fas fa-file me-1"></i> File: {{ basename($laporan->lampiran_balasan_path) }}
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        @else
                        <!-- Informasi belum ada balasan -->
                        <div class="custom-alert alert-info-custom">
                            <i class="fas fa-info-circle me-3" style="font-size: 1.25rem;"></i>
                            <div>
                                <strong>Informasi:</strong> Laporan Anda sedang dalam proses penanganan.
                                Teknisi akan memberikan balasan secepatnya.
                            </div>
                        </div>
                        @endif

                        <div class="action-footer">
                            <a href="{{ url('/welcome') }}" class="btn-custom-secondary">
                                <i class="fas fa-arrow-left me-2"></i> Kembali ke Halaman Utama
                            </a>

                            @if(!$laporan->balasan)
                            <div class="custom-alert alert-warning-custom">
                                <i class="fas fa-clock me-2"></i>
                                <span>Menunggu balasan dari teknisi</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
</body>
</html>