<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Penerbit;
use Illuminate\Support\Facades\Storage;


class HomeController extends Controller
{
    public function index()
    {
        $books = Buku::orderByDesc('id')->take(8)->get();

        $publishers = Penerbit::orderBy('nama')->get();

        $posterFiles = [];
        $posterFiles = [];

        $all = Storage::disk('public')->files('poster');

        $posterFiles = collect($all)
            ->filter(function ($f) {
                return preg_match('/\.(jpe?g|png|gif|webp)$/i', $f);
            })
            ->map(function ($f) {
                return basename($f); // ambil hanya nama file, bukan full path
            })
            ->values()
            ->all();

        $posterDir = public_path('images/poster');

        if (is_dir($posterDir)) {
            foreach (scandir($posterDir) as $file) {
                if ($file === '.' || $file === '..') {
                    continue;
                }

                // hanya file gambar
                if (!preg_match('/\.(jpe?g|png|gif|webp)$/i', $file)) {
                    continue;
                }

                // simpan nama file saja, contoh: "banner1.jpg"
                $posterFiles[] = $file;
            }
        }

        $faqs = [
            [
                'q' => 'Apa metode pengiriman yang tersedia?',
                'a' => 'Kami bekerja sama dengan kurir lokal & ekspedisi nasional.',
            ],
            [
                'q' => 'Bisakah saya mengembalikan buku?',
                'a' => 'Bisa jika buku rusak saat diterima.',
            ],
        ];

        return view('home', compact('books', 'publishers', 'faqs', 'posterFiles'));
    }
}
