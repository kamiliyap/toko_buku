<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    // LIST SEMUA PESANAN (+ FILTER STATUS ?status=pending)
    public function index(Request $request)
    {
        $query = Pesanan::orderBy('created_at', 'asc');

        // kalau ada filter status di query string, misal ?status=pending
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pesanan = $query->paginate(10);

        return view('admin.pesanan.index', compact('pesanan'));
    }

    // FORM EDIT
    public function edit($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        return view('admin.pesanan.edit', compact('pesanan'));
    }

    // PROSES UPDATE
    public function update(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);

        // sesuaikan field dengan kolom di tabel pesananmu
        $pesanan->update([
            'nama_pelanggan' => $request->nama_pelanggan,
            'total'          => $request->total,
            'status'         => $request->status,
        ]);

        return redirect()
            ->route('pesanan.index')
            ->with('success', 'Pesanan berhasil diperbarui');
    }

    // HAPUS PESANAN
    public function destroy($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->delete();

        return redirect()
            ->route('pesanan.index')
            ->with('success', 'Pesanan berhasil dihapus');
    }
}
