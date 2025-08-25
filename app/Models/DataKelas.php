<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataKelas extends Model
{
    protected $table = "data_kelas";
    protected $primaryKey = "id_kelas";
    protected $fillable = [
        'nama_kelas'
    ];
}
