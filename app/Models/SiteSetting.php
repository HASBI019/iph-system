<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $table = 'site_settings';

    protected $fillable = [
        'judul',
        'subjudul',
        'alamat',
        'telepon',
        'email',
        'tahukah_kamu',
        'deskripsi_iph',
        'logo',
        'logo_berakhlak',
        'logo_iph',
        'foto_iph',
    ];
}
