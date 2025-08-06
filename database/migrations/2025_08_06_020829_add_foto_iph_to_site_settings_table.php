<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFotoIphToSiteSettingsTable extends Migration
{
    /**
     * Tambahkan kolom foto_iph ke tabel site_settings
     */
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('foto_iph')->nullable()->after('deskripsi_iph');
        });
    }

    /**
     * Hapus kolom foto_iph jika rollback
     */
    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn('foto_iph');
        });
    }
}
