@extends('layouts.app')

@section('title', 'Tambah Berita')

@section('content')
<div class="container">
    <h1 class="mb-4">Tambah Berita</h1>

    <form action="{{ route('berita.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Judul</label>
            <input type="text" name="judul" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Slug (Opsional)</label>
            <input type="text" name="slug" class="form-control">
            <small class="text-muted">Kosongkan jika ingin otomatis</small>
        </div>

        <div class="mb-3">
            <label class="form-label">Konten</label>
            <textarea name="konten" class="form-control" rows="6" required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Gambar (Opsional)</label>
            <input type="file" name="gambar" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('berita.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
