<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class UserBukuController extends Controller

{
    public function index(Request $request)
    {
        $query = Buku::query();

        // 🔍 Pencarian judul / penerbit
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('penerbit', 'like', "%{$search}%");
            });
        }

        // 🎯 Filter kategori dari dropdown
        if ($request->filled('kategori')) {
            $query->whereIn('kategori', $request->kategori);
        }

        // ✅ Checkbox: hanya buku murah (contoh: harga <= 50.000)
        if ($request->boolean('murah_only')) {
            $query->where('harga', '<=', 50000);
        }

        // 🔑 Sortir buku berdasarkan harga
        if ($request->filled('sort')) {
            $query->orderBy('harga', $request->sort);
        }

        $books = $query->get();

        // daftar kategori unik untuk dropdown
        $kategoriOptions = Buku::select('kategori')
            ->whereNotNull('kategori')
            ->distinct()
            ->pluck('kategori');

        return view('buku', compact('books', 'kategoriOptions'));
    }


    public function show($id)
    {
        $book = Buku::findOrFail($id);
        return view('buku-detail', compact('book'));
    }
}

