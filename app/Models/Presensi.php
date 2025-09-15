<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    protected $primaryKey = 'id_presensi';
    protected $fillable = [
        'id_siswa',
        'id_kelas',
        'id_user',
        'tanggal',
        'status',
        'nama_siswa',
        'nama_guru',
        'nama_kelas',
    ];

    // Relasi
    public function siswa() {
        return $this->belongsTo(DataSiswa::class, 'id_siswa', 'id_siswa');
    }

    public function kelas() {
        return $this->belongsTo(DataKelas::class, 'id_kelas', 'id_kelas');
    }

    public function guru() {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
