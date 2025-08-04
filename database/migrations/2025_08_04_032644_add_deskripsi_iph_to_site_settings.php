<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambahkan kolom deskripsi_iph ke tabel site_settings
     */
    public function up(): void
    {
        // Pastikan kolom belum ada agar tidak error saat deploy
        if (!Schema::hasColumn('site_settings', 'deskripsi_iph')) {
            Schema::table('site_settings', function (Blueprint $table) {
                // Tambahkan kolom text yang nullable, setelah subjudul
                $table->text('deskripsi_iph')->nullable();

            });
        }
    }

    /**
     * Hapus kolom deskripsi_iph saat rollback
     */
    public function down(): void
    {
        // Pastikan kolom ada sebelum dihapus
        if (Schema::hasColumn('site_settings', 'deskripsi_iph')) {
            Schema::table('site_settings', function (Blueprint $table) {
                $table->dropColumn('deskripsi_iph');
            });
        }
    }
};
