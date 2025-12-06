<?php
// File: database/migrations/2025_10_18_124057_create_laporan_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('laporan', function (Blueprint $table) {
            $table->id();
            $table->string('judul_laporan');
            $table->text('deskripsi')->nullable();

            $table->foreignId('kategori_layanan_id')
                  ->constrained('kategori_layanan')
                  ->onDelete('cascade');

            $table->foreignId('layanan_id')
                  ->constrained('layanan')
                  ->onDelete('cascade');

            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->string('status')->default('draft');
            $table->date('tanggal_laporan');
            $table->text('catatan')->nullable();
            $table->string('lampiran_path')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('laporan');
    }
};
