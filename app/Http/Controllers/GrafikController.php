<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IphBulanan;
use App\Models\IphMingguan;

class GrafikController extends Controller
{
    public function index()
    {
        $bulanan = IphBulanan::orderBy('tahun')->orderBy('bulan')->get();
        $mingguan = IphMingguan::orderBy('tahun')->orderBy('bulan')->orderBy('minggu_ke')->get();

        $labelsBulanan = $bulanan->map(fn($b) => $b->bulan . ' ' . $b->tahun)->toArray();
        $dataBulanan = $bulanan->map(fn($b) => $b->nilai_fluktuasi ?? 0)->toArray();

        $labelsMingguan = $mingguan->map(fn($m) => 'M' . $m->minggu_ke . ' ' . $m->bulan)->toArray();
        $dataMingguan = $mingguan->map(fn($m) => $m->nilai_fluktuasi ?? 0)->toArray();

        return view('frontend.grafik', compact('labelsBulanan', 'dataBulanan', 'labelsMingguan', 'dataMingguan'));
    }
}
