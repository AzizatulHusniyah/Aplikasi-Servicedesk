<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;

    protected $table = 'layanan';

    protected $fillable = [
        'nama',
        'deskripsi',
        'kategori_layanan_id',
        'tipe_layanan_id',
        'perangkat_daerah_id',
        'teknisi_id',
        'link_form',
        'eselon',
        'sla_hari',
        'administrasi_pemerintahan',
        'publik',
        'status_aktivasi'
    ];

    protected $casts = [
        // PERBAIKAN: Sesuaikan dengan nama field di migration
        'administrasi_pemerintahan' => 'boolean',
        'publik' => 'boolean',
        'status_aktivasi' => 'boolean'
    ];

    public function kategoriLayanan()
    {
        return $this->belongsTo(KategoriLayanan::class);
    }

    public function tipeLayanan()
    {
        return $this->belongsTo(TipeLayanan::class);
    }

    public function perangkatDaerah()
    {
        return $this->belongsTo(PerangkatDaerah::class);
    }

    public function teknisi()
    {
        return $this->belongsTo(User::class, 'teknisi_id');
    }

    public function laporans()
    {
        return $this->hasMany(Laporan::class);
    }

    // PERBAIKAN: Method untuk mendapatkan label jenis layanan
    public function getJenisLayananLabel()
    {
        if ($this->administrasi_pemerintahan && $this->publik) {
            return 'Administrasi Pemerintahan & Publik';
        } elseif ($this->administrasi_pemerintahan) {
            return 'Administrasi Pemerintahan';
        } elseif ($this->publik) {
            return 'Publik';
        } else {
            return 'Belum Dipilih';
        }
    }

    // PERBAIKAN: Method untuk mendapatkan badge jenis layanan
    public function getJenisLayananBadge()
    {
        if ($this->administrasi_pemerintahan && $this->publik) {
            return 'badge bg-purple';
        } elseif ($this->administrasi_pemerintahan) {
            return 'badge bg-primary';
        } elseif ($this->publik) {
            return 'badge bg-success';
        } else {
            return 'badge bg-secondary';
        }
    }
}