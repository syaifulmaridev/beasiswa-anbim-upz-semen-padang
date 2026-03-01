<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            if (!Schema::hasColumn('users', 'nik')) {
                $table->string('nik')->nullable();
            }

            if (!Schema::hasColumn('users', 'alamat')) {
                $table->text('alamat')->nullable();
            }

            if (!Schema::hasColumn('users', 'status_sekarang')) {
                $table->enum('status_sekarang', [
                    'Bekerja',
                    'Melanjutkan Pendidikan',
                    'Berwirausaha',
                    'Belum Bekerja'
                ])->nullable();
            }

            if (!Schema::hasColumn('users', 'keterangan')) {
                $table->string('keterangan')->nullable();
            }

            if (!Schema::hasColumn('users', 'tahun_kelulusan')) {
                $table->year('tahun_kelulusan')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            if (Schema::hasColumn('users', 'nik')) {
                $table->dropColumn('nik');
            }

            if (Schema::hasColumn('users', 'alamat')) {
                $table->dropColumn('alamat');
            }

            if (Schema::hasColumn('users', 'status_sekarang')) {
                $table->dropColumn('status_sekarang');
            }

            if (Schema::hasColumn('users', 'keterangan')) {
                $table->dropColumn('keterangan');
            }

            if (Schema::hasColumn('users', 'tahun_kelulusan')) {
                $table->dropColumn('tahun_kelulusan');
            }
        });
    }
};
