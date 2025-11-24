<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Pesanan;
use App\Models\PesananDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\PembelianController;

use function PHPUnit\Framework\returnSelf;


class PembelianController extends Controller
{
    // ====== LIST BUKU + TOMBOL TAMBAH KE KERANJANG ======
    public function indexBuku()
    {
        $bukus = Buku::all();
        return view('pembelian.buku_index', compact('bukus'));
    }

    // ====== LIHAT KERANJANG ======
    public function cart()
    {
        $cart = session()->get('cart', []);
        $subtotal = 0;

        foreach ($cart as $item) {
            $subtotal += $item['harga'] * $item['qty'];
        }

        $ppn = $subtotal * 0.10; // 10%
        $total = $subtotal + $ppn;

        return view('pembelian.cart', compact('cart', 'subtotal', 'ppn', 'total'));
    }

    // ====== TAMBAH KE KERANJANG ======
    public function addToCart(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        // cek stok
        $qtyRequest = $request->input('qty', 1);
        if ($qtyRequest < 1) $qtyRequest = 1;

        if ($buku->stok < $qtyRequest) {
            return back()->with('error', 'Stok tidak mencukupi.');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            // kalau sudah ada di keranjang, tambahkan qty
            $newQty = $cart[$id]['qty'] + $qtyRequest;

            if ($buku->stok < $newQty) {
                return back()->with('error', 'Stok tidak mencukupi untuk jumlah yang diminta.');
            }

            $cart[$id]['qty'] = $newQty;
        } else {
            // item baru
            $cart[$id] = [
                'judul' => $buku->judul,
                'harga' => $buku->harga,
                'qty'   => $qtyRequest,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Buku ditambahkan ke keranjang.');
    }

    // ====== UPDATE QTY DI KERANJANG ======
    public function updateCart(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);
        $qty = (int) $request->input('qty', 1);
        if ($qty < 1) $qty = 1;

        if ($buku->stok < $qty) {
            return back()->with('error', 'Stok tidak mencukupi.');
        }

        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['qty'] = $qty;
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Keranjang diperbarui.');
    }

    // ====== HAPUS ITEM KERANJANG ======
    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Item dihapus dari keranjang.');
    }

    // ====== FORM CHECKOUT ======
    public function checkoutForm()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang masih kosong.');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['harga'] * $item['qty'];
        }

        $ppn = $subtotal * 0.10;
        $total = $subtotal + $ppn;

        return view('pembelian.checkout', compact('cart', 'subtotal', 'ppn', 'total'));
    }

    // ====== PROSES CHECKOUT (SIMPAN PESANAN) ======
    public function prosesCheckout(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'no_hp'          => 'nullable|string|max:30',
            'alamat'         => 'nullable|string',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        // Hitung ulang subtotal, PPN, total
        $subtotal = 0;
        foreach ($cart as $bukuId => $item) {
            $subtotal += $item['harga'] * $item['qty'];
        }
        $ppn = $subtotal * 0.10;
        $total = $subtotal + $ppn;

        DB::beginTransaction();
        try {
            // generate kode pesanan
            $kode = 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(5));

            // simpan ke tabel pesanan
            $pesanan = Pesanan::create([
                'kode_pesanan'   => $kode,
                'nama_pelanggan' => $request->nama_pelanggan,
                'no_hp'          => $request->no_hp,
                'alamat'         => $request->alamat,
                'subtotal'       => $subtotal,
                'ppn'            => $ppn,
                'total'          => $total,
            ]);

            // simpan detail + kurangi stok
            foreach ($cart as $bukuId => $item) {
                $buku = Buku::findOrFail($bukuId);

                // cek stok lagi untuk aman
                if ($buku->stok < $item['qty']) {
                    throw new \Exception("Stok untuk {$buku->judul} tidak mencukupi.");
                }

                PesananDetail::create([
                    'pesanan_id' => $pesanan->id,
                    'buku_id'    => $bukuId,
                    'qty'        => $item['qty'],
                    'harga'      => $item['harga'],
                    'subtotal'   => $item['harga'] * $item['qty'],
                ]);

                // kurangi stok
                $buku->stok -= $item['qty'];
                $buku->save();
            }

            DB::commit();

            // kosongkan keranjang
            session()->forget('cart');

            return redirect()->route('pembelian.selesai', $pesanan->id)
                ->with('success', 'Checkout berhasil!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index')->with('error', $e->getMessage());
        }
    }

    // ====== HALAMAN DETAIL / SELESAI PESANAN ======
    public function selesai($id)
    {
        $pesanan = Pesanan::with('details.buku')->findOrFail($id);
        return view('pembelian.selesai', compact('pesanan'));
    }

    // ====== DOWNLOAD PDF NOTA ======
    public function downloadPdf($id)
    {
        $pesanan = Pesanan::with('details.buku')->findOrFail($id);

        $pdf = Pdf::loadView('pembelian.nota_pdf', [
            'pesanan' => $pesanan,
        ])->setPaper('a4', 'portrait');

        $filename = 'Nota-' . $pesanan->kode_pesanan . '.pdf';

        return $pdf->download($filename);
    }

    // ====== DETAIL PESANAN ======
    public function detail($id)
    {
        $pesanan = Pesanan::with('details.buku')->findOrFail($id);
        return view('pembelian.detail', compact('pesanan'));
    }
public function batalkan($id)
{
    $pesanan = Pesanan::findOrFail($id);

    // Hapus detail terlebih dahulu
    PesananDetail::where('pesanan_id', $id)->delete();

    // Hapus pesanan utama
    $pesanan->delete();

    return redirect()->route('pembelian.buku_index')
                     ->with('success', 'Pesanan berhasil dibatalkan.');
}

}   
