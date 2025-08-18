<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IphMingguan;
use App\Models\IphBulanan;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ArrayExport;

class ExportController extends Controller
{
    // Export IPH Mingguan
    public function mingguan()
    {
        $data = IphMingguan::all()->map(function ($item) {
            return [
                'ID' => $item->id,
                'Tahun' => $item->tahun,
                'Bulan' => $item->bulan,
                'Minggu Ke' => $item->minggu_ke,
                'Perubahan Harga' => $this->formatPresisi($item->perubahan_harga),
                'Status Harga' => $item->status_harga,
                'Fluktuasi Tertinggi' => $item->fluktuasi_tertinggi,
                'Komoditas 1' => $item->nama_komoditas_1,
                'Andil 1' => $this->formatPresisi($item->nilai_andil_1),
                'Komoditas 2' => $item->nama_komoditas_2,
                'Andil 2' => $this->formatPresisi($item->nilai_andil_2),
                'Komoditas 3' => $item->nama_komoditas_3,
                'Andil 3' => $this->formatPresisi($item->nilai_andil_3),
                'Komoditas 4' => $item->nama_komoditas_4,
                'Andil 4' => $this->formatPresisi($item->nilai_andil_4),
                'Komoditas 5' => $item->nama_komoditas_5,
                'Andil 5' => $this->formatPresisi($item->nilai_andil_5),
                'Disparitas Harga' => $this->formatPresisi($item->disparitas_harga),
                'Nilai Fluktuasi' => $this->formatPresisi($item->nilai_fluktuasi),
                'Jenis' => 'Mingguan',
            ];
        })->toArray();

      $headings = [
    'ID', 'Tahun', 'Bulan', 'Minggu Ke',
    'Perubahan Harga', 'Status Harga', 'Fluktuasi Tertinggi',
    'Komoditas 1', 'Andil 1', 'Komoditas 2', 'Andil 2',
    'Komoditas 3', 'Andil 3', 'Komoditas 4', 'Andil 4',
    'Komoditas 5', 'Andil 5',
    'Disparitas Harga', 'Nilai Fluktuasi',
    'Jenis'
];


        return Excel::download(new ArrayExport($data, $headings), 'IPH_Mingguan.xlsx');
    }

    // Export IPH Bulanan
    public function bulanan()
    {
        $data = IphBulanan::all()->map(function ($item) {
            return [
                'ID' => $item->id,
                'Tahun' => $item->tahun,
                'Bulan' => $item->bulan,
                'Perubahan Harga' => $this->formatPresisi($item->perubahan_harga),
                'Status Harga' => $item->status_harga,
                'Fluktuasi Tertinggi' => $item->fluktuasi_tertinggi,
                'Komoditas 1' => $item->nama_komoditas_1,
                'Andil 1' => $this->formatPresisi($item->nilai_andil_1),
                'Komoditas 2' => $item->nama_komoditas_2,
                'Andil 2' => $this->formatPresisi($item->nilai_andil_2),
                'Komoditas 3' => $item->nama_komoditas_3,
                'Andil 3' => $this->formatPresisi($item->nilai_andil_3),
                'Komoditas 4' => $item->nama_komoditas_4,
                'Andil 4' => $this->formatPresisi($item->nilai_andil_4),
                'Komoditas 5' => $item->nama_komoditas_5,
                'Andil 5' => $this->formatPresisi($item->nilai_andil_5),
                'Disparitas Harga' => $this->formatPresisi($item->disparitas_harga),
                'Nilai Fluktuasi' => $this->formatPresisi($item->nilai_fluktuasi),
                'Jenis' => 'Bulanan',
            ];
        })->toArray();

        $headings = [
            'ID', 'Tahun', 'Bulan',
            'Perubahan Harga', 'Status Harga', 'Fluktuasi Tertinggi',
            'Komoditas 1', 'Andil 1', 'Komoditas 2', 'Andil 2',
            'Komoditas 3', 'Andil 3', 'Komoditas 4', 'Andil 4',
            'Komoditas 5', 'Andil 5',
            'Disparitas Harga', 'Nilai Fluktuasi',
            'Jenis'
        ];

        return Excel::download(new ArrayExport($data, $headings), 'IPH_Bulanan.xlsx');
    }

    // Format angka dengan presisi dan koma
    private function formatPresisi($value, $digit = 4)
    {
        return is_numeric($value)
            ? number_format((float) $value, $digit, ',', '.')
            : '';
    }
}
