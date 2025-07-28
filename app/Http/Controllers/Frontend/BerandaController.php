<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IphMingguan;
use App\Models\IphBulanan;
use App\Models\SiteSetting;

class BerandaController extends Controller
{
    public function index(Request $request)
    {
        // Filter berdasarkan tahun & bulan jika ada
        $tahunFilter = $request->tahun;
        $bulanFilter = $request->bulan;

        // 📅 IPH Bulanan
        $bulanan = IphBulanan::query()
            ->when($tahunFilter, fn($q) => $q->where('tahun', $tahunFilter))
            ->when($bulanFilter, fn($q) => $q->where('bulan', $bulanFilter))
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan')
            ->get();

        // 🗓️ IPH Mingguan
        $mingguan = IphMingguan::query()
            ->when($tahunFilter, fn($q) => $q->where('tahun', $tahunFilter))
            ->when($bulanFilter, fn($q) => $q->where('bulan', $bulanFilter))
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan')
            ->orderBy('minggu_ke')
            ->get();

        // 📊 Label dan Data Grafik Mingguan (fluktuasi tertinggi)
        $labels = $mingguan->map(fn($m) => 'M' . $m->minggu_ke . ' ' . $m->bulan)->toArray();
        $data = $mingguan->map(fn($m) => $m->fluktuasi_tertinggi ?? 0)->toArray();

        // ⚙️ Setting tampilan publik
        $setting = SiteSetting::first() ?? new SiteSetting();

        return view('frontend.beranda', compact(
            'bulanan',
            'mingguan',
            'labels',
            'data',
            'setting'
        ));
    }
}
