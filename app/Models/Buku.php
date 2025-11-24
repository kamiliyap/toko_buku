<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'buku'; // <– kita paksa pakai tabel 'buku'

    protected $fillable = [
        'judul',
        'penulis',
        'kategori',
        'penerbit',
        'stok',
        'harga',
        'deskripsi',
        'gambar',
    ];
}
