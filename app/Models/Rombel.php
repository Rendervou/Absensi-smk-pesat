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
    ];
}
