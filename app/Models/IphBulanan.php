<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IphBulanan extends Model
{
    protected $table = 'iph_bulanan';

    protected $fillable = [
        'tahun', 'bulan', 'perubahan_harga', 'status_harga', 'fluktuasi_tertinggi',
        'nama_komoditas_1', 'nilai_andil_1',
        'nama_komoditas_2', 'nilai_andil_2',
        'nama_komoditas_3', 'nilai_andil_3',
        'nama_komoditas_4', 'nilai_andil_4',
        'nama_komoditas_5', 'nilai_andil_5',
        'disparitas_harga', 'nilai_fluktuasi',
        'created_at'
    ];

    public $timestamps = false;
}
