<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataSiswa extends Model
{
    protected $table = "data_siswas";
    protected $primaryKey = "id_siswa";
    protected $fillable = [
        'nama_siswa',
        'nis',
        'no_tlp',
        'alamat',
        'id_kelas',   // tambahkan ini
    ];

    public function kelas()
    {
        return $this->belongsTo(DataKelas::class, 'id_kelas', 'id_kelas');
    }
}
