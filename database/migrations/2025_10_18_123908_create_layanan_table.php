<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('layanan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('deskripsi')->nullable();

            // Foreign keys
            $table->foreignId('kategori_layanan_id')
                  ->constrained('kategori_layanan')
                  ->onDelete('cascade');

            $table->foreignId('tipe_layanan_id')
                  ->constrained('tipe_layanan')
                  ->onDelete('cascade');

            $table->foreignId('perangkat_daerah_id')
                  ->nullable()
                  ->constrained('perangkat_daerah')
                  ->onDelete('set null');

            $table->foreignId('teknisi_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');

            // Field lainnya
            $table->string('link_form')->nullable();
            $table->string('eselon', 10)->nullable();
            $table->integer('sla_hari')->default(1);
            
            // UBAH: Jenis layanan baru
            $table->boolean('administrasi_pemerintahan')->default(false);
            $table->boolean('publik')->default(false);
            
            $table->boolean('status_aktivasi')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('layanan');
    }
};