@extends('layouts.user')

@section('title', 'Pembelian Buku')
@section('nav_search_action', route('pembelian.buku_index'))

@section('styles')
<style>
    .purchase-shell {
        max-width: 1240px;
        margin: 0 auto;
        padding: 28px 20px 44px;
    }

    .purchase-hero {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: 26px 28px;
        border-radius: 24px;
        background:
            radial-gradient(circle at top left, rgba(255, 255, 255, 0.26), transparent 38%),
            linear-gradient(135deg, #4f46e5, #2563eb 55%, #06b6d4);
        color: #fff;
        box-shadow: 0 18px 48px rgba(79, 70, 229, 0.22);
        margin-bottom: 24px;
    }

    .purchase-hero h1 {
        margin: 0 0 8px;
        font-size: clamp(1.8rem, 3vw, 2.4rem);
        font-weight: 800;
    }

    .purchase-hero p {
        margin: 0;
        max-width: 680px;
        color: rgba(255, 255, 255, 0.86);
    }

    .purchase-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        font-size: 0.76rem;
        font-weight: 700;
        color: rgba(255, 255, 255, 0.8);
    }

    .purchase-stats {
        min-width: 220px;
        display: grid;
        gap: 14px;
    }

    .purchase-stat-card {
        padding: 16px 18px;
        border-radius: 18px;
        background: rgba(255, 255, 255, 0.14);
        border: 1px solid rgba(255, 255, 255, 0.18);
        backdrop-filter: blur(8px);
    }

    .purchase-stat-card strong {
        display: block;
        font-size: 1.7rem;
        line-height: 1;
        margin-bottom: 6px;
    }

    .purchase-stat-card span {
        color: rgba(255, 255, 255, 0.84);
    }

    .purchase-feedback {
        margin-bottom: 18px;
    }

    .search-result-banner {
        margin-bottom: 18px;
        padding: 14px 16px;
        border-radius: 16px;
        background: #e0f2fe;
        color: #0f172a;
        border: 1px solid #bae6fd;
    }

    .purchase-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 22px;
    }

    .purchase-card {
        background: #fff;
        border: 0;
        border-radius: 22px;
        overflow: hidden;
        box-shadow: 0 14px 36px rgba(15, 23, 42, 0.08);
        display: flex;
        flex-direction: column;
        height: 100%;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .purchase-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 22px 50px rgba(15, 23, 42, 0.14);
    }

    .purchase-cover-wrap {
        background:
            radial-gradient(circle at top left, rgba(96, 165, 250, 0.16), transparent 42%),
            linear-gradient(180deg, #f8fafc, #eef2ff);
        padding: 18px;
    }

    .purchase-cover {
        width: 100%;
        height: 250px;
        object-fit: contain;
        border-radius: 16px;
        background: #fff;
    }

    .purchase-body {
        display: flex;
        flex-direction: column;
        gap: 8px;
        padding: 18px 18px 20px;
        flex: 1;
    }

    .purchase-title {
        margin: 0;
        font-size: 1rem;
        font-weight: 700;
        line-height: 1.4;
        color: #0f172a;
    }

    .purchase-author,
    .purchase-publisher {
        margin: 0;
        color: #64748b;
        font-size: 0.92rem;
    }

    .purchase-price {
        margin-top: auto;
        font-size: 1.3rem;
        font-weight: 800;
        color: #2563eb;
    }

    .purchase-stock {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        width: fit-content;
        padding: 6px 10px;
        border-radius: 999px;
        font-size: 0.84rem;
        font-weight: 700;
        background: #dcfce7;
        color: #166534;
    }

    .purchase-stock.out {
        background: #fee2e2;
        color: #b91c1c;
    }

    .purchase-card form {
        margin-top: 8px;
    }

    .purchase-btn {
        width: 100%;
        padding: 12px 16px;
        border: 0;
        border-radius: 14px;
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: #fff;
        font-weight: 700;
        box-shadow: 0 10px 24px rgba(37, 99, 235, 0.2);
    }

    .purchase-empty {
        padding: 44px 24px;
        border-radius: 22px;
        text-align: center;
        background: #fff;
        box-shadow: 0 14px 36px rgba(15, 23, 42, 0.08);
    }

    @media (max-width: 992px) {
        .purchase-hero {
            flex-direction: column;
            align-items: flex-start;
        }

        .purchase-stats {
            width: 100%;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        }
    }

    @media (max-width: 640px) {
        .purchase-shell {
            padding: 22px 16px 36px;
        }

        .purchase-hero {
            padding: 22px 20px;
            border-radius: 20px;
        }

        .purchase-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .purchase-cover {
            height: 190px;
        }
    }

    @media (max-width: 480px) {
        .purchase-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<div class="purchase-shell">
    <div class="purchase-hero">
        <div>
            <div class="purchase-eyebrow">
                <i class="bi bi-bag-check"></i>
                Halaman Pembelian
            </div>
            <h1>Belanja buku dengan navbar yang sama seperti beranda</h1>
            <p>
                Pencarian buku dan akses keranjang sekarang sudah menyatu di navbar utama, jadi alurnya konsisten
                dari beranda sampai checkout.
            </p>
        </div>

        <div class="purchase-stats">
            <div class="purchase-stat-card">
                <strong>{{ $bukus->count() }}</strong>
                <span>Buku siap dibeli</span>
            </div>
            <div class="purchase-stat-card">
                <strong>{{ collect(session('cart', []))->sum('qty') }}</strong>
                <span>Item di keranjang</span>
            </div>
        </div>
    </div>

    <div class="purchase-feedback">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
    </div>

    @if (request('q'))
        <div class="search-result-banner">
            Hasil pencarian untuk <strong>"{{ request('q') }}"</strong>.
        </div>
    @endif

    @if ($bukus->isEmpty())
        <div class="purchase-empty">
            <h3 class="fw-bold mb-2">Buku yang kamu cari belum ditemukan</h3>
            <p class="text-muted mb-4">Coba kata kunci lain atau kembali lihat semua koleksi pembelian.</p>
            <a href="{{ route('pembelian.buku_index') }}" class="btn btn-primary px-4">Lihat semua buku</a>
        </div>
    @else
        <div class="purchase-grid">
            @foreach ($bukus as $b)
                @php
                    $imgFile = basename($b->gambar ?? '');
                    $coverUrl = $imgFile ? asset('images/buku/' . $imgFile) : asset('images/no-cover.png');
                    $fallback = asset('images/no-cover.png');
                @endphp

                <article class="purchase-card">
                    <div class="purchase-cover-wrap">
                        <img
                            src="{{ $coverUrl }}"
                            alt="Cover {{ $b->judul }}"
                            class="purchase-cover"
                            onerror="this.onerror=null;this.src='{{ $fallback }}';"
                        >
                    </div>

                    <div class="purchase-body">
                        <h2 class="purchase-title">{{ $b->judul }}</h2>
                        <p class="purchase-author">{{ $b->penulis ?: 'Penulis belum tersedia' }}</p>
                        <p class="purchase-publisher">{{ $b->penerbit ?: 'Penerbit belum tersedia' }}</p>
                        <div class="purchase-price">Rp {{ number_format($b->harga ?? 0, 0, ',', '.') }}</div>
                        <div class="purchase-stock {{ ($b->stok ?? 0) < 1 ? 'out' : '' }}">
                            <i class="bi {{ ($b->stok ?? 0) < 1 ? 'bi-x-circle' : 'bi-check-circle' }}"></i>
                            {{ ($b->stok ?? 0) < 1 ? 'Stok habis' : 'Stok tersedia: ' . ($b->stok ?? 0) }}
                        </div>

                        <form action="{{ route('cart.add', $b->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="purchase-btn" {{ ($b->stok ?? 0) < 1 ? 'disabled' : '' }}>
                                <i class="bi bi-cart-plus"></i>
                                {{ ($b->stok ?? 0) < 1 ? 'Stok Habis' : 'Tambah ke Keranjang' }}
                            </button>
                        </form>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
</div>
@endsection
