<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('perangkat_daerah', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email');
            $table->string('kode');
            $table->string('link_esukma');
            $table->boolean('status_aktivasi')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('perangkat_daerah');
    }
};
