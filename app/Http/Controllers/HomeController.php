<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
         * 2) Penerbit + Logo otomatis
         *    Logo diambil dari:
         *    storage/app/public/publishers/slug.png
         * ----------------------------- */
        $rawPublishers = DB::table('buku')
            ->select('penerbit')
            ->whereNotNull('penerbit')
            ->distinct()
            ->orderBy('penerbit')
            ->limit(20)
            ->pluck('penerbit');

        $publishers = $rawPublishers->map(function($name){
            $slug = Str::slug($name);
            $exts = ['png','jpg','jpeg','webp','svg'];
            $found = null;

            foreach ($exts as $ext) {
                $path = "publishers/{$slug}.{$ext}";
                if (Storage::disk('public')->exists($path)) {
                    $found = asset("storage/{$path}");
                    break;
                }
            }

            if ($found) {
                return [
                    'name' => $name,
                    'logo' => $found,
                ];
            }

            return null;
        })->filter()->values()->toArray();



        /** -----------------------------
         * 3) Poster banner
         * ----------------------------- */
        $posterFiles = [];

        if (Storage::disk('public')->exists('poster')) {
            $all = Storage::disk('public')->files('poster');
            $posterFiles = collect($all)
                ->filter(fn($f) => preg_match('/\.(jpe?g|png|gif|webp)$/i', $f))
                ->values()
                ->all(); 
        }


        /** -----------------------------
         * 4) FAQ statis
         * ----------------------------- */
        $faqs = [
            ['q' => 'Apa metode pengiriman yang tersedia?', 'a' => 'Kami bekerja sama dengan kurir lokal & ekspedisi nasional.'],
            ['q' => 'Bisakah saya mengembalikan buku?', 'a' => 'Bisa jika buku rusak saat diterima.'],
        ];


        /** -----------------------------
         * 5) RETURN VIEW
         * ----------------------------- */
        return view('home', compact('books','publishers','faqs','posterFiles'));
    }
}
