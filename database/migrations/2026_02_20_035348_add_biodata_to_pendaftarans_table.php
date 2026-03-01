<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {

            $table->string('tempat_lahir')->nullable()->after('user_id');
            $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
            $table->string('jenis_kelamin')->nullable()->after('tanggal_lahir');
            $table->string('nim_nisn')->nullable()->after('jenis_kelamin');
            $table->string('no_hp')->nullable()->after('nim_nisn');
            $table->text('alamat')->nullable()->after('no_hp');

        });
    }

    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {

            $table->dropColumn([
                'tempat_lahir',
                'tanggal_lahir',
                'jenis_kelamin',
                'nim_nisn',
                'no_hp',
                'alamat'
            ]);

        });
    }
};