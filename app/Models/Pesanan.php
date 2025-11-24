<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    // Paksa Laravel pakai tabel 'pesanan' (bukan 'pesanans')
    protected $table = 'pesanan';

    protected $fillable = [
        'kode_pesanan',
        'nama_pelanggan',
        'no_hp',
        'alamat',
        'subtotal',
        'ppn',
        'total',
    ];

    // relasi ke detail
    public function details()
    {
        return $this->hasMany(PesananDetail::class, 'pesanan_id');
    }
}
