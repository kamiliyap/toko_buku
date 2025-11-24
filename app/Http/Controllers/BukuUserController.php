<?php

namespace App\Http\Controllers;

use App\Models\Buku;

class BukuUserController extends Controller
{
    public function index()
    {
        $books = Buku::all();
        return view('buku', compact('books'));
    }
}
