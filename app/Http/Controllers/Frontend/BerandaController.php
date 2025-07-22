<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IphMingguan;
use App\Models\SiteSetting;

class BerandaController extends Controller
{
    public function index()
    {
        $mingguan = IphMingguan::orderBy('created_at', 'desc')->take(12)->get()->reverse();

        // Buat label format: "M3 Juli"
        $labels = $mingguan->map(function ($m) {
            return 'M' . $m->minggu_ke . ' ' . $m->bulan;
        })->toArray();

        // Ambil data fluktuasi tertinggi
        $data = $mingguan->map(function ($m) {
            return $m->fluktuasi_tertinggi ?? 0;
        })->toArray();

        // Ambil setting tampilan publik
        $setting = SiteSetting::first() ?? new SiteSetting();

        return view('frontend.beranda', compact('labels', 'data', 'setting'));
    }
}
