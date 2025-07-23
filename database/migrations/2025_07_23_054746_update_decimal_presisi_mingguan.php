<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('iph_mingguan', function (Blueprint $table) {
            $table->decimal('perubahan_harga', 16, 10)->nullable()->change();
            $table->decimal('disparitas_harga', 16, 10)->nullable()->change();
            $table->decimal('nilai_fluktuasi', 16, 10)->nullable()->change();

            for ($i = 1; $i <= 5; $i++) {
                $table->decimal("nilai_andil_$i", 16, 10)->nullable()->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('iph_mingguan', function (Blueprint $table) {
            $table->float('perubahan_harga')->nullable()->change();
            $table->float('disparitas_harga')->nullable()->change();
            $table->float('nilai_fluktuasi')->nullable()->change();

            for ($i = 1; $i <= 5; $i++) {
                $table->float("nilai_andil_$i")->nullable()->change();
            }
        });
    }
};
