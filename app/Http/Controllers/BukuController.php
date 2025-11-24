<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    // index: list buku (paginate)
    public function index(Request $request)
    {
        $q = $request->query('q', null);

        $buku = Buku::query();

        if ($q) {
            $buku->where(function ($qr) use ($q) {
                $qr->where('judul', 'like', "%{$q}%")
                   ->orWhere('penulis', 'like', "%{$q}%")
                   ->orWhere('kategori', 'like', "%{$q}%")
                   ->orWhere('penerbit', 'like', "%{$q}%");
            });
        }

        $buku = $buku->orderBy('id', 'desc')->paginate(12)->withQueryString();

        return view('buku.index', compact('buku', 'q'));
    }

    // show form create
    public function create()
    {
        return view('buku.create');
    }

    // store: simpan buku baru
    public function store(Request $request)
    {
        // validasi
        $validated = $request->validate([
            'judul'     => 'required|string|max:255',
            'penulis'   => 'nullable|string|max:255',
            'kategori'  => 'nullable|string|max:150',
            'penerbit'  => 'nullable|string|max:255',
            'stok'      => 'nullable|integer|min:0',
            'harga'     => 'nullable|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'gambar'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048' // max 2MB
        ]);

        // siapkan data
        $data = [
            'judul'     => $validated['judul'],
            'penulis'   => $validated['penulis'] ?? null,
            'kategori'  => $validated['kategori'] ?? null,
            'penerbit'  => $validated['penerbit'] ?? null,
            'stok'      => $validated['stok'] ?? 0,
            'harga'     => $validated['harga'] ?? 0,
            'deskripsi' => $validated['deskripsi'] ?? null,
        ];

        // handle file upload -> storage/app/public/buku
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $safe = Str::slug(substr($validated['judul'], 0, 50));
            $filename = time() . '-' . $safe . '.' . $file->getClientOriginalExtension();

            // simpan di disk 'public' dalam folder 'buku'
            $file->storeAs('buku', $filename, 'public');

            $data['gambar'] = $filename;
        }

        // simpan
        $b = Buku::create($data);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil disimpan.');
    }

    // show detail (opsional)
    public function show(Buku $buku)
    {
        return view('buku.show', ['b' => $buku]);
    }

    // edit form
    public function edit(Buku $buku)
    {
        return view('buku.create', ['b' => $buku]); // reuse form view
    }

    // update buku
    public function update(Request $request, Buku $buku)
    {
        $validated = $request->validate([
            'judul'     => 'required|string|max:255',
            'penulis'   => 'nullable|string|max:255',
            'kategori'  => 'nullable|string|max:150',
            'penerbit'  => 'nullable|string|max:255',
            'stok'      => 'nullable|integer|min:0',
            'harga'     => 'nullable|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'gambar'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $buku->judul = $validated['judul'];
        $buku->penulis = $validated['penulis'] ?? null;
        $buku->kategori = $validated['kategori'] ?? null;
        $buku->penerbit = $validated['penerbit'] ?? null;
        $buku->stok = $validated['stok'] ?? 0;
        $buku->harga = $validated['harga'] ?? 0;
        $buku->deskripsi = $validated['deskripsi'] ?? null;

        if ($request->hasFile('gambar')) {
            // hapus file lama jika ada (disk public)
            if ($buku->gambar && Storage::disk('public')->exists('buku/' . $buku->gambar)) {
                Storage::disk('public')->delete('buku/' . $buku->gambar);
            }

            $file = $request->file('gambar');
            $safe = Str::slug(substr($validated['judul'], 0, 50));
            $filename = time() . '-' . $safe . '.' . $file->getClientOriginalExtension();

            // simpan file baru
            $file->storeAs('buku', $filename, 'public');

            $buku->gambar = $filename;
        }

        $buku->save();

        return redirect()->route('buku.index')->with('success', 'Data buku berhasil diperbarui.');
    }

    // destroy
    public function destroy(Buku $buku)
    {
        // hapus gambar fisik dari storage public jika ada
        if ($buku->gambar && Storage::disk('public')->exists('buku/' . $buku->gambar)) {
            Storage::disk('public')->delete('buku/' . $buku->gambar);
        }

        $buku->delete();

        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus.');
    }
}
