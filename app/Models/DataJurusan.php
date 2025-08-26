<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataJurusan extends Model
{
    protected $table = "data_jurusans";
    protected $primaryKey = "id_jurusan";
    protected $fillable = [
        'nama_jurusan',
    ];
}
