<?php
// File: database/migrations/2025_10_21_xxxxxx_add_kode_tiket_to_laporan_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('laporan', function (Blueprint $table) {
            $table->string('kode_tiket')->unique()->nullable()->after('id');
        });
    }

    public function down()
    {
        Schema::table('laporan', function (Blueprint $table) {
            $table->dropColumn('kode_tiket');
        });
    }
};
