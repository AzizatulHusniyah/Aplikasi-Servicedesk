<?php
// File: database/migrations/2025_10_21_160620_add_waktu_laporan_to_laporan_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('laporan', function (Blueprint $table) {
            $table->time('waktu_laporan')->default(now()->format('H:i:s'))->after('tanggal_laporan');
        });
    }

    public function down()
    {
        Schema::table('laporan', function (Blueprint $table) {
            $table->dropColumn('waktu_laporan');
        });
    }
};