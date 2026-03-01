<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pembinaans', function (Blueprint $table) {
            $table->string('hadir_status')->nullable()->after('hafalan');
            $table->string('status_pencairan')->nullable()->after('catatan');
        });
    }

    public function down(): void
    {
        Schema::table('pembinaans', function (Blueprint $table) {
            $table->dropColumn(['hadir_status','status_pencairan']);
        });
    }
};
