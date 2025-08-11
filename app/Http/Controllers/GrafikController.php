<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IphBulanan;
use App\Models\IphMingguan;

class GrafikController extends Controller
{
    public function index(Request $request)
    {
        // Input dari form
        $tahun = $request->input('tahun', 2025);
        $jenis = $request->input('jenis', 'perubahan'); // default: perubahan

        // Daftar bulan berurutan
        $urutanBulan = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        // Ambil daftar tahun yang tersedia
        $tahunTersedia = IphBulanan::select('tahun')->distinct()->pluck('tahun')->sortDesc();

        // Ambil dan urutkan data bulanan
        $bulanan = IphBulanan::where('tahun', $tahun)->get()->sortBy(function ($item) use ($urutanBulan) {
            return array_search($item->bulan, $urutanBulan);
        });

        $labelsBulanan = $bulanan->map(function ($b) {
            return $b->bulan . ' ' . $b->tahun;
        })->toArray();

        $dataBulanan = $bulanan->map(function ($b) use ($jenis) {
            return $jenis === 'nilai'
                ? ($b->nilai_fluktuasi ?? 0)
                : ($b->perubahan_harga ?? 0);
        })->toArray();

        // Ambil dan urutkan data mingguan
        $mingguan = IphMingguan::where('tahun', $tahun)->get()->sortBy(function ($item) use ($urutanBulan) {
            return array_search($item->bulan, $urutanBulan) * 10 + $item->minggu_ke;
        });

        $labelsMingguan = $mingguan->map(function ($m) {
            return 'M' . $m->minggu_ke . ' ' . $m->bulan;
        })->toArray();

        $dataMingguan = $mingguan->map(function ($m) use ($jenis) {
            return $jenis === 'nilai'
                ? ($m->nilai_fluktuasi ?? 0)
                : ($m->perubahan_harga ?? 0);
        })->toArray();

        // Kirim ke view
        return view('frontend.grafik', compact(
            'tahun', 'jenis', 'tahunTersedia',
            'labelsBulanan', 'dataBulanan',
            'labelsMingguan', 'dataMingguan'
        ));
    }
}
