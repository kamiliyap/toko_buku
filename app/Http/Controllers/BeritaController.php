<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class BeritaController extends Controller
{
    /**
     * Instantiate a new controller instance.
     * Apply auth middleware if you want to protect create/edit routes.
     */
    public function __construct()
    {
        // Uncomment the next line if you require authentication
        // $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $berita = \App\Models\Berita::orderBy('created_at', 'desc')->paginate(9);

        return view('berita.index', compact('berita'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('berita.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'slug'  => 'nullable|string|max:255|unique:berita,slug',
            'konten'=> 'required|string',
            'gambar'=> 'nullable|image|max:2048', // max 2MB
            'published_at' => 'nullable|date',
        ]);

        // buat slug otomatis jika kosong
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['judul']);
            $originalSlug = $data['slug'];
            $i = 1;
            while (Berita::where('slug', $data['slug'])->exists()) {
                $data['slug'] = $originalSlug . '-' . $i++;
            }
        }

        // handle upload gambar
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/berita', $filename);
            // simpan path relatif ke storage (tanpa 'public/') sehingga bisa dipanggil asset('storage/berita/...')
            $data['gambar'] = 'berita/' . $filename;
        }

        $berita = Berita::create($data);

        return redirect()->route('berita.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Berita $berita)
    {
        return view('berita.show', compact('berita'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Berita $berita)
    {
        return view('berita.edit', compact('berita'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Berita $berita)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'slug'  => ['nullable','string','max:255', Rule::unique('berita','slug')->ignore($berita->id)],
            'konten'=> 'required|string',
            'gambar'=> 'nullable|image|max:2048',
            'published_at' => 'nullable|date',
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['judul']);
            $originalSlug = $data['slug'];
            $i = 1;
            while (Berita::where('slug', $data['slug'])->where('id','!=',$berita->id)->exists()) {
                $data['slug'] = $originalSlug . '-' . $i++;
            }
        }

        if ($request->hasFile('gambar')) {
            // hapus file lama jika ada
            if ($berita->gambar) {
                Storage::delete('public/' . $berita->gambar);
            }

            $file = $request->file('gambar');
            $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/berita', $filename);
            $data['gambar'] = 'berita/' . $filename;
        }

        $berita->update($data);

        return redirect()->route('berita.index')->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Berita $berita)
    {
        // hapus gambar fisik bila ada
        if ($berita->gambar) {
            Storage::delete('public/' . $berita->gambar);
        }

        $berita->delete();

        return redirect()->route('berita.index')->with('success', 'Berita berhasil dihapus.');
    }
    /**
 * Tampilkan dashboard admin sederhana
 */
    public function dashboard()
    {
        // statistik dasar
        $total = Berita::count();
        $published = Berita::whereNotNull('published_at')->where('published_at', '<=', now())->count();
        $drafts = Berita::whereNull('published_at')->count();

        // berita terbaru 5
        $latest = Berita::orderBy('created_at', 'desc')->limit(5)->get();

        // kirim ke view
        return view('admin.dashboard', compact('total', 'published', 'drafts', 'latest'));
    }

    
}
