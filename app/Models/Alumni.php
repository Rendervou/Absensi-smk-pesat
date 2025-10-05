<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    use HasFactory;

    protected $table = 'alumni';
    protected $primaryKey = 'id_alumni';

    protected $fillable = [
        'id_siswa',
        'nama_siswa',
        'nis',
        'no_tlp',
        'id_kelas_terakhir',
        'nama_kelas_terakhir',
        'id_jurusan',
        'nama_jurusan',
        'tahun_lulus',
        'tanggal_kelulusan',
        'catatan',
    ];

    protected $casts = [
        'tanggal_kelulusan' => 'date',
        'tahun_lulus' => 'integer',
    ];

    // Relasi ke data siswa
    public function siswa()
    {
        return $this->belongsTo(DataSiswa::class, 'id_siswa', 'id_siswa');
    }

    // Relasi ke kelas
    public function kelas()
    {
        return $this->belongsTo(DataKelas::class, 'id_kelas_terakhir', 'id_kelas');
    }

    // Relasi ke jurusan
    public function jurusan()
    {
        return $this->belongsTo(DataJurusan::class, 'id_jurusan', 'id_jurusan');
    }

    // Scope untuk filter by tahun
    public function scopeTahunLulus($query, $tahun)
    {
        return $query->where('tahun_lulus', $tahun);
    }

    // Scope untuk filter by kelas
    public function scopeKelas($query, $namaKelas)
    {
        return $query->where('nama_kelas_terakhir', $namaKelas);
    }
}