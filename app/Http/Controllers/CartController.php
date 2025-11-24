<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;

class CartController extends Controller
{
    public function add(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        $qty = $request->qty ?? 1;

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['qty'] += $qty;
        } else {
            $cart[$id] = [
                'id'    => $buku->id,
                'judul' => $buku->judul,
                'harga' => $buku->harga,
                'qty'   => $qty,
                'gambar'=> $buku->gambar
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Buku berhasil ditambahkan ke keranjang.');
    }
}
