@extends('layouts.admin')

@section('title', 'Tambah Buku')

@section('content')
<div class="container-main">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold mb-0">➕ Tambah Buku</h3>
        <a href="{{ route('buku.index') }}" class="btn btn-outline-secondary btn-sm">
            Kembali
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <form action="{{ route('buku.store') }}" 
                  method="POST" 
                  enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Judul *</label>
                    <input type="text" name="judul" class="form-control" 
                           value="{{ old('judul') }}" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Penerbit</label>
                        <input type="text" name="penerbit" class="form-control"
                               value="{{ old('penerbit') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">ISBN</label>
                        <input type="text" name="ISBN" class="form-control"
                               value="{{ old('ISBN') }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Penulis</label>
                        <input type="text" name="penulis" class="form-control"
                               value="{{ old('penulis') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kategori</label>
                        <input type="text" name="kategori" class="form-control"
                               value="{{ old('kategori') }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Stok</label>
                        <input type="number" name="stok" class="form-control"
                               value="{{ old('stok', 0) }}">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Harga (Rp)</label>
                        <input type="number" name="harga" class="form-control"
                               value="{{ old('harga', 0) }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="4">{{ old('deskripsi') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Gambar</label>
                    <input type="file" name="gambar" class="form-control">
                    <small class="text-muted">Opsional. Format: jpg, jpeg, png, webp. Maks 2MB.</small>
                </div>

                <button type="submit" class="btn btn-primary">
                    Simpan Buku
                </button>
            </form>

        </div>
    </div>
</div>
@endsection
