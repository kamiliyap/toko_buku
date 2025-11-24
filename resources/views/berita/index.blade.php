{{-- resources/views/berita/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Daftar Berita')

@section('content')
<div class="container-main py-3">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">📰 Daftar Berita</h3>
            <p class="text-muted mb-0">
                Informasi terbaru seputar toko buku dan promo menarik.
            </p>
        </div>

        {{-- Tombol tambah hanya untuk admin (kalau pakai is_admin) --}}
        @auth
            @if(auth()->user()->is_admin ?? false)
                <a href="{{ route('berita.create') }}" class="btn btn-primary">
                    + Tambah Berita
                </a>
            @endif
        @endauth
    </div>

    {{-- FLASH MESSAGE --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- LIST BERITA --}}
    @if($berita->count())
        <div class="row g-3">
            @foreach($berita as $b)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm border-0">

                        @if(!empty($b->gambar))
                            <img src="{{ asset('storage/'.$b->gambar) }}"
                                 class="card-img-top"
                                 alt="{{ $b->judul }}"
                                 style="height: 180px; object-fit: cover;">
                        @endif

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title mb-1">{{ $b->judul }}</h5>
                            <small class="text-muted mb-2">
                                {{ $b->created_at?->format('d M Y') }}
                            </small>

                            <p class="card-text flex-grow-1">
                                {{ \Illuminate\Support\Str::limit(strip_tags($b->isi ?? $b->konten ?? ''), 120) }}
                            </p>

                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <a href="{{ route('berita.show', $b->id) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    Baca Selengkapnya
                                </a>

                                @auth
                                    @if(auth()->user()->is_admin ?? false)
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('berita.edit', $b->id) }}"
                                               class="btn btn-sm btn-warning">
                                                Edit
                                            </a>
                                            <form action="{{ route('berita.destroy', $b->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Yakin hapus berita ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                @endauth
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

        {{-- PAGINATION --}}
        <div class="mt-4">
            {{ $berita->links() }}
        </div>
    @else
        <div class="alert alert-info">
            Belum ada berita yang dipublikasikan.
        </div>
    @endif

</div>
@endsection
