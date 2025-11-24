@extends('layouts.app')
@section('title', $berita->judul)

@section('content')
<div class="container">
    <h1 class="mb-3">{{ $berita->judul }}</h1>

    <p class="text-muted">
        Dipublikasikan: {{ $berita->created_at->format('d M Y') }}
    </p>

    @if ($berita->gambar)
        <img src="{{ asset('storage/' . $berita->gambar) }}" class="img-fluid mb-3 rounded">
    @endif

    <div class="mb-4">
        {!! nl2br(e($berita->konten)) !!}
    </div>

    <a href="{{ route('berita.index') }}" class="btn btn-secondary">← Kembali</a>
    <a href="{{ route('berita.edit', $berita->id) }}" class="btn btn-warning">Edit Berita</a>
</div>
@endsection
