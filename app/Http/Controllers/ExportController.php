<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IphMingguan;
use App\Models\IphBulanan;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ArrayExport;

class ExportController extends Controller
{
    public function mingguan()
    {
        $data = IphMingguan::all()->map(function ($item) {
            return [
                'ID' => $item->id,
                'Tahun' => $item->tahun,
                'Bulan' => $item->bulan,
                'Minggu Ke' => $item->minggu_ke,
                'Perubahan Harga' => $item->perubahan_harga,
                'Status Harga' => $item->status_harga,
                'Fluktuasi Tertinggi' => $item->fluktuasi_tertinggi,
                'Komoditas 1' => $item->nama_komoditas_1,
                'Andil 1' => $item->nilai_andil_1,
                'Komoditas 2' => $item->nama_komoditas_2,
                'Andil 2' => $item->nilai_andil_2,
                'Komoditas 3' => $item->nama_komoditas_3,
                'Andil 3' => $item->nilai_andil_3,
                'Komoditas 4' => $item->nama_komoditas_4,
                'Andil 4' => $item->nilai_andil_4,
                'Komoditas 5' => $item->nama_komoditas_5,
                'Andil 5' => $item->nilai_andil_5,
                'Disparitas Harga' => $item->disparitas_harga,
                'Nilai Fluktuasi' => $item->nilai_fluktuasi,
            ];
        })->toArray();

        $headings = [
            'ID', 'Tahun', 'Bulan', 'Minggu Ke',
            'Perubahan Harga', 'Status Harga', 'Fluktuasi Tertinggi',
            'Komoditas 1', 'Andil 1', 'Komoditas 2', 'Andil 2',
            'Komoditas 3', 'Andil 3', 'Komoditas 4', 'Andil 4',
            'Komoditas 5', 'Andil 5',
            'Disparitas Harga', 'Nilai Fluktuasi'
        ];

        return Excel::download(new ArrayExport($data, $headings), 'IPH_Mingguan.xlsx');
    }

    public function bulanan()
    {
        $data = IphBulanan::all()->map(function ($item) {
            return [
                'ID' => $item->id,
                'Tahun' => $item->tahun,
                'Bulan' => $item->bulan,
                'Perubahan Harga' => $item->perubahan_harga,
                'Status Harga' => $item->status_harga,
                'Fluktuasi Tertinggi' => $item->fluktuasi_tertinggi,
                'Disparitas Harga' => $item->disparitas_harga,
                'Nilai Fluktuasi' => $item->nilai_fluktuasi,
            ];
        })->toArray();

        $headings = [
            'ID', 'Tahun', 'Bulan',
            'Perubahan Harga', 'Status Harga', 'Fluktuasi Tertinggi',
            'Disparitas Harga', 'Nilai Fluktuasi'
        ];

        return Excel::download(new ArrayExport($data, $headings), 'IPH_Bulanan.xlsx');
    }
}
