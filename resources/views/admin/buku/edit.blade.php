{{-- resources/views/admin/buku/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Edit Buku')

@section('content')
<div class="container-main py-3">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold mb-0">✏️ Edit Buku</h3>
        <a href="{{ route('buku.index') }}" class="btn btn-outline-secondary btn-sm">
            Kembali
        </a>
    </div>

    {{-- FLASH MESSAGE --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- FORM EDIT --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('buku.update', $buku->id) }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Judul</label>
                    <input type="text" name="judul" class="form-control"
                           value="{{ old('judul', $buku->judul) }}" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Penulis</label>
                        <input type="text" name="penulis" class="form-control"
                               value="{{ old('penulis', $buku->penulis) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kategori</label>
                        <input type="text" name="kategori" class="form-control"
                               value="{{ old('kategori', $buku->kategori) }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Penerbit</label>
                        <input type="text" name="penerbit" class="form-control"
                               value="{{ old('penerbit', $buku->penerbit) }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Stok</label>
                        <input type="number" name="stok" class="form-control"
                               value="{{ old('stok', $buku->stok) }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Harga (Rp)</label>
                        <input type="number" name="harga" class="form-control"
                               value="{{ old('harga', $buku->harga) }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $buku->deskripsi) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label d-block">Gambar</label>

                    @if($buku->gambar)
                        <div class="mb-2">
                            <img src="{{ asset('storage/'.$buku->gambar) }}"
                                 alt="Gambar Buku"
                                 style="height:120px;object-fit:cover;">
                        </div>
                    @endif

                    <input type="file" name="gambar" class="form-control">
                    <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                </div>

                <button type="submit" class="btn btn-primary">
                    Simpan Perubahan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
