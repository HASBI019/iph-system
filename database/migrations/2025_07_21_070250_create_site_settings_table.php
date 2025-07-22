<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('judul')->nullable();           // "BADAN PUSAT STATISTIK"
            $table->string('subjudul')->nullable();        // "KABUPATEN TASIKMALAYA"
            $table->string('logo')->nullable();            // logo utama
            $table->string('logo_berakhlak')->nullable();  // logo berakhlak
            $table->text('alamat')->nullable();            // alamat lengkap
            $table->string('telepon')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('site_settings');
    }
}
