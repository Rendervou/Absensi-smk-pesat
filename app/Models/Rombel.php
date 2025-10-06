<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rombel extends Model
{
    protected $table = "rombels";
    protected $primaryKey = "id";
    protected $fillable = [
        'id_siswa',
        'id_kelas',
        'id_jurusan',
    ];

    // Relasi ke siswa
    public function siswa()
    {
        return $this->belongsTo(DataSiswa::class, 'id_siswa', 'id_siswa');
    }

    // Relasi ke kelas
    public function kelas()
    {
        return $this->belongsTo(DataKelas::class, 'id_kelas', 'id_kelas');
    }

    // Relasi ke jurusan
    public function jurusan()
    {
        return $this->belongsTo(DataJurusan::class, 'id_jurusan', 'id_jurusan');
    }
}
