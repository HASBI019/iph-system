<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IphMingguan;
use App\Models\IphBulanan;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        // Ambil tahun dari query string, default ke 2025
        $tahun = $request->input('tahun', 2025);

        // =====================
        // 🔹 Data Mingguan
        // =====================
        $mingguan = IphMingguan::where('tahun', $tahun)
            ->orderBy('minggu_ke')
            ->get();

        $mingguLabels = $mingguan->pluck('minggu_ke')->map(function ($m) {
            return "Minggu $m";
        });

        $mingguData = $mingguan->pluck('fluktuasi_tertinggi');

        // =====================
        // 🔹 Data Bulanan
        // =====================
        $bulanan = IphBulanan::where('tahun', $tahun)
            ->orderBy('bulan')
            ->get();

        $bulanLabels = $bulanan->pluck('bulan')->map(function ($b) {
            return "Bulan $b";
        });

        // Jika tidak ada field rata-rata bulanan, bisa hitung manual
        $bulanData = $bulanan->pluck('rata_rata_bulanan');

        // =====================
        // 🔹 Highlight Mingguan Terbaru
        // =====================
        $highlightMingguan = IphMingguan::orderByDesc('created_at')->first();

        // =====================
        // 🔹 Total Statistik
        // =====================
        $totalMingguan = IphMingguan::count();
        $totalBulanan = IphBulanan::count();

        return view('admin.dashboard', compact(
            'tahun',
            'mingguLabels',
            'mingguData',
            'bulanLabels',
            'bulanData',
            'highlightMingguan',
            'totalMingguan',
            'totalBulanan'
        ));
    }
}
