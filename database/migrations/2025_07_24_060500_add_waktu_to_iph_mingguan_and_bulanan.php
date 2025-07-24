<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambahkan kolom 'waktu' ke tabel IPH Mingguan dan Bulanan.
     */
    public function up(): void
    {
        Schema::table('iph_mingguan', function (Blueprint $table) {
            $table->datetime('waktu')->nullable()->after('nilai_fluktuasi');
        });

        Schema::table('iph_bulanan', function (Blueprint $table) {
            $table->datetime('waktu')->nullable()->after('nilai_fluktuasi');
        });
    }

    /**
     * Hapus kolom 'waktu' jika rollback.
     */
    public function down(): void
    {
        Schema::table('iph_mingguan', function (Blueprint $table) {
            $table->dropColumn('waktu');
        });

        Schema::table('iph_bulanan', function (Blueprint $table) {
            $table->dropColumn('waktu');
        });
    }
};
