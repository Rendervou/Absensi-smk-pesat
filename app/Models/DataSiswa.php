<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataSiswa extends Model
{
    protected $fillable = [
        'nama_siswa',
        'nis',
        'no_tlp',
        'alamat',
    ];
}
