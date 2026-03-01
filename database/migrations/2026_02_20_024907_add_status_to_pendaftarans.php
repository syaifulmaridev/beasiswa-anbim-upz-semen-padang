<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {

            $table->enum('status', [
                'pending',
                'verifikasi',
                'diterima',
                'ditolak'
            ])->default('pending')->change();

            // Log waktu tiap tahap
            $table->timestamp('verifikasi_at')->nullable();
            $table->timestamp('diterima_at')->nullable();
            $table->timestamp('ditolak_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->dropColumn([
                'verifikasi_at',
                'diterima_at',
                'ditolak_at'
            ]);
        });
    }
};