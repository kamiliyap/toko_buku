<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penerbit extends Model
{
    protected $table = 'penerbit'; // nama tabel

    protected $fillable = [
        'nama',
        'alamat',
        'telepon'
    ];
}
