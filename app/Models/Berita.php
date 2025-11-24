<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Berita extends Model
{
    // jika tabel di DB bernama 'berita' (bukan plural 'beritas')
    protected $table = 'berita';

    // kolom yang boleh diisi mass-assignment
    protected $fillable = [
        'judul',
        'slug',
        'isi',
        'gambar',
        'kategori',
        'penulis',
        'published_at',
    ];

    // otomatis cast published_at ke datetime
    protected $dates = [
        'published_at',
    ];

    // auto-generate slug saat creating jika kosong
    public static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->slug) && !empty($model->judul)) {
                $model->slug = Str::slug($model->judul);
            }
        });
    }

    // contoh accessor singkat (opsional)
    public function getExcerptAttribute()
    {
        return \Illuminate\Support\Str::limit(strip_tags($this->isi), 160);
    }
}
