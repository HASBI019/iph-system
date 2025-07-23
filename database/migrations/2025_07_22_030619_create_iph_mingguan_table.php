<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('iph_mingguan', function (Blueprint $table) {
            $table->id();
            $table->year('tahun');
            $table->string('bulan');
            $table->integer('minggu_ke')->nullable();
            $table->decimal('perubahan_harga', 16, 10)->nullable();
            $table->string('status_harga')->nullable();
            $table->string('fluktuasi_tertinggi')->nullable();

            for ($i = 1; $i <= 5; $i++) {
                $table->string("nama_komoditas_$i")->nullable();
                $table->decimal("nilai_andil_$i", 16, 10)->nullable();
            }

            $table->decimal('disparitas_harga', 16, 10)->nullable();
            $table->decimal('nilai_fluktuasi', 16, 10)->nullable();
            $table->timestamps();
        });
    }
};
