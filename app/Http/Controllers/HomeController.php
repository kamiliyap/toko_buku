<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {
        /** -----------------------------
         * 1) Buku Best Seller / terbaru
         * ----------------------------- */
        $books = Buku::orderByDesc('id')->take(8)->get();

        /** -----------------------------
         * 2) Penerbit + Logo (STATIC)
         *    Logo diambil dari:
         *    public/images/publishers/slug.ext
         * ----------------------------- */
        $rawPublishers = DB::table('buku')
            ->select('penerbit')
            ->whereNotNull('penerbit')
            ->distinct()
            ->orderBy('penerbit')
            ->limit(20)
            ->pluck('penerbit');

        $publishers = $rawPublishers->map(function ($name) {
            $slug = Str::slug($name);
            $exts = ['png', 'jpg', 'jpeg', 'webp', 'svg'];
            $filename = null;

            foreach ($exts as $ext) {
                $candidate = "images/publishers/{$slug}.{$ext}";
                if (file_exists(public_path($candidate))) {
                    // simpan hanya NAMANYA, biar Blade pakai asset('images/publishers/'.$logo)
                    $filename = "{$slug}.{$ext}";
                    break;
                }
            }

            if ($filename) {
                return [
                    'name' => $name,
                    'logo' => $filename, // contoh: erlangga.png
                ];
            }

            return null;
        })->filter()->values()->toArray();

        /** -----------------------------
         * 3) Poster banner (STATIC)
         *    Diambil dari: public/images/poster
         * ----------------------------- */
        $posterFiles = [];
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

        /** -----------------------------
         * 4) FAQ statis
         * ----------------------------- */
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

        /** -----------------------------
         * 5) RETURN VIEW
         * ----------------------------- */
        return view('home', compact('books', 'publishers', 'faqs', 'posterFiles'));
    }
}
