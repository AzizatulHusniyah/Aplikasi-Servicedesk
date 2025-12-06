<?php
// File: database/migrations/2025_10_20_070049_create_buku_manual_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('buku_manual', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('file_path')->nullable();
            $table->string('link')->nullable();
            $table->string('sampul_path')->nullable(); // Tambahkan field sampul
            $table->enum('tipe', ['file', 'link'])->default('file');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('buku_manual');
    }
};
