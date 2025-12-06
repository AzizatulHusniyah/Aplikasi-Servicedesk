<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerangkatDaerah extends Model
{
    use HasFactory;

    protected $table = 'perangkat_daerah';

    protected $fillable = [
        'nama',
        'email',
        'kode',
        'link_esukma',
        'status_aktivasi',
        'administrasi_pemerintahan',
        'publik'
    ];

    protected $casts = [
        'status_aktivasi' => 'boolean',
        'administrasi_pemerintahan' => 'boolean',
        'publik' => 'boolean'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function layanan()
    {
        return $this->hasMany(Layanan::class);
    }

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

    // TAMBAH: Method untuk mendapatkan badge jenis layanan
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
