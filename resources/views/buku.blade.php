{{-- resources/views/buku.blade.php --}}
@extends('layouts.user')

@section('title', 'Daftar Buku')

@section('styles')
<style>
    .book-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 20px;
        margin-top: 12px;
    }

    .book-card {
        background: #ffffff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(15,23,42,0.06);
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

    .book-title {
        font-size: 14px;
        font-weight: 700;
        margin: 0;
    }

    .book-meta {
        font-size: 12px;
        color: #6b7280;
    }

    .book-price {
        color: #2563eb;
        font-weight: 700;
        margin-top: 4px;
    }

    .badge-kategori {
        font-size: 11px;
        background: #e9ecef;
        padding: 3px 8px;
        border-radius: 999px;
    }

    .book-actions {
        margin-top: auto;
        display: flex;
        gap: 6px;
    }

    .book-actions .btn {
        font-size: 13px;
        padding-block: 6px;
    }

    /* Bar filter simpel */
    .filter-bar {
        background: #ffffff;
        border-radius: 12px;
        padding: 10px 12px;
        box-shadow: 0 4px 10px rgba(15,23,42,0.04);
        margin-bottom: 12px;
    }

    .filter-bar .form-control,
    .filter-bar .form-select {
        font-size: 14px;
    }

    .filter-bar .btn {
        font-size: 14px;
        white-space: nowrap;
    }

    @media (max-width: 768px) {
        .book-grid {
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        }
    }
    h3 {
    font-size: 26px;
    font-weight: 800;
    color: #4f46e5;            /* ungu elegan */
    margin-bottom: 16px;
    position: relative;
    padding-bottom: 6px;
    }

    h3::after {
        content: "";
        position: absolute;
        left: 0;
        bottom: 0;
        width: 60px;
        height: 3px;
        background: #6366f1;       /* garis highlight */
        border-radius: 3px;
    }
    /* ==== FILTER BAR WRAPPER ==== */
    .filter-bar {
        background: #ffffff;
        border-radius: 14px;
        padding: 14px 16px;
        box-shadow: 0 4px 14px rgba(15, 23, 42, 0.08);
        border: 1px solid #e5e7eb;
    }

    /* ==== INPUT SEARCH ==== */
    .filter-bar .form-control {
        border-radius: 10px;
        border: 1px solid #d1d5db;
        padding: 10px 14px;
        font-size: 14px;
        transition: all .2s;
    }

    .filter-bar .form-control:focus {
        border-color: #6366f1;         /* ungu */
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.25);
    }

    /* ==== DROPDOWN BUTTON ==== */
    .filter-bar .dropdown > button {
        background: #f9fafb;
        border: 1px solid #d1d5db;
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 14px;
        color: #374151;
        transition: all .2s;
    }

    .filter-bar .dropdown > button:hover {
        background: #eef2ff;           /* ungu soft */
        border-color: #6366f1;
        color: #4f46e5;
    }

    /* ==== DROPDOWN MENU ==== */
    .dropdown-checkbox {
        max-height: 250px;
        overflow-y: auto;
        border-radius: 10px;
    }

    .dropdown-checkbox li:hover {
        background: #f3f4f6;
        border-radius: 6px;
    }

    /* ==== CHECKBOX ==== */
    .form-check-input {
        border: 2px solid #6b7280;
    }

    .form-check-input:checked {
        background-color: #6366f1;
        border-color: #6366f1;
    }

    /* ==== BUTTON TERAPKAN ==== */
    .filter-bar .btn.btn-primary {
        background: #6366f1;
        border-color: #6366f1;
        padding: 8px 14px;
        border-radius: 10px;
        font-weight: 600;
    }

    .filter-bar .btn.btn-primary:hover {
        background: #4f46e5;
    }

    /* ==== BUTTON RESET ==== */
    .filter-bar .btn.btn-outline-secondary {
        border-radius: 10px;
        padding: 8px 14px;
    }

    .filter-bar .btn.btn-outline-secondary:hover {
        background: #e5e7eb;
        color: #111827;
    }



</style>
@endsection

@section('content')
    <h3 class="fw-bold mb-3">📚 Daftar Buku</h3>

    {{-- ====== FILTER DROPDOWN CHECKBOX ====== --}}
    <form method="GET" action="{{ url()->current() }}" class="filter-bar">
        <div class="row g-2 align-items-center">

            {{-- Search --}}
            <div class="col-md-5">
                <input
                    type="text"
                    name="q"
                    class="form-control"
                    placeholder="🔍 Cari judul atau penerbit..."
                    value="{{ request('q') }}"
                >
            </div>

            {{-- DROPDOWN CHECKBOX KATEGORI --}}
            <div class="col-md-4">
                <div class="dropdown w-100">
                    <button class="btn btn-light border w-100 d-flex justify-content-between align-items-center"
                            type="button"
                            data-bs-toggle="dropdown">
                        <span>
                            @if(request('kategori'))
                                {{ implode(', ', request('kategori')) }}
                            @else
                                Semua Kategori
                            @endif
                        </span>
                        <i class="bi bi-chevron-down"></i>
                    </button>

                    <ul class="dropdown-menu w-100 p-2 dropdown-checkbox">
                        @foreach($kategoriOptions as $kategori)
                            <li class="px-2">
                                <label class="form-check-label w-100">
                                    <input type="checkbox"
                                        class="form-check-input me-2"
                                        name="kategori[]"
                                        value="{{ $kategori }}"
                                        {{ request('kategori') && in_array($kategori, request('kategori')) ? 'checked' : '' }}>
                                    {{ $kategori }}
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- Checkbox harga murah --}}
            <div class="col-md-3 d-flex gap-2 justify-content-end">
                <div class="form-check me-2">
                    <input class="form-check-input" type="checkbox" id="murah_only"
                        name="murah_only" value="1"
                        {{ request('murah_only') ? 'checked' : '' }}>
                    <label class="form-check-label" for="murah_only" style="font-size: 13px;">
                        Harga ≤ 50.000
                    </label>
                </div>

                <button type="submit" class="btn btn-primary">Terapkan</button>
                <a href="{{ url()->current() }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </div>
    </form>


    @if($books->isEmpty())
        <div class="alert alert-info">
            Belum ada buku yang tersedia.
        </div>
    @endif

    <div class="book-grid">
        @foreach($books as $book)
            <div class="book-card">
                @if($book->gambar)
                    <img src="{{ asset('images/'.$book->gambar) }}" alt="{{ $book->judul }}">
                @else
                    <img src="https://via.placeholder.com/200x210?text=No+Cover" alt="Tanpa Gambar">
                @endif

                <div class="book-card-body">
                    <p class="book-title">{{ $book->judul }}</p>

                    <div class="book-meta">
                        {{ $book->penerbit ?? 'Penerbit tidak diketahui' }} <br>
                        <span class="badge-kategori">
                            {{ $book->kategori ?? 'Tanpa kategori' }}
                        </span>
                    </div>

                    <div class="book-price">
                        Rp {{ number_format($book->harga ?? 0, 0, ',', '.') }}
                    </div>

                    <div class="book-actions">
                        <a href="#"
                           class="btn btn-outline-primary flex-fill">
                            Detail
                        </a>

                        <form action="{{ route('cart.add', $book->id) }}"
                              method="POST"
                              class="flex-fill">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100">
                                + Keranjang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
