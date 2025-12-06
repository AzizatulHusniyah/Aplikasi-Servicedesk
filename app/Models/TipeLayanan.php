<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipeLayanan extends Model
{
    use HasFactory;

    protected $table = 'tipe_layanan';

    protected $fillable = [
        'nama',
        'keterangan',
        'status_aktivasi'
    ];

    public function layanan()
    {
        return $this->hasMany(Layanan::class);
    }
}
