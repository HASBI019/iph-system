<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    // app/Models/SiteSetting.php
protected $fillable = [
    'judul', 'subjudul', 'logo', 'logo_berakhlak', 'logo_iph',
    'alamat', 'telepon', 'email', 'tahukah_kamu'
];
}
    //

