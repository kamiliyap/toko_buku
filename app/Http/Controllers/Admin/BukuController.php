<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Penerbit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index()
    {
        // Kalau mau terbaru di atas:
        $buku = Buku::orderByDesc('id')->get();

        return view('admin.buku.index', compact('buku'));
    }

    public function create()
    {
        // Kalau form pakai dropdown kategori & penerbit
        $kategori = Kategori::all();
        $penerbit = Penerbit::all();

        return view('admin.buku.create', compact('kategori', 'penerbit'));
    }

    public function store(Request $request)
    {
        // VALIDASI sesuai kolom di tabel `buku`
        $data = $request->validate([
            'judul'     => 'required|string|max:255',
            'penerbit'  => 'nullable|string|max:100',
            'ISBN'      => 'nullable|string|max:20',
            'penulis'   => 'nullable|string|max:100',
            'kategori'  => 'nullable|string|max:100',
            'stok'      => 'nullable|integer',
            'harga'     => 'nullable|integer',
            'deskripsi' => 'nullable|string',
            'gambar'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // SIMPAN GAMBAR kalau ada
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('buku', 'public'); // storage/app/public/buku/...
            $data['gambar'] = $path;
        }

        // SIMPAN KE DB
        Buku::create($data);

        return redirect()
            ->route('buku.index')
            ->with('success', 'Buku berhasil ditambahkan');
    }

    public function edit($id)
    {
        $buku     = Buku::findOrFail($id);
        $kategori = Kategori::all();
        $penerbit = Penerbit::all();

        return view('admin.buku.edit', compact('buku', 'kategori', 'penerbit'));
    }

    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        $data = $request->validate([
            'judul'     => 'required|string|max:255',
            'penerbit'  => 'nullable|string|max:100',
            'ISBN'      => 'nullable|string|max:20',
            'penulis'   => 'nullable|string|max:100',
            'kategori'  => 'nullable|string|max:100',
            'stok'      => 'nullable|integer',
            'harga'     => 'nullable|integer',
            'deskripsi' => 'nullable|string',
            'gambar'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            // HAPUS GAMBAR LAMA kalau ada
            if ($buku->gambar && Storage::disk('public')->exists($buku->gambar)) {
                Storage::disk('public')->delete($buku->gambar);
            }

            $path = $request->file('gambar')->store('buku', 'public');
            $data['gambar'] = $path;
        }

        $buku->update($data);

        return redirect()
            ->route('buku.index')
            ->with('success', 'Buku berhasil diupdate');
    }

    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);

        // HAPUS FILE GAMBAR juga
        if ($buku->gambar && Storage::disk('public')->exists($buku->gambar)) {
            Storage::disk('public')->delete($buku->gambar);
        }

        $buku->delete();

        return redirect()
            ->route('buku.index')
            ->with('success', 'Buku berhasil dihapus');
    }
}
