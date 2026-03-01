<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembinaans', function (Blueprint $table) {
            $table->id();

            // Anak bimbing
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Pembina (karyawan)
            $table->foreignId('pembina_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Tanggal setor hafalan
            $table->date('tanggal_setor');

            // Contoh: Juz 1 (1-20)
            $table->string('hafalan');

            // Kehadiran
            $table->boolean('hadir')->default(false);

            // Catatan pembimbing
            $table->text('catatan')->nullable();

            // Status jadwal
            $table->enum('status', ['terjadwal','selesai'])
                  ->default('terjadwal');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembinaans');
    }
};
