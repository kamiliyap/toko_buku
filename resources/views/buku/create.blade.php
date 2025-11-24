@extends('layouts.admin')

@section('title', isset($b) ? 'Edit Buku' : 'Tambah Buku')

@section('content')
<div class="container-main">

    <h3 class="mb-3">
        {{ isset($b) ? 'Edit Buku' : 'Tambah Buku' }}
    </h3>

    {{-- FORM TAMBAH / EDIT --}}
    <form action="{{ isset($b) ? route('buku.update', $b->id) : route('buku.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="card p-3 shadow-sm">
        @csrf
        @if(isset($b)) @method('PUT') @endif

        <div class="mb-2">
            <label class="form-label">Judul <span class="text-danger">*</span></label>
            <input type="text"
                   name="judul"
                   class="form-control"
                   required
                   value="{{ old('judul', $b->judul ?? '') }}">
            @error('judul')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="row">
            <div class="col-md-6 mb-2">
                <label class="form-label">Penulis</label>
                <input type="text"
                       name="penulis"
                       class="form-control"
                       value="{{ old('penulis', $b->penulis ?? '') }}">
            </div>
            <div class="col-md-6 mb-2">
                <label class="form-label">Kategori</label>
                <input type="text"
                       name="kategori"
                       class="form-control"
                       value="{{ old('kategori', $b->kategori ?? '') }}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-2">
                <label class="form-label">Penerbit</label>
                <input type="text"
                       name="penerbit"
                       class="form-control"
                       value="{{ old('penerbit', $b->penerbit ?? '') }}">
            </div>
            <div class="col-md-4 mb-2">
                <label class="form-label">Stok</label>
                <input type="number"
                       name="stok"
                       class="form-control"
                       value="{{ old('stok', $b->stok ?? 0) }}">
            </div>
            <div class="col-md-4 mb-2">
                <label class="form-label">Harga (Rp)</label>
                <input type="number"
                       name="harga"
                       class="form-control"
                       value="{{ old('harga', $b->harga ?? 0) }}">
            </div>
        </div>

        <div class="mb-2">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi"
                      class="form-control"
                      rows="4">{{ old('deskripsi', $b->deskripsi ?? '') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Gambar (opsional)</label>
            @if(isset($b) && $b->gambar)
                <div class="mb-2">
                    <img src="{{ asset('assets/img/'.$b->gambar) }}"
                         alt="Gambar Buku"
                         style="height:120px;object-fit:cover">
                </div>
            @endif
            <input type="file" name="gambar" class="form-control">
            @error('gambar')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex gap-2">
            <button class="btn btn-primary">
                {{ isset($b) ? 'Simpan Perubahan' : 'Simpan Buku' }}
            </button>
            <a href="{{ route('buku.index') }}" class="btn btn-outline-secondary">
                Batal
            </a>
        </div>
    </form>

    {{-- FORM HAPUS (DILUAR FORM UTAMA, BIAR TIDAK NESTED) --}}
    @if(isset($b))
        <form action="{{ route('buku.destroy', $b->id) }}"
              method="POST"
              onsubmit="return confirm('Yakin hapus buku ini?')"
              class="mt-2">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger btn-sm">Hapus Buku Ini</button>
        </form>
    @endif

</div>
@endsection
