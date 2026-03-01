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
        Schema::table('pendaftarans', function (Blueprint $table) {

            $table->string('status_berkas')
                  ->default('pending')
                  ->after('status');

            $table->string('status_survey')
                  ->nullable()
                  ->after('status_berkas');

            $table->string('status_pencairan')
                  ->nullable()
                  ->after('status_survey');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {

            $table->dropColumn([
                'status_berkas',
                'status_survey',
                'status_pencairan'
            ]);

        });
    }
};