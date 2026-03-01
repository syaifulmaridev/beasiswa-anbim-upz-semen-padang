<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pembinaans', function (Blueprint $table) {
            $table->text('keterangan_hafalan')->nullable()->after('hafalan');
        });
    }

    public function down(): void
    {
        Schema::table('pembinaans', function (Blueprint $table) {
            $table->dropColumn('keterangan_hafalan');
        });
    }
};
