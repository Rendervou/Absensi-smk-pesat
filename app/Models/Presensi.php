<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    protected $fillable = [
        'id_siswa',
        'id_kelas',
        'tanggal',
        'id_guru',
    ];
}
