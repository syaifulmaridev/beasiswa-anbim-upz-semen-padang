<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('pendaftarans', function (Blueprint $table) {

            if (!Schema::hasColumn('pendaftarans', 'status_survey')) {
                $table->string('status_survey')->nullable()->after('status_berkas');
            }

            if (!Schema::hasColumn('pendaftarans', 'status_penetapan')) {
                $table->string('status_penetapan')->nullable()->after('status_survey');
            }

            if (!Schema::hasColumn('pendaftarans', 'surat_pernyataan')) {
                $table->boolean('surat_pernyataan')->default(false);
            }

            if (!Schema::hasColumn('pendaftarans', 'tanggal_surat_pernyataan')) {
                $table->timestamp('tanggal_surat_pernyataan')->nullable();
            }

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('pendaftarans', function (Blueprint $table) {

            if (Schema::hasColumn('pendaftarans', 'status_survey')) {
                $table->dropColumn('status_survey');
            }

            if (Schema::hasColumn('pendaftarans', 'status_penetapan')) {
                $table->dropColumn('status_penetapan');
            }

            if (Schema::hasColumn('pendaftarans', 'surat_pernyataan')) {
                $table->dropColumn('surat_pernyataan');
            }

            if (Schema::hasColumn('pendaftarans', 'tanggal_surat_pernyataan')) {
                $table->dropColumn('tanggal_surat_pernyataan');
            }

        });
    }
};