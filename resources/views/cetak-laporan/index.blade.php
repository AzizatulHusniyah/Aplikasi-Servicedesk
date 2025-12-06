@extends('layouts.app')

@section('title', 'Cetak Laporan')

@section('content')
<div class="row justify-content-center" style="margin: 0; padding-top: 20px;">
    <div class="col-12">
        @if(!auth()->user()->hasRole('administrator'))
        <div class="alert alert-danger text-center">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Akses Ditolak!</strong> Hanya administrator yang dapat mengakses halaman ini.
        </div>
        @else
        <div class="page-header mb-4">
            <div>
                <h4 class="page-title">Cetak Laporan</h4>
                <p class="mb-0">Export data laporan ke format Excel atau PDF</p>
            </div>
            <div class="btn-group">
                <a href="{{ route('cetak-laporan.export-excel') }}" class="btn btn-success">
                    <i class="fas fa-file-excel me-2"></i> Export Excel
                </a>
                <a href="{{ route('cetak-laporan.export-pdf') }}" class="btn btn-danger">
                    <i class="fas fa-file-pdf me-2"></i> Export PDF
                </a>
                <a href="{{ route('laporan.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Kode Tiket</th>
                                <th>Kategori</th>
                                <th>Layanan</th>
                                <th>PD Pemberi Layanan</th>
                                <th>Jenis Layanan</th>
                                <th>Judul Laporan</th>
                                <th>Deskripsi</th>
                                <th>Pelapor</th>
                                <th>Email Pelapor</th>
                                <th>PD Pelapor</th>
                                <th>Status</th>
                                <th>Tanggal Laporan</th>
                                <th>SLA Layanan</th>
                                <th>Sisa SLA</th>
                                <th>Status SLA</th>
                                <th>Durasi Aktual</th>
                                <th>Tgl Penyelesaian</th>
                                <th>Balasan</th>
                                <th>Teknisi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($laporans as $laporan)
                            @php
                                // Dapatkan informasi SLA dari layanan
                                $slaLayanan = '-';
                                $sisaSla = '-';
                                $statusSla = '-';
                                $statusSlaClass = 'bg-secondary';
                                
                                if ($laporan->layanan && $laporan->layanan->sla_hari) {
                                    $slaLayanan = $laporan->layanan->sla_hari . ' hari';
                                    $sisaSla = $laporan->sisa_sla . ' hari';
                                    $statusSla = $laporan->status_sla;
                                    
                                    // Tentukan class badge untuk status SLA
                                    switch ($laporan->status_sla) {
                                        case 'lewat':
                                            $statusSlaClass = 'bg-danger';
                                            $statusSla = 'LEWAT SLA';
                                            break;
                                        case 'kritis':
                                            $statusSlaClass = 'bg-warning';
                                            $statusSla = 'KRITIS (≤1 hari)';
                                            break;
                                        case 'warning':
                                            $statusSlaClass = 'bg-info';
                                            $statusSla = 'PERINGATAN (≤3 hari)';
                                            break;
                                        case 'aman':
                                            $statusSlaClass = 'bg-success';
                                            $statusSla = 'AMAN';
                                            break;
                                        case 'tidak_ada_sla':
                                            $statusSlaClass = 'bg-secondary';
                                            $statusSla = 'TIDAK ADA SLA';
                                            break;
                                    }
                                }

                                // Hitung durasi penyelesaian aktual
                                $durasiAktual = '-';
                                $tanggalPenyelesaian = '-';
                                if ($laporan->dibalas_pada && $laporan->created_at) {
                                    $durasiHari = $laporan->created_at->diffInDays($laporan->dibalas_pada);
                                    $durasiAktual = $durasiHari . ' hari';
                                    $tanggalPenyelesaian = $laporan->dibalas_pada->timezone('Asia/Jakarta')->format('d/m/Y H:i');
                                }
                                
                                $balasan = $laporan->balasan ?? 'Belum ada balasan';
                                $balasan = strip_tags($balasan);
                                $balasan = str_replace(['=== Balasan Sebelumnya', '=== Balasan Baru'], '', $balasan);
                                
                                // Dapatkan jenis layanan
                                $jenisLayanan = '-';
                                if ($laporan->layanan) {
                                    if ($laporan->layanan->administrasi_pemerintahan && $laporan->layanan->publik) {
                                        $jenisLayanan = 'Adm & Publik';
                                    } elseif ($laporan->layanan->administrasi_pemerintahan) {
                                        $jenisLayanan = 'Adm Pemerintah';
                                    } elseif ($laporan->layanan->publik) {
                                        $jenisLayanan = 'Publik';
                                    }
                                }
                                
                                // Dapatkan perangkat daerah pelapor
                                $perangkatDaerahPelapor = 'Tidak tersedia';
                                if ($laporan->user && $laporan->user->perangkatDaerah) {
                                    $perangkatDaerahPelapor = $laporan->user->perangkatDaerah->nama;
                                } elseif ($laporan->user && $laporan->user->perangkat_daerah) {
                                    $perangkatDaerahPelapor = $laporan->user->perangkat_daerah;
                                }
                            @endphp
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $laporan->kode_tiket }}</td>
                                <td>{{ $laporan->kategoriLayanan->nama ?? '-' }}</td>
                                <td>{{ $laporan->layanan->nama ?? '-' }}</td>
                                <td>{{ $laporan->layanan->perangkatDaerah->nama ?? '-' }}</td>
                                <td>{{ $jenisLayanan }}</td>
                                <td>{{ $laporan->judul_laporan }}</td>
                                <td>{{ Str::limit($laporan->deskripsi ?? '-', 50) }}</td>
                                <td>{{ $laporan->user->name ?? '-' }}</td>
                                <td>{{ $laporan->user->email ?? '-' }}</td>
                                <td>{{ $perangkatDaerahPelapor }}</td>
                                <td class="text-center">
                                    <span class="badge bg-{{ $laporan->status == 'selesai' ? 'success' : ($laporan->status == 'proses' ? 'warning' : 'secondary') }}">
                                        {{ $laporan->status }}
                                    </span>
                                </td>
                                <td>
                                    {{ $laporan->tanggal_laporan->format('d/m/Y') }}<br>
                                    <small>{{ $laporan->waktu_laporan ? \Carbon\Carbon::parse($laporan->waktu_laporan)->format('H:i') : '00:00' }} WIB</small>
                                </td>
                                <td class="text-center">{{ $slaLayanan }}</td>
                                <td class="text-center">{{ $sisaSla }}</td>
                                <td class="text-center">
                                    <span class="badge {{ $statusSlaClass }}">
                                        {{ $statusSla }}
                                    </span>
                                </td>
                                <td class="text-center">{{ $durasiAktual }}</td>
                                <td>{{ $tanggalPenyelesaian }}</td>
                                <td>
                                    @if($laporan->balasan)
                                        <span title="{{ $balasan }}">
                                            {{ Str::limit($balasan, 50) }}
                                        </span>
                                    @else
                                        <em class="text-muted">Belum ada balasan</em>
                                    @endif
                                </td>
                                <td>{{ $laporan->teknisi->name ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($laporans->isEmpty())
                <div class="alert alert-warning text-center">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Tidak ada data laporan untuk ditampilkan.
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

<style>
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-bottom: 20px;
    border-bottom: 1px solid #dee2e6;
}

.page-title {
    font-weight: 700;
    color: #1E3C72;
    margin: 0;
}

.table th {
    background-color: #1E3C72;
    color: white;
    font-weight: 600;
    font-size: 0.875rem;
}

.table td {
    font-size: 0.875rem;
    vertical-align: middle;
}

.btn-group .btn {
    margin-left: 5px;
}

.alert-danger {
    background-color: #f8d7da;
    border-color: #f5c6cb;
    color: #721c24;
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1rem;
}
</style>
@endsection