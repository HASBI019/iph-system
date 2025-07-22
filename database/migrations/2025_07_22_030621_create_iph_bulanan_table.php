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
    Schema::create('iph_bulanan', function (Blueprint $table) {
        $table->id();
        $table->year('tahun');
        $table->string('bulan');
        $table->float('perubahan_harga')->nullable();
        $table->string('status_harga')->nullable();
        $table->float('fluktuasi_tertinggi')->nullable();

        for ($i = 1; $i <= 5; $i++) {
            $table->string("nama_komoditas_$i")->nullable();
            $table->float("nilai_andil_$i")->nullable();
        }

        $table->float('disparitas_harga')->nullable();
        $table->float('nilai_fluktuasi')->nullable();
        $table->timestamp('created_at')->nullable();
    });
}

};
