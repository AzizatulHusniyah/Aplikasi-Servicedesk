<?php
// File: app/Models/Laporan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporan';

    protected $fillable = [
        'kode_tiket',
        'judul_laporan',
        'deskripsi',
        'balasan',
        'kategori_layanan_id',
        'layanan_id',
        'user_id',
        'teknisi_id',
        'status',
        'tanggal_laporan',
        'waktu_laporan',
        'catatan',
        'lampiran_path',
        'lampiran_balasan_path',
        'dibalas_pada'
    ];

    protected $casts = [
        'tanggal_laporan' => 'date',
        'waktu_laporan' => 'datetime:H:i:s',
        'dibalas_pada' => 'datetime',
    ];

    protected $appends = [
        'sisa_sla', 
        'status_sla', 
        'warna_sla', 
        'icon_sla', 
        'tanggal_target_selesai',
        'tanggal_waktu_laporan',
        'waktu_laporan_formatted'
    ];

    public static function generateKodeTiket()
    {
        $prefix = 'TKT';
        $date = now()->format('ymd'); // Sudah menggunakan waktu WIB

        do {
            $random = strtoupper(substr(uniqid(), -4));
            $kode_tiket = "{$prefix}-{$date}-{$random}";
        } while (self::where('kode_tiket', $kode_tiket)->exists());

        return $kode_tiket;
    }

    // Boot method untuk auto-generate kode tiket dan waktu
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->kode_tiket)) {
                $model->kode_tiket = self::generateKodeTiket();
            }
            // Set waktu laporan otomatis ke waktu WIB sekarang jika tidak diisi
            if (empty($model->waktu_laporan)) {
                $model->waktu_laporan = now()->format('H:i:s'); // Waktu WIB
            }
            // Set tanggal laporan otomatis ke hari ini WIB jika tidak diisi
            if (empty($model->tanggal_laporan)) {
                $model->tanggal_laporan = now()->toDateString(); // Tanggal WIB
            }
            // Set status default ke 'draft' jika tidak diisi
            if (empty($model->status)) {
                $model->status = 'draft';
            }
        });
    }

    // ============================================
    // METHOD BARU: Hitung tanggal target selesai
    // ============================================
    public function getTanggalTargetSelesaiAttribute()
    {
        if (!$this->layanan || !$this->layanan->sla_hari) {
            return null;
        }
        
        // Gunakan tanggal_laporan sebagai titik awal SLA
        $tanggalMulai = Carbon::parse($this->tanggal_laporan);
        return $tanggalMulai->addDays($this->layanan->sla_hari);
    }

    public function getSisaSlaAttribute()
    {
        // Jika status sudah selesai, langsung return 0
        if ($this->status === 'selesai') {
            return 0;
        }

        // Jika tidak ada layanan atau SLA
        if (!$this->layanan || !$this->layanan->sla_hari) {
            return 999; // Nilai besar jika tidak ada SLA
        }

        try {
            // Ambil tanggal target selesai
            $tanggalTarget = $this->getTanggalTargetSelesaiAttribute();
            if (!$tanggalTarget) {
                return 999;
            }

            // Konversi ke Carbon dan ambil hanya tanggalnya
            $tanggalTarget = Carbon::parse($tanggalTarget)->startOfDay();
            $sekarang = now()->startOfDay();

            // DEBUG: Log untuk memeriksa perhitungan
            \Log::info("SLA Debug - Report ID: {$this->id}");
            \Log::info("Tanggal Target: {$tanggalTarget->format('Y-m-d')}");
            \Log::info("Sekarang: {$sekarang->format('Y-m-d')}");
            
            // Hitung selisih hari (target - sekarang)
            // Jika target > sekarang: hasil positif (masih ada waktu)
            // Jika target < sekarang: hasil negatif (sudah lewat)
            // Jika target == sekarang: hasil 0 (deadline hari ini)
            $selisihHari = $sekarang->diffInDays($tanggalTarget, false);
            
            \Log::info("Selisih Hari: {$selisihHari}");

            return $selisihHari;

        } catch (\Exception $e) {
            \Log::error('Error calculating SLA for report ' . $this->id . ': ' . $e->getMessage());
            return 999;
        }
    }

    // ============================================
    // METHOD BARU: Format sisa waktu untuk tampilan
    // ============================================
    public function getSisaWaktuFormattedAttribute()
    {
        $sisaSla = $this->sisa_sla;
        
        if ($this->status === 'selesai') {
            return [
                'text' => 'Selesai',
                'color' => 'success',
                'icon' => 'fas fa-check-circle'
            ];
        }
        
        if ($sisaSla === 999) {
            return [
                'text' => 'Tidak ada SLA',
                'color' => 'secondary',
                'icon' => 'fas fa-question-circle'
            ];
        }
        
        if ($sisaSla < 0) {
            return [
                'text' => 'Terlambat ' . abs($sisaSla) . ' hari',
                'color' => 'danger',
                'icon' => 'fas fa-exclamation-triangle'
            ];
        }
        
        if ($sisaSla == 0) {
            return [
                'text' => 'Hari ini deadline',
                'color' => 'warning',
                'icon' => 'fas fa-exclamation-circle'
            ];
        }
        
        if ($sisaSla <= 1) {
            return [
                'text' => $sisaSla . ' hari tersisa (Kritis)',
                'color' => 'warning',
                'icon' => 'fas fa-exclamation-circle'
            ];
        }
        
        if ($sisaSla <= 3) {
            return [
                'text' => $sisaSla . ' hari tersisa (Peringatan)',
                'color' => 'info',
                'icon' => 'fas fa-clock'
            ];
        }
        
        return [
            'text' => $sisaSla . ' hari tersisa',
            'color' => 'success',
            'icon' => 'fas fa-check-circle'
        ];
    }

    // ============================================
    // METHOD BARU: Cek status SLA berdasarkan sisa waktu
    // ============================================
    public function getStatusSlaAttribute()
    {
        $sisaSla = $this->sisa_sla;

        // Jika status sudah selesai
        if ($this->status === 'selesai') {
            return 'selesai';
        }

        // Jika tidak ada SLA
        if ($sisaSla === 999) {
            return 'tidak_ada_sla';
        }

        // Jika sudah terlambat
        if ($sisaSla < 0) {
            return 'lewat';
        }

        // Jika sisa 0 hari (hari ini deadline)
        if ($sisaSla == 0) {
            return 'deadline_hari_ini';
        }

        // Jika sisa 1 hari atau kurang (kritis)
        if ($sisaSla <= 1) {
            return 'kritis';
        }

        // Jika sisa 2-3 hari (warning)
        if ($sisaSla <= 3) {
            return 'warning';
        }

        // Jika masih aman (> 3 hari)
        return 'aman';
    }

    // ============================================
    // METHOD BARU: Warna berdasarkan status SLA
    // ============================================
    public function getWarnaSlaAttribute()
    {
        switch ($this->status_sla) {
            case 'selesai':
                return 'success';
            case 'lewat':
                return 'danger';
            case 'deadline_hari_ini':
            case 'kritis':
                return 'warning';
            case 'warning':
                return 'info';
            case 'tidak_ada_sla':
                return 'secondary';
            default:
                return 'success';
        }
    }

    // ============================================
    // METHOD BARU: Icon berdasarkan status SLA
    // ============================================
    public function getIconSlaAttribute()
    {
        switch ($this->status_sla) {
            case 'selesai':
                return 'fas fa-check-circle';
            case 'lewat':
                return 'fas fa-exclamation-triangle';
            case 'deadline_hari_ini':
            case 'kritis':
                return 'fas fa-exclamation-circle';
            case 'warning':
                return 'fas fa-clock';
            case 'tidak_ada_sla':
                return 'fas fa-question-circle';
            default:
                return 'fas fa-check-circle';
        }
    }

    // ============================================
    // METHOD BARU: Cek apakah laporan dalam status warning
    // ============================================
    public function isSlaWarning()
    {
        return in_array($this->status_sla, ['lewat', 'deadline_hari_ini', 'kritis', 'warning']);
    }

    // ============================================
    // METHOD BARU: Cek apakah laporan sudah terlambat
    // ============================================
    public function isSlaTerlambat()
    {
        return $this->status_sla === 'lewat';
    }

    // ============================================
    // METHOD BARU: Cek apakah laporan kritis (<= 1 hari)
    // ============================================
    public function isSlaKritis()
    {
        return $this->status_sla === 'kritis' || $this->status_sla === 'deadline_hari_ini';
    }

    // ============================================
    // Accessor untuk format tanggal dan waktu lengkap
    // ============================================
    public function getTanggalWaktuLaporanAttribute()
    {
        $tanggal = $this->tanggal_laporan->format('d/m/Y');
        $waktu = $this->waktu_laporan ? Carbon::parse($this->waktu_laporan)->format('H:i') : '00:00';
        return "$tanggal $waktu WIB";
    }

    public function getWaktuLaporanFormattedAttribute()
    {
        return $this->waktu_laporan ? Carbon::parse($this->waktu_laporan)->format('H:i') . ' WIB' : '-';
    }

    // ============================================
    // Relasi
    // ============================================
    public function kategoriLayanan()
    {
        return $this->belongsTo(KategoriLayanan::class, 'kategori_layanan_id');
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'layanan_id');
    }

    public function perangkatDaerah()
    {
        return $this->belongsTo(PerangkatDaerah::class, 'perangkat_daerah_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function teknisi()
    {
        return $this->belongsTo(User::class, 'teknisi_id');
    }
}