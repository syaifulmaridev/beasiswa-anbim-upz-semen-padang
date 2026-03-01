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
    Schema::table('alumni', function (Blueprint $table) {
        $table->string('jurusan');
        $table->string('instansi_asal');
        $table->string('email');
        $table->string('hp');
        $table->string('foto_ijazah')->nullable();
    });
}

public function down(): void
{
    Schema::table('alumni', function (Blueprint $table) {
        $table->dropColumn([
            'jurusan',
            'instansi_asal',
            'email',
            'hp',
            'foto_ijazah'
        ]);
    });
}
};