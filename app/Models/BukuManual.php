<?php
// File: app/Models/BukuManual.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuManual extends Model
{
    use HasFactory;

    protected $table = 'buku_manual';

    protected $fillable = [
        'judul',
        'deskripsi',
        'file_path',
        'link',
        'sampul_path', // Tambahkan field sampul
        'tipe',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    // Accessor untuk URL sampul
    public function getSampulUrlAttribute()
    {
        if ($this->sampul_path) {
            return asset('storage/' . $this->sampul_path);
        }

        // Default cover berdasarkan tipe
        if ($this->tipe === 'file') {
            return asset('images/default-file-cover.jpg');
        } else {
            return asset('images/default-link-cover.jpg');
        }
    }

    // Accessor untuk URL file
    public function getFileUrlAttribute()
    {
        if ($this->file_path) {
            return asset('storage/' . $this->file_path);
        }
        return null;
    }
}
