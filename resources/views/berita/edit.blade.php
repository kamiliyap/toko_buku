@extends('layouts.app')

@section('title', 'Edit Berita')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Berita</h1>

    <form action="{{ route('berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Judul</label>
            <input type="text" name="judul" value="{{ $berita->judul }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Slug (Opsional)</label>
            <input type="text" name="slug" value="{{ $berita->slug }}" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Konten</label>
            <textarea name="konten" class="form-control" rows="6" required>{{ $berita->konten }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Gambar</label>
            <br>
            @if ($berita->gambar)
                <img src="{{ asset('storage/' . $berita->gambar) }}" width="180" class="mb-2 rounded">
                <br>
            @endif
            <input type="file" name="gambar" class="form-control">
            <small class="text-muted">Upload jika ingin mengganti gambar</small>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('berita.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
