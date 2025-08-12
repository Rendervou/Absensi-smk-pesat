<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataGuru extends Model
{
    protected $fillable = [
        'username',
        'password',
        'nama_guru',
    ];

    // Define any relationships or additional methods here
}
