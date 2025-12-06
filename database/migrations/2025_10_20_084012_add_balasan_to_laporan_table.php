<?php
// File: database/migrations/2025_10_20_xxxxxx_add_balasan_to_laporan_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('laporan', function (Blueprint $table) {
            $table->text('balasan')->nullable()->after('deskripsi');
            $table->foreignId('teknisi_id')->nullable()->after('user_id')->constrained('users')->onDelete('set null');
            $table->string('lampiran_balasan_path')->nullable()->after('lampiran_path'); // TAMBAHKAN INI
            $table->timestamp('dibalas_pada')->nullable()->after('updated_at');
        });
    }

    public function down()
    {
        Schema::table('laporan', function (Blueprint $table) {
            $table->dropColumn(['balasan', 'teknisi_id', 'lampiran_balasan_path', 'dibalas_pada']);
        });
    }
};
