<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('nik')->nullable();
                $table->string('nip_no_thl')->nullable();
                $table->foreignId('perangkat_daerah_id')->nullable()->constrained('perangkat_daerah')->onDelete('set null');
                $table->string('email')->unique();
                $table->string('no_whatsapp')->nullable();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->string('role_requested')->default('user'); // Kolom baru untuk menyimpan role yang diminta saat registrasi
                $table->rememberToken();
                $table->timestamps();
            });
        } else {
            // Jika tabel sudah exists, tambahkan kolom yang belum ada
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'nik')) {
                    $table->string('nik')->nullable()->after('name');
                }
                if (!Schema::hasColumn('users', 'nip_no_thl')) {
                    $table->string('nip_no_thl')->nullable()->after('nik');
                }
                if (!Schema::hasColumn('users', 'perangkat_daerah_id')) {
                    $table->foreignId('perangkat_daerah_id')->nullable()->after('nip_no_thl')->constrained('perangkat_daerah')->onDelete('set null');
                }
                if (!Schema::hasColumn('users', 'no_whatsapp')) {
                    $table->string('no_whatsapp')->nullable()->after('email');
                }
                if (!Schema::hasColumn('users', 'role_requested')) {
                    $table->string('role_requested')->default('user')->after('password');
                }
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
