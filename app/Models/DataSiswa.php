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
        'status',           // TAMBAHKAN INI
        'tahun_masuk',      // TAMBAHKAN INI
        'tahun_lulus',      // TAMBAHKAN INI
    ];

    // Relasi ke kelas melalui rombel
    public function kelas()
    {
        return $this->hasOneThrough(
            DataKelas::class,
            Rombel::class,
            'id_siswa',      // Foreign key di rombel
            'id_kelas',      // Foreign key di data_kelas
            'id_siswa',      // Local key di data_siswas
            'id_kelas'       // Local key di rombel
        );
    }

    // Tambahkan casting
    protected $casts = [
        'tahun_masuk' => 'integer',
        'tahun_lulus' => 'integer',
    ];

    // Relasi ke rombel
    public function rombel()
    {
        return $this->hasOne(Rombel::class, 'id_siswa', 'id_siswa');
    }

    // Scope untuk filter siswa aktif
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    // Scope untuk filter siswa lulus
    public function scopeLulus($query)
    {
        return $query->where('status', 'lulus');
    }

    // Scope untuk filter siswa tidak naik kelas
    public function scopeTidakNaikKelas($query)
    {
        return $query->where('status', 'tidak_naik_kelas');
    }
}

