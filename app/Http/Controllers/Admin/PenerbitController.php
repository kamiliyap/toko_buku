<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penerbit;   // <-- WAJIB DITAMBAHKAN

class PenerbitController extends Controller
{
    public function index()
    {
        $penerbit = Penerbit::all();
        return view('admin.penerbit.index', compact('penerbit'));
    }

    public function create()
    {
        return view('admin.penerbit.create');
    }


    public function store(Request $request)
    {
        Penerbit::create($request->all());
        return back()->with('success', 'Penerbit berhasil ditambahkan');
    }

    public function edit($id)
    {
        $penerbit = Penerbit::findOrFail($id);
        return view('admin.penerbit.edit', compact('penerbit'));
    }

    public function update(Request $request, $id)
    {
        $penerbit = Penerbit::findOrFail($id);
        $penerbit->update($request->all());
        return back()->with('success', 'Penerbit berhasil diupdate');
    }

    public function destroy($id)
    {
        Penerbit::destroy($id);
        return back()->with('success', 'Penerbit berhasil dihapus');
    }
    
}

