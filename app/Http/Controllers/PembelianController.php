<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Pesanan;
use App\Models\PesananDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class PembelianController extends Controller
{
    public function indexBuku(Request $request)
    {
        $query = Buku::query();

        if ($request->filled('q')) {
            $search = trim($request->q);

            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('penulis', 'like', "%{$search}%")
                    ->orWhere('penerbit', 'like', "%{$search}%")
                    ->orWhere('kategori', 'like', "%{$search}%");
            });
        }

        $bukus = $query->orderBy('judul')->get();

        return view('pembelian.buku_index', compact('bukus'));
    }

    public function cart()
    {
        $cart = session()->get('cart', []);
        $subtotal = 0;

        foreach ($cart as $item) {
            $subtotal += $item['harga'] * $item['qty'];
        }

        $ppn = $subtotal * 0.10;
        $total = $subtotal + $ppn;

        return view('pembelian.cart', compact('cart', 'subtotal', 'ppn', 'total'));
    }

    public function addToCart(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        $qtyRequest = $request->input('qty', 1);
        if ($qtyRequest < 1) {
            $qtyRequest = 1;
        }

        if ($buku->stok < $qtyRequest) {
            return back()->with('error', 'Stok tidak mencukupi.');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $newQty = $cart[$id]['qty'] + $qtyRequest;

            if ($buku->stok < $newQty) {
                return back()->with('error', 'Stok tidak mencukupi untuk jumlah yang diminta.');
            }

            $cart[$id]['qty'] = $newQty;
        } else {
            $cart[$id] = [
                'judul' => $buku->judul,
                'harga' => $buku->harga,
                'qty' => $qtyRequest,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Buku ditambahkan ke keranjang.');
    }

    public function updateCart(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);
        $qty = (int) $request->input('qty', 1);
        if ($qty < 1) {
            $qty = 1;
        }

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

    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Item dihapus dari keranjang.');
    }

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

    public function prosesCheckout(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:30',
            'alamat' => 'nullable|string',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        $subtotal = 0;
        foreach ($cart as $bukuId => $item) {
            $subtotal += $item['harga'] * $item['qty'];
        }
        $ppn = $subtotal * 0.10;
        $total = $subtotal + $ppn;

        DB::beginTransaction();
        try {
            $kode = 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(5));

            $pesanan = Pesanan::create([
                'kode_pesanan' => $kode,
                'nama_pelanggan' => $request->nama_pelanggan,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'subtotal' => $subtotal,
                'ppn' => $ppn,
                'total' => $total,
            ]);

            foreach ($cart as $bukuId => $item) {
                $buku = Buku::findOrFail($bukuId);

                if ($buku->stok < $item['qty']) {
                    throw new \Exception("Stok untuk {$buku->judul} tidak mencukupi.");
                }

                PesananDetail::create([
                    'pesanan_id' => $pesanan->id,
                    'buku_id' => $bukuId,
                    'qty' => $item['qty'],
                    'harga' => $item['harga'],
                    'subtotal' => $item['harga'] * $item['qty'],
                ]);

                $buku->stok -= $item['qty'];
                $buku->save();
            }

            DB::commit();

            session()->forget('cart');

            return redirect()->route('pembelian.selesai', $pesanan->id)
                ->with('success', 'Checkout berhasil!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index')->with('error', $e->getMessage());
        }
    }

    public function selesai($id)
    {
        $pesanan = Pesanan::with('details.buku')->findOrFail($id);
        $barcodeHtml = $this->generateCode39Html($pesanan->kode_pesanan);

        return view('pembelian.selesai', compact('pesanan', 'barcodeHtml'));
    }

    public function downloadPdf($id)
    {
        $pesanan = Pesanan::with('details.buku')->findOrFail($id);
        $barcodeHtml = $this->generateCode39Html($pesanan->kode_pesanan);

        $pdf = Pdf::loadView('pembelian.nota_pdf', [
            'pesanan' => $pesanan,
            'barcodeHtml' => $barcodeHtml,
        ])->setPaper('a4', 'portrait');

        $filename = 'Nota-' . $pesanan->kode_pesanan . '.pdf';

        return $pdf->download($filename);
    }

    public function detail($id)
    {
        $pesanan = Pesanan::with('details.buku')->findOrFail($id);
        return view('pembelian.detail', compact('pesanan'));
    }

    public function batalkan($id)
    {
        $pesanan = Pesanan::findOrFail($id);

        PesananDetail::where('pesanan_id', $id)->delete();
        $pesanan->delete();

        return redirect()->route('pembelian.buku_index')
            ->with('success', 'Pesanan berhasil dibatalkan.');
    }

    private function generateCode39Html(string $value): string
    {
        $value = strtoupper(trim($value));

        $patterns = [
            '0' => 'nnnwwnwnn',
            '1' => 'wnnwnnnnw',
            '2' => 'nnwwnnnnw',
            '3' => 'wnwwnnnnn',
            '4' => 'nnnwwnnnw',
            '5' => 'wnnwwnnnn',
            '6' => 'nnwwwnnnn',
            '7' => 'nnnwnnwnw',
            '8' => 'wnnwnnwnn',
            '9' => 'nnwwnnwnn',
            'A' => 'wnnnnwnnw',
            'B' => 'nnwnnwnnw',
            'C' => 'wnwnnwnnn',
            'D' => 'nnnnwwnnw',
            'E' => 'wnnnwwnnn',
            'F' => 'nnwnwwnnn',
            'G' => 'nnnnnwwnw',
            'H' => 'wnnnnwwnn',
            'I' => 'nnwnnwwnn',
            'J' => 'nnnnwwwnn',
            'K' => 'wnnnnnnww',
            'L' => 'nnwnnnnww',
            'M' => 'wnwnnnnwn',
            'N' => 'nnnnwnnww',
            'O' => 'wnnnwnnwn',
            'P' => 'nnwnwnnwn',
            'Q' => 'nnnnnnwww',
            'R' => 'wnnnnnwwn',
            'S' => 'nnwnnnwwn',
            'T' => 'nnnnwnwwn',
            'U' => 'wwnnnnnnw',
            'V' => 'nwwnnnnnw',
            'W' => 'wwwnnnnnn',
            'X' => 'nwnnwnnnw',
            'Y' => 'wwnnwnnnn',
            'Z' => 'nwwnwnnnn',
            '-' => 'nwnnnnwnw',
            '.' => 'wwnnnnwnn',
            ' ' => 'nwwnnnwnn',
            '$' => 'nwnwnwnnn',
            '/' => 'nwnwnnnwn',
            '+' => 'nwnnnwnwn',
            '%' => 'nnnwnwnwn',
            '*' => 'nwnnwnwnn',
        ];

        if ($value === '') {
            return '';
        }

        $barcode = '*' . $value . '*';
        $narrow = 2;
        $wide = 5;
        $gap = 2;
        $barHeight = 60;
        $cells = [];

        foreach (str_split($barcode) as $char) {
            if (! isset($patterns[$char])) {
                return '';
            }

            $isBar = true;

            foreach (str_split($patterns[$char]) as $unit) {
                $width = $unit === 'w' ? $wide : $narrow;

                $cells[] = sprintf(
                    '<td class="%s" style="width:%dpx;height:%dpx;"></td>',
                    $isBar ? 'barcode-black' : 'barcode-space',
                    $width,
                    $barHeight
                );

                $isBar = ! $isBar;
            }

            $cells[] = sprintf(
                '<td class="barcode-space" style="width:%dpx;height:%dpx;"></td>',
                $gap,
                $barHeight
            );
        }

        $escapedValue = e($value);

        return sprintf(
            '<div class="barcode-wrap" aria-label="Barcode %1$s"><table class="barcode-table" cellspacing="0" cellpadding="0" role="presentation"><tr>%2$s</tr></table><div class="barcode-label">%1$s</div></div>',
            $escapedValue,
            implode('', $cells)
        );
    }
}
