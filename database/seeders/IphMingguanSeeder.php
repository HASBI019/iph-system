<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IphMingguan;

class IphMingguanSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 12; $i++) {
            IphMingguan::create([
                'tahun' => 2025,
                'bulan' => bulanKeNama(rand(1, 12)),
                'minggu_ke' => $i,
                'perubahan_harga' => rand(-5, 10),
                'status_harga' => 'Stabil',
                'fluktuasi_tertinggi' => rand(2, 9),
                'nama_komoditas_1' => 'Beras',
                'nilai_andil_1' => rand(1, 3),
                'nama_komoditas_2' => 'Cabai Rawit',
                'nilai_andil_2' => rand(1, 3),
                'nama_komoditas_3' => 'Minyak Goreng',
                'nilai_andil_3' => rand(1, 3),
                'nama_komoditas_4' => 'Telur Ayam',
                'nilai_andil_4' => rand(1, 3),
                'nama_komoditas_5' => 'Gula Pasir',
                'nilai_andil_5' => rand(1, 3),
                'disparitas_harga' => rand(0, 5),
                'nilai_fluktuasi' => rand(2, 8),
                'created_at' => now()->subWeeks(12 - $i),
            ]);
        }
    }
}

function bulanKeNama($ke)
{
    $bulanList = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                  'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    return $bulanList[$ke - 1];
}
