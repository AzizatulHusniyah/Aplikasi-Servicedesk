<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Tiket Layanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 8px;
            margin: 0;
            padding: 15px;
            line-height: 1.2;
        }
        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px solid #1E3C72;
            padding-bottom: 8px;
        }
        .header h1 {
            color: #1E3C72;
            margin: 0;
            font-size: 14px;
        }
        .header p {
            margin: 3px 0;
            color: #666;
            font-size: 8px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            font-size: 7px;
            table-layout: fixed;
        }
        th {
            background-color: #1E3C72;
            color: white;
            padding: 5px 3px;
            text-align: left;
            font-weight: bold;
            word-wrap: break-word;
        }
        td {
            padding: 3px 2px;
            border: 1px solid #ddd;
            vertical-align: top;
            word-wrap: break-word;
        }
        .text-center {
            text-align: center;
        }
        .badge {
            padding: 2px 4px;
            border-radius: 2px;
            font-size: 6px;
            font-weight: bold;
        }
        .badge-selesai { background-color: #d4edda; color: #155724; }
        .badge-proses { background-color: #fff3cd; color: #856404; }
        .badge-draft { background-color: #e2e3e5; color: #383d41; }
        .badge-sla-lewat { background-color: #f8d7da; color: #721c24; }
        .badge-sla-kritis { background-color: #fff3cd; color: #856404; }
        .badge-sla-warning { background-color: #cce7ff; color: #004085; }
        .badge-sla-aman { background-color: #d4edda; color: #155724; }
        .badge-sla-tidak-ada { background-color: #e2e3e5; color: #383d41; }
        .footer {
            margin-top: 15px;
            text-align: right;
            font-size: 7px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 8px;
        }
        .page-break {
            page-break-after: always;
        }
        /* Column widths */
        .col-no { width: 20px; }
        .col-tiket { width: 70px; }
        .col-kategori { width: 60px; }
        .col-layanan { width: 60px; }
        .col-pd-layanan { width: 70px; }
        .col-jenis { width: 50px; }
        .col-judul { width: 80px; }
        .col-deskripsi { width: 80px; }
        .col-pelapor { width: 60px; }
        .col-email { width: 70px; }
        .col-pd-pelapor { width: 70px; }
        .col-status { width: 40px; }
        .col-tanggal { width: 60px; }
        .col-sla-layanan { width: 40px; }
        .col-sisa-sla { width: 40px; }
        .col-status-sla { width: 50px; }
        .col-durasi { width: 40px; }
        .col-tgl-selesai { width: 60px; }
        .col-balasan { width: 80px; }
        .col-teknisi { width: 60px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN TIKET LAYANAN</h1>
        <p>Sistem Manajemen Laporan - Dinas Komunikasi dan Informatika</p>
        <p>Periode: {{ \Carbon\Carbon::now()->timezone('Asia/Jakarta')->format('d/m/Y H:i') }} WIB</p>
    </div>

    <table>
        <thead>
            <tr>
                <th class="col-no">No</th>
                <th class="col-tiket">Kode Tiket</th>
                <th class="col-kategori">Kategori Layanan</th>
                <th class="col-layanan">Layanan</th>
                <th class="col-pd-layanan">PD Pemberi Layanan</th>
                <th class="col-jenis">Jenis Layanan</th>
                <th class="col-judul">Judul Laporan</th>
                <th class="col-deskripsi">Deskripsi Laporan</th>
                <th class="col-pelapor">Nama Pelapor</th>
                <th class="col-email">Email Pelapor</th>
                <th class="col-pd-pelapor">PD Pelapor</th>
                <th class="col-status">Status</th>
                <th class="col-tanggal">Tanggal Laporan</th>
                <th class="col-sla-layanan">SLA Layanan</th>
                <th class="col-sisa-sla">Sisa SLA</th>
                <th class="col-status-sla">Status SLA</th>
                <th class="col-durasi">Durasi Aktual</th>
                <th class="col-tgl-selesai">Tgl Penyelesaian</th>
                <th class="col-balasan">Balasan/Keterangan</th>
                <th class="col-teknisi">Teknisi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporans as $index => $laporan)
            @php
                // Dapatkan informasi SLA dari layanan
                $slaLayanan = '-';
                $sisaSla = '-';
                $statusSla = '-';
                $statusSlaClass = 'badge-sla-tidak-ada';
                
                if ($laporan->layanan && $laporan->layanan->sla_hari) {
                    $slaLayanan = $laporan->layanan->sla_hari . ' hari';
                    $sisaSla = $laporan->sisa_sla . ' hari';
                    $statusSla = $laporan->status_sla;
                    
                    // Tentukan class badge untuk status SLA
                    switch ($laporan->status_sla) {
                        case 'lewat':
                            $statusSlaClass = 'badge-sla-lewat';
                            $statusSla = 'LEWAT';
                            break;
                        case 'kritis':
                            $statusSlaClass = 'badge-sla-kritis';
                            $statusSla = 'KRITIS';
                            break;
                        case 'warning':
                            $statusSlaClass = 'badge-sla-warning';
                            $statusSla = 'PERINGATAN';
                            break;
                        case 'aman':
                            $statusSlaClass = 'badge-sla-aman';
                            $statusSla = 'AMAN';
                            break;
                        case 'tidak_ada_sla':
                            $statusSlaClass = 'badge-sla-tidak-ada';
                            $statusSla = 'TIDAK ADA';
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
                
                // Format balasan
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
                <td class="text-center col-no">{{ $index + 1 }}</td>
                <td class="col-tiket">{{ $laporan->kode_tiket }}</td>
                <td class="col-kategori">{{ $laporan->kategoriLayanan->nama ?? '-' }}</td>
                <td class="col-layanan">{{ $laporan->layanan->nama ?? '-' }}</td>
                <td class="col-pd-layanan">{{ $laporan->layanan->perangkatDaerah->nama ?? '-' }}</td>
                <td class="col-jenis">{{ $jenisLayanan }}</td>
                <td class="col-judul">{{ $laporan->judul_laporan }}</td>
                <td class="col-deskripsi">{{ Str::limit($laporan->deskripsi ?? '-', 50) }}</td>
                <td class="col-pelapor">{{ $laporan->user->name ?? '-' }}</td>
                <td class="col-email">{{ $laporan->user->email ?? '-' }}</td>
                <td class="col-pd-pelapor">{{ $perangkatDaerahPelapor }}</td>
                <td class="text-center col-status">
                    <span class="badge badge-{{ $laporan->status }}">
                        {{ strtoupper($laporan->status) }}
                    </span>
                </td>
                <td class="col-tanggal">
                    {{ $laporan->tanggal_laporan->format('d/m/Y') }}<br>
                    <small>{{ $laporan->waktu_laporan ? \Carbon\Carbon::parse($laporan->waktu_laporan)->format('H:i') : '00:00' }}</small>
                </td>
                <td class="text-center col-sla-layanan">{{ $slaLayanan }}</td>
                <td class="text-center col-sisa-sla">{{ $sisaSla }}</td>
                <td class="text-center col-status-sla">
                    <span class="badge {{ $statusSlaClass }}">{{ $statusSla }}</span>
                </td>
                <td class="text-center col-durasi">{{ $durasiAktual }}</td>
                <td class="col-tgl-selesai">{{ $tanggalPenyelesaian }}</td>
                <td class="col-balasan">{{ Str::limit($balasan, 50) }}</td>
                <td class="col-teknisi">{{ $laporan->teknisi->name ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->timezone('Asia/Jakarta')->format('d/m/Y H:i:s') }} WIB</p>
        <p>Total Data: {{ $laporans->count() }} laporan</p>
        <p>Halaman 1 dari 1</p>
    </div>
</body>
</html>