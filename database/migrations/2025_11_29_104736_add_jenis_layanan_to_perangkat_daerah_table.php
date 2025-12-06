<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('perangkat_daerah', function (Blueprint $table) {
            $table->boolean('administrasi_pemerintahan')->default(false);
            $table->boolean('publik')->default(false);
        });
    }

    public function down()
    {
        Schema::table('perangkat_daerah', function (Blueprint $table) {
            $table->dropColumn(['administrasi_pemerintahan', 'publik']);
        });
    }
};