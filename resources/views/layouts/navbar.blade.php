{{-- resources/views/buku.blade.php --}}
@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('styles')
<style>
    .book-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 20px;
        padding-top: 20px;
    }

    .book-card {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0,0,0,0.06);
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .book-card img {
        width: 100%;
        height: 210px;
        object-fit: cover;
    }

    .book-card-body {
        padding: 12px;
        display: flex;
        flex-direction: column;
        gap: 6px;
        flex: 1;
    }

    .badge-kategori {
        font-size: 11px;
        background: #e9ecef;
        padding: 3px 8px;
        border-radius: 50px;
    }
</style>
@endsection

@section('content')

<div class="container py-4">
    <h3 class="fw-bold mb-3">📚 Daftar Buku</h3>

    <div class="book-grid">
        @foreach($books as $book)
            <div class="book-card">

                {{-- Gambar --}}
                <img src="{{ asset('storage/' . $book->gambar) }}"
                     alt="{{ $book->judul }}">

                <div class="book-card-body">

                    <p class="fw-bold mb-1">{{ $book->judul }}</p>

                    <div class="text-muted small">
                        {{ $book->penerbit }}
                        <br>
                        <span class="badge-kategori">{{ $book->kategori }}</span>
                    </div>

                    <div class="fw-bold text-primary">
                        Rp {{ number_format($book->harga, 0, ',', '.') }}
                    </div>

                    <div class="mt-auto d-flex gap-1">
                        <a class="btn btn-outline-primary btn-sm w-50">Detail</a>

                        <form action="#" method="POST" class="w-50">
                            @csrf
                            <button class="btn btn-primary btn-sm w-100">
                                + Keranjang
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        @endforeach
    </div>

</div>

@endsection
