{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title','Toko Buku Pintar')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap & Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    {{-- Global Styles (navbar + grid buku) --}}
    <style>
    :root{
      --bg: #f4f6ff;       /* pakai warna bg seperti di home */
      --card: #ffffff;
      --muted: #64748b;
      --primary: #2563eb;
      --accent: #1e3a8a;
      --radius: 12px;
    }

    body{ background: var(--bg); }

    /* ================= NAVBAR (SAMA SEPERTI HOME) ================= */
    .main-nav{
      background: #fff;
      border-bottom: 1px solid #e5e7eb;
      box-shadow: 0 3px 12px rgba(0,0,0,.06);
      position: sticky;
      top: 0;
      z-index: 1200;
    }

    .nav-container{
      max-width:1200px;
      margin:auto;
      padding:12px 18px;
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:16px;
    }

    .brand{
      display:flex;
      align-items:center;
      gap:10px;
      text-decoration:none;
    }
    .brand-icon{
      width:44px;
      height:44px;
      border-radius:10px;
      background:linear-gradient(135deg,#1e3a8a,#3b82f6);
      display:inline-block;
    }
    .brand-title{
      font-weight:700;
      color:#0f172a;
      font-size:18px;
    }
    .brand-subtitle{
      font-size:12px;
      color:var(--muted);
      margin-top:2px;
    }

    .nav-links{
      display:flex;
      gap:24px;
      align-items:center;
      flex:1;
      justify-content:center;
    }
    .nav-links a{
      color:#0f172a;
      text-decoration:none;
      font-weight:500;
    }
    .nav-links a.active{
      font-weight:700;
      border-bottom:2px solid var(--primary);
      padding-bottom:2px;
    }

    .nav-actions{
      display:flex;
      gap:14px;
      align-items:center;
    }

    /* search di navbar */
    .nav-search {
      display:inline-flex;
      align-items:center;
      gap:8px;
      margin-right:8px;
    }
    .nav-search-input {
      height:36px;
      padding:6px 12px;
      border-radius:999px;
      border:1px solid rgba(15,23,42,0.06);
      min-width:200px;
      background:#fff;
    }
    .nav-search-btn {
      height:36px;
      padding:0 10px;
      border-radius:999px;
      border:0;
      background:var(--accent);
      color:#fff;
      display:inline-flex;
      align-items:center;
      justify-content:center;
      cursor:pointer;
    }

    .cart{
      background:var(--accent);
      color:#fff;
      padding:8px 12px;
      border-radius:10px;
      text-decoration:none;
      font-weight:700;
      display:inline-flex;
      gap:8px;
      align-items:center;
    }
    .cart span{
      background:#ff3b30;
      color:#fff;
      padding:2px 6px;
      border-radius:999px;
      font-weight:700;
      font-size:12px;
    }

    .btn-buy{
      background:#2563eb;
      color:#fff;
      padding:8px 18px;
      border-radius:50px;
      border:none;
      font-weight:600;
      text-decoration:none;
    }
    .btn-buy:hover{
      background:#1d4ed8;
      color:white;
    }

    .hamburger{
      display:none;
      background:transparent;
      border:0;
      font-size:22px;
      cursor:pointer;
      padding:6px;
      border-radius:8px;
    }

    .mobile-menu{
      display:none;
      position:absolute;
      left:0;
      right:0;
      top:100%;
      background:#fff;
      padding:12px 18px;
      box-shadow:0 14px 40px rgba(11,15,33,0.08);
    }
    .mobile-menu.open{display:flex;flex-direction:column;}
    .mobile-menu a{
      display:block;
      padding:10px 6px;
      border-radius:8px;
      text-decoration:none;
      color:#0f172a;
      font-weight:600;
    }
    .mobile-menu .btn-buy{
      display:block;
      text-align:center;
      margin-top:6px;
    }
    .mobile-search {
      display:flex;
      gap:8px;
      margin-top:8px;
    }
    .mobile-search .nav-search-input { flex:1; }

    /* ================= GRID BUKU & KONTEN LISTING ================= */
    .container-main{
      max-width:1200px;
      margin:22px auto;
      padding:0 18px;
    }
    .page-top{
      display:flex;
      gap:12px;
      align-items:center;
      justify-content:space-between;
      margin-bottom:18px;
    }
    .search-inline{
      max-width:520px;
      display:flex;
      gap:8px;
      align-items:center;
    }
    .input-search{
      padding:8px 12px;
      border-radius:10px;
      border:1px solid rgba(15,23,42,0.06);
      width:100%;
    }

    .card-book{
    border-radius: 10px;
    box-shadow:0 6px 16px rgba(11,15,33,0.06);
    }
    .card-book:hover{
      transform:translateY(-6px);
      box-shadow:0 18px 40px rgba(11,15,33,0.08);
    }
    .card-cover {
    height: 170px;   /* lebih kecil */
    }
    .card-body{
  padding:8px 10px;
    }
    .title-book{
      font-size:14px;
      font-weight:700;
      color:#0f172a;
      margin:0;
      line-height:1.25;
    }
    .meta-book{
      font-size:13px;
      color:var(--muted);
    }
    .price{
      color:var(--primary);
      font-weight:800;
    }
    .card-actions{
      display:flex;
      gap:8px;
      align-items:center;
    }
    .empty-card{
      padding:28px;
      border-radius:12px;
      background:#fff;
      text-align:center;
      color:var(--muted);
    }

    /* ================= RESPONSIVE ================= */
    @media (max-width: 992px){
      .card-cover{height:200px}
      .nav-search-input { min-width:140px; }
    }
    @media (max-width: 768px){
      .nav-links{display:none}
      .hamburger{display:inline-block}
      .nav-actions .btn-buy{display:none}
      .page-top{
        flex-direction:column;
        align-items:stretch;
        gap:12px;
      }
      .search-inline{width:100%}
      .nav-search{display:none}
    }
    <style>
  /* wrapper halaman */
  .beli-wrapper{
    max-width: 1200px;
    margin: 24px auto;
    padding: 0 16px 32px;
  }

  /* kartu buku pembelian */
  .beli-card{
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 8px 24px rgba(15,23,42,0.06);
    height: 50%;
    display: flex;
    flex-direction: column;
  }

  .beli-card-img{
    width: 50%;
    height: 50px;          /* <<< KECILIN DI SINI (boleh 180–220) */
    object-fit: cover;      /* cover biar proporsional */
  }

  .beli-card-body{
    padding: 12px 16px 14px;
    display: flex;
    flex-direction: column;
    gap: 4px;
    flex: 1;
  }

  .beli-title{
    font-size: 14px;
    font-weight: 700;
    margin-bottom: 2px;
  }
  .beli-author{
    font-size: 12px;
    color: #64748b;
  }
  .beli-price{
    font-size: 14px;
    font-weight: 800;
    color: #2563eb;
    margin-top: 6px;
  }

  .beli-card-footer{
    padding: 0 16px 14px 16px;
  }

  .beli-btn{
    width: 100%;
    border-radius: 999px;
    font-size: 14px;
    padding: 8px 0;
  }
    </style>

    {{-- style tambahan per-halaman (home.css dll) --}}
    @yield('styles')
</head>
<body>

    {{-- ================= NAVBAR (SAMA DI SEMUA HALAMAN) ================= --}}
    @php
        $cart = session('cart', []);
        $cartCount = 0;
        foreach ($cart as $item) $cartCount += $item['qty'];
    @endphp

    <nav class="main-nav">
      <div class="nav-container">

        {{-- Brand / Logo --}}
        <a href="{{ route('home') }}" class="brand">
          <span class="brand-icon"></span>
          <span class="brand-title">Toko Buku Pintar</span>
        </a>

        {{-- MENU DESKTOP --}}
        <div class="nav-links">
        <a href="{{ route('home') }}" 
            class="{{ request()->routeIs('home') ? 'active' : '' }}">
            Beranda
        </a>

        <a href="{{ route('user.buku.index') }}" 
            class="{{ request()->routeIs('buku.*') ? 'active' : '' }}">
            Daftar Buku
        </a>

        {{-- MENU PEMBELIAN UNTUK USER --}}
        <a href="{{ route('pembelian.buku_index') }}" 
            class="{{ request()->routeIs('pembelian.*') ? 'active' : '' }}">
            Pembelian
        </a>
        </div>
        {{-- ACTIONS --}}
        <div class="nav-actions">

          <form class="nav-search" method="GET" action="{{ route('buku.index') }}">
            <input 
              type="search" 
              name="q" 
              value="{{ request('q') }}" 
              class="nav-search-input" 
              placeholder="Cari buku..." 
            >
            <button class="nav-search-btn" type="submit">
              <i class="bi bi-search"></i>
            </button>
          </form>

          <a href="{{ route('cart.index') }}" class="cart">
            <i class="bi bi-cart"></i>
            <span>{{ $cartCount }}</span>
          </a>
          <button id="navToggle" class="hamburger" aria-label="Menu" aria-expanded="false">
            ☰
          </button>
        </div>
      </div>

      {{-- MENU MOBILE --}}
        <div id="mobileMenu" class="mobile-menu" aria-hidden="true">
        <a href="{{ route('home') }}">Beranda</a>
        <a href="{{ route('buku.index') }}">Daftar Buku</a>

        {{-- LINK PEMBELIAN DI MOBILE --}}
        <a href="{{ route('pembelian.buku_index') }}">Pembelian</a>

        <a href="{{ route('cart.index') }}" class="cart mt-2">
            <i class="bi bi-cart"></i>
            <span>{{ $cartCount }}</span>
        </a>

        <form class="mobile-search mt-2" method="GET" action="{{ route('buku.index') }}">
          <input 
            type="search" 
            name="q" 
            value="{{ request('q') }}" 
            class="nav-search-input" 
            placeholder="Cari buku..."
          >
          <button class="nav-search-btn" type="submit">
            <i class="bi bi-search"></i>
          </button>
        </form>
      </div>
    </nav>
     {{-- GRID 3 KOLOM --}}
<div class="row g-4">
    @foreach ($bukus as $b)
    <div class="col-6 col-md-3 col-lg-3">
        <div class="card-book shadow-sm">

            {{-- COVER --}}
            @php
                // Ambil nama file dari database (hilangkan folder lamanya)
                $imgFile = basename($b->gambar ?? '');

                // Path final ke folder baru di public/images/buku
                $imgUrl = $imgFile
                    ? asset('images/buku/' . $imgFile)
                    : asset('images/no-cover.png');
            @endphp

            <img src="{{ $imgUrl }}"
                 alt="Cover {{ $b->judul }}"
                 class="card-cover">

            {{-- BODY --}}
            <div class="card-body">
                <h5 class="title-book">{{ $b->judul }}</h5>
                <p class="meta-book mb-1">{{ $b->penulis }}</p>
                <p class="price">Rp {{ number_format($b->harga, 0, ',', '.') }}</p>

                {{-- ACTION --}}
                <form action="{{ route('cart.add', $b->id) }}" method="POST">
                    @csrf
                    <button class="btn btn-primary w-100 mt-2">
                        <i class="bi bi-cart-plus"></i> Tambah ke Keranjang
                    </button>
                </form>
            </div>

        </div>
    </div>
    @endforeach
</div>


    {{-- KOSONG --}}
    @if ($bukus->isEmpty())
        <div class="empty-card mt-4">
            Tidak ada buku ditemukan.
        </div>
    @endif
</div>
    {{-- ================= KONTEN HALAMAN ================= --}}
    <main>
        @yield('content')
    </main>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Script toggle navbar mobile --}}
    <script>
    document.addEventListener('DOMContentLoaded', function () {
      const btn = document.getElementById('navToggle');
      const menu = document.getElementById('mobileMenu');

      if (!btn || !menu) return;

      function toggleMenu(open) {
        const isOpen = typeof open === 'boolean'
            ? open
            : !menu.classList.contains('open');

        if (isOpen) {
          menu.classList.add('open');
          menu.setAttribute('aria-hidden','false');
          btn.setAttribute('aria-expanded','true');
        } else {
          menu.classList.remove('open');
          menu.setAttribute('aria-hidden','true');
          btn.setAttribute('aria-expanded','false');
        }
      }

      btn.addEventListener('click', function(e){
        e.stopPropagation();
        toggleMenu();
      });

      document.addEventListener('click', function(e){
        if (!menu.classList.contains('open')) return;
        if (!menu.contains(e.target) && e.target !== btn) toggleMenu(false);
      });

      document.addEventListener('keydown', function(e){
        if (e.key === 'Escape') toggleMenu(false);
      });
    });
    </script>

    @yield('scripts')
</body>
</html>
