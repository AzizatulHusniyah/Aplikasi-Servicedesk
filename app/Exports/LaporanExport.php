<?php

namespace App\Exports;

use App\Models\Laporan;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class LaporanExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    public function collection()
    {
        // Hanya administrator yang bisa export
        if (!Auth::user()->hasRole('administrator')) {
            return collect([]); // Return collection kosong jika bukan admin
        }

        // Query dengan relasi lengkap untuk export
        return Laporan::with([
                'kategoriLayanan', 
                'layanan', 
                'layanan.perangkatDaerah',
                'user', 
                'teknisi'
            ])
            ->latest()
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Kode Tiket',
            'Kategori Layanan',
            'Layanan',
            'Perangkat Daerah Pemberi Layanan',
            'Jenis Layanan',
            'Judul Laporan',
            'Deskripsi Laporan',
            'Nama Pelapor',
            'Email Pelapor',
            'Perangkat Daerah Pelapor',
            'Status',
            'Tanggal Laporan',
            'SLA Layanan (Hari)', // DIUBAH: Menjadi informasi SLA
            'Sisa Waktu SLA', // DITAMBAH: Informasi sisa waktu SLA
            'Status SLA', // DITAMBAH: Status SLA
            'Durasi Penyelesaian Aktual', // DITAMBAH: Durasi aktual
            'Tanggal Penyelesaian',
            'Balasan/Keterangan',
            'Teknisi Penanggung Jawab'
        ];
    }

    public function map($laporan): array
    {
        static $counter = 0;
        $counter++;

        // Dapatkan informasi SLA dari layanan
        $slaLayanan = '-';
        $sisaWaktuSla = '-';
        $statusSla = '-';
        
        if ($laporan->layanan && $laporan->layanan->sla_hari) {
            $slaLayanan = $laporan->layanan->sla_hari . ' hari';
            $sisaWaktuSla = $laporan->sisa_sla . ' hari';
            $statusSla = $this->getStatusSlaLabel($laporan->status_sla);
        }

        // Hitung durasi penyelesaian aktual
        $durasiPenyelesaianAktual = '-';
        $tanggalPenyelesaian = '-';
        
        if ($laporan->dibalas_pada && $laporan->created_at) {
            $durasiHari = $laporan->created_at->diffInDays($laporan->dibalas_pada);
            $durasiPenyelesaianAktual = $durasiHari . ' hari';
            $tanggalPenyelesaian = $laporan->dibalas_pada->timezone('Asia/Jakarta')->format('d/m/Y H:i');
        }

        // Format balasan - hapus tag HTML jika ada
        $balasan = $laporan->balasan ?? 'Belum ada balasan';
        $balasan = strip_tags($balasan);
        $balasan = str_replace(['=== Balasan Sebelumnya', '=== Balasan Baru'], '', $balasan);

        // Dapatkan jenis layanan
        $jenisLayanan = '-';
        if ($laporan->layanan) {
            if ($laporan->layanan->administrasi_pemerintahan && $laporan->layanan->publik) {
                $jenisLayanan = 'Administrasi Pemerintahan & Publik';
            } elseif ($laporan->layanan->administrasi_pemerintahan) {
                $jenisLayanan = 'Administrasi Pemerintahan';
            } elseif ($laporan->layanan->publik) {
                $jenisLayanan = 'Publik';
            }
        }

        // Dapatkan perangkat daerah pelapor dari profile user
        $perangkatDaerahPelapor = 'Tidak tersedia';
        if ($laporan->user && $laporan->user->perangkatDaerah) {
            $perangkatDaerahPelapor = $laporan->user->perangkatDaerah->nama;
        } elseif ($laporan->user && $laporan->user->perangkat_daerah) {
            $perangkatDaerahPelapor = $laporan->user->perangkat_daerah;
        }

        return [
            $counter,
            $laporan->kode_tiket,
            $laporan->kategoriLayanan->nama ?? '-',
            $laporan->layanan->nama ?? '-',
            $laporan->layanan->perangkatDaerah->nama ?? '-',
            $jenisLayanan,
            $laporan->judul_laporan,
            $laporan->deskripsi ?? '-',
            $laporan->user->name ?? '-',
            $laporan->user->email ?? '-',
            $perangkatDaerahPelapor,
            ucfirst($laporan->status),
            $laporan->tanggal_laporan->format('d/m/Y') . ' ' . 
            ($laporan->waktu_laporan ? Carbon::parse($laporan->waktu_laporan)->format('H:i') : '00:00') . ' WIB',
            $slaLayanan, // SLA dari layanan
            $sisaWaktuSla, // Sisa waktu SLA
            $statusSla, // Status SLA
            $durasiPenyelesaianAktual, // Durasi penyelesaian aktual
            $tanggalPenyelesaian,
            $balasan,
            $laporan->teknisi->name ?? '-'
        ];
    }

    /**
     * Method untuk mendapatkan label status SLA
     */
    private function getStatusSlaLabel($statusSla)
    {
        switch ($statusSla) {
            case 'lewat':
                return 'LEWAT SLA';
            case 'kritis':
                return 'KRITIS (≤1 hari)';
            case 'warning':
                return 'PERINGATAN (≤3 hari)';
            case 'aman':
                return 'AMAN';
            case 'tidak_ada_sla':
                return 'TIDAK ADA SLA';
            default:
                return '-';
        }
    }

    public function styles(Worksheet $sheet)
    {
        // Style untuk header
        $sheet->getStyle('A1:T1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '1E3C72']
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ]
        ]);

        // Style untuk border
        $lastRow = $this->collection()->count() + 1;
        $sheet->getStyle("A1:T{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        // Wrap text untuk kolom deskripsi dan balasan
        $sheet->getStyle('H2:H' . $lastRow)->getAlignment()->setWrapText(true);
        $sheet->getStyle('S2:S' . $lastRow)->getAlignment()->setWrapText(true);

        // Auto filter
        $sheet->setAutoFilter("A1:T{$lastRow}");

        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}