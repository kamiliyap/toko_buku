<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukuUserController extends Controller
{
    public function index(Request $request)
    {
        // Ambil value pencarian
        $q = $request->input('q');

        // Query dasar
        $query = Buku::query();

        // Jika ada pencarian judul / penulis / kategori / penerbit
        if ($q) {
            $query->where(function($x) use ($q) {
                $x->where('judul', 'like', "%$q%")
                  ->orWhere('penulis', 'like', "%$q%")
                  ->orWhere('kategori', 'like', "%$q%")
                  ->orWhere('penerbit', 'like', "%$q%");
            });
        }

        // Pagination (12 per halaman)
        $buku = $query->orderByDesc('id')->paginate(12);

        return view('buku', compact('buku', 'q'));
    }
}
