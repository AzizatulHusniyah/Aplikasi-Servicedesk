<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Untuk MySQL
        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE users MODIFY otp_expires_at DATETIME NULL');
        }

        // Untuk PostgreSQL
        if (DB::getDriverName() === 'pgsql') {
            DB::statement('ALTER TABLE users ALTER COLUMN otp_expires_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE USING otp_expires_at::timestamp(0) WITHOUT TIME ZONE');
        }
    }

    public function down()
    {
        // Rollback tidak diperlukan untuk perbaikan tipe data
    }
};
