<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Berita;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', [
            'totalBuku'           => Buku::count(),
            'totalBerita'         => Berita::count(),
            'totalPesananHariIni' => Pesanan::whereDate('created_at', today())->count(),
            'pendapatanHariIni'   => Pesanan::whereDate('created_at', today())->sum('total'),
            'bukuStokRendah'      => Buku::where('stok', '<=', 5)->limit(5)->get(),
            'pesananTerbaru'      => Pesanan::latest()->limit(5)->get(),
            'beritaTerbaru'       => Berita::latest()->limit(5)->get(),
            'labelPenjualan'      => ['Sen','Sel','Rab','Kam','Jum','Sab','Min'],
            'dataPenjualan'       => [5,7,3,9,4,6,8],
        ]);
    }
}
