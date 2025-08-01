<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IphMingguan extends Model
{
    protected $table = 'iph_mingguan';

    protected $fillable = [
        'tahun', 'bulan', 'minggu_ke', 'perubahan_harga', 'status_harga', 'fluktuasi_tertinggi',
        'nama_komoditas_1', 'nilai_andil_1',
        'nama_komoditas_2', 'nilai_andil_2',
        'nama_komoditas_3', 'nilai_andil_3',
        'nama_komoditas_4', 'nilai_andil_4',
        'nama_komoditas_5', 'nilai_andil_5',
        'disparitas_harga', 'nilai_fluktuasi',
        'waktu' // ⬅️ Tambahkan ini agar waktu tersimpan!
    ];
}
