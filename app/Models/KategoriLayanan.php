<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriLayanan extends Model
{
    use HasFactory;

    protected $table = 'kategori_layanan';

    protected $fillable = [
        'nama',
        'keterangan', // Ubah dari deskripsi menjadi keterangan
        'status_aktivasi'
    ];

    protected $casts = [
        'status_aktivasi' => 'boolean'
    ];

    public function layanan()
    {
        return $this->hasMany(Layanan::class);
    }

    // Scope untuk yang aktif
    public function scopeAktif($query)
    {
        return $query->where('status_aktivasi', true);
    }
}