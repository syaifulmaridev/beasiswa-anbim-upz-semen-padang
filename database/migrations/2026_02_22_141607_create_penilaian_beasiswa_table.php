<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penilaian_beasiswa', function (Blueprint $table) {
            $table->id();

            // Relasi ke pendaftaran
            $table->foreignId('pendaftaran_id')
                  ->constrained('pendaftarans')
                  ->onDelete('cascade');

            /*
            |-------------------------------------------------
            | INDEKS RUMAH (1–5)
            |-------------------------------------------------
            */
            $table->integer('skor_rumah');
            $table->integer('skor_kepemilikan');
            $table->integer('skor_dinding');
            $table->integer('skor_lantai');
            $table->integer('skor_atap');
            $table->integer('skor_dapur');
            $table->integer('skor_kursi');

            /*
            |-------------------------------------------------
            | KEAGAMAAN (1–4)
            |-------------------------------------------------
            */
            $table->integer('skor_baca_quran');
            $table->integer('skor_hafalan');
            $table->integer('skor_shalat');
            $table->integer('skor_ibadah');

            /*
            |-------------------------------------------------
            | HASIL AKHIR
            |-------------------------------------------------
            */
            $table->integer('total_skor');      // Maks 52
            $table->integer('nilai_akhir');     // Skala 0–100
            $table->string('status_kelayakan'); // Sangat Layak / Dipertimbangkan / Tidak Cocok

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_beasiswa');
    }
};