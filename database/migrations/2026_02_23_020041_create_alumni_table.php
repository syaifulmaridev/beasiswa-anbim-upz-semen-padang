<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('alumni', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nik')->unique();
            $table->text('alamat');
            $table->enum('kegiatan_selanjutnya', [
                'Melanjutkan Pendidikan',
                'Bekerja',
                'Berwirausaha',
                'Belum Bekerja'
            ]);
            $table->string('tempat_kegiatan')->nullable();
            $table->year('tahun_kelulusan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumni');
    }
};