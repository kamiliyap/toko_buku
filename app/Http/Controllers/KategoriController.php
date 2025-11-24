<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
{
    $kategori = Kategori::all();
    return view('admin.kategori.index', compact('kategori'));
}
}
