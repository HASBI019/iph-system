<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteSetting;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        SiteSetting::updateOrCreate(['id' => 1], [
            'judul' => 'BADAN PUSAT STATISTIK',
            'subjudul' => 'KABUPATEN TASIKMALAYA',
            'logo' => 'images/logo-bps.png',
            'logo_berakhlak' => 'images/logo-berakhlak.png',
            'alamat' => 'Jalan Raya Timur km 4 Cintaraja Singaparna Tasikmalaya 46417',
            'telepon' => '(0265) 549281',
            'email' => 'bps3206@bps.go.id',
        ]);
    }
}
