@extends('layouts.app')
@section('title','Daftar Buku')

{{-- Styles: Bootstrap + custom modern CSS --}}
@section('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
:root{
  --bg: #f8fafc;
  --card: #ffffff;
  --muted: #64748b;
  --primary: #2563eb;
  --accent: #1e3a8a;
  --radius: 12px;
}

/* ---------- NAVBAR (modern) ---------- */
/* header element styles (desktop + mobile) */
.main-nav{
  background: linear-gradient(180deg, #eef2ff, var(--bg));
  box-shadow: 0 4px 18px rgba(11, 15, 33, 0.06);
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
  gap:16px;
  justify-content:space-between;
}
.brand{display:flex;align-items:center;gap:10px;text-decoration:none}
.brand-icon{width:44px;height:44px;border-radius:10px;background:linear-gradient(135deg,#1e3a8a,#3b82f6);display:inline-block}
.brand-title{font-weight:700;color:#0f172a;font-size:18px}
.nav-links{display:flex;gap:12px;align-items:center;flex:1;justify-content:center}
.nav-links a{color:#0f172a;text-decoration:none;padding:8px 12px;border-radius:10px;font-weight:600;transition:all .15s}
.nav-links a.active, .nav-links a:hover{background:#fff;border:1px solid rgba(15,23,42,0.04);box-shadow:0 6px 18px rgba(11,15,33,0.03)}
.nav-actions{display:flex;gap:12px;align-items:center}
.cart{background:var(--accent);color:#fff;padding:8px 12px;border-radius:10px;text-decoration:none;font-weight:700;display:inline-flex;gap:8px;align-items:center}
.cart span{background:#ff3b30;color:#fff;padding:2px 6px;border-radius:999px;font-weight:700;font-size:12px}
.btn-buy{background:var(--primary);color:#fff;padding:8px 14px;border-radius:10px;text-decoration:none;font-weight:700;border:none}
.hamburger{display:none;background:transparent;border:0;font-size:22px;cursor:pointer;padding:6px;border-radius:8px}

/* search in navbar */
.nav-search { display:inline-flex; align-items:center; gap:8px; margin-right:8px; }
.nav-search-input {
  height:36px; padding:6px 12px; border-radius:999px; border:1px solid rgba(15,23,42,0.06);
  min-width:200px; background:#fff;
}
.nav-search-btn {
  height:36px; padding:0 10px; border-radius:999px; border:0; background:var(--accent); color:#fff;
  display:inline-flex; align-items:center; justify-content:center; cursor:pointer;
}

/* ---------- MOBILE MENU (overlay) ---------- */
.mobile-menu{display:none;position:absolute;left:0;right:0;top:100%;background:#fff;padding:12px 18px;box-shadow:0 14px 40px rgba(11,15,33,0.08)}
.mobile-menu.open{display:block}
.mobile-menu a{display:block;padding:10px 6px;border-radius:8px;text-decoration:none;color:#0f172a;font-weight:600}
.mobile-menu .btn-buy{display:block;text-align:center;margin-top:6px}
.mobile-search { display:flex; gap:8px; margin-top:8px; }
.mobile-search .nav-search-input { flex:1; }

/* ---------- Page content ---------- */
.container-main{max-width:1200px;margin:22px auto;padding:0 18px}

/* Header row */
.page-top{display:flex;gap:12px;align-items:center;justify-content:space-between;margin-bottom:18px}
.search-inline{max-width:520px;display:flex;gap:8px;align-items:center}
.input-search{padding:8px 12px;border-radius:10px;border:1px solid rgba(15,23,42,0.06);width:100%}

/* Grid cards */
.card-book{
  border-radius: var(--radius);
  overflow:hidden;
  background:var(--card);
  transition: transform .18s cubic-bezier(.2,.9,.2,1), box-shadow .18s;
  height:100%;
  display:flex;
  flex-direction:column;
}
.card-book:hover{transform:translateY(-6px);box-shadow:0 18px 40px rgba(11,15,33,0.08)}
.card-cover{
  width:100%;
  height:230px;
  object-fit:cover;
  background:linear-gradient(180deg,#f8fafc,#fff);
}
.card-body {
  padding:12px;
  display:flex;
  flex-direction:column;
  gap:8px;
  flex:1;
}
.title-book{font-size:14px;font-weight:700;color:#0f172a;margin:0;line-height:1.25}
.meta-book{font-size:13px;color:var(--muted)}
.price{color:var(--primary);font-weight:800}

/* actions row inside card */
.card-actions{display:flex;gap:8px;align-items:center}

/* empty state */
.empty-card{padding:28px;border-radius:12px;background:#fff;text-align:center;color:var(--muted)}

/* responsive */
@media (max-width: 992px){
  .card-cover{height:200px}
  .nav-search-input { min-width:140px; }
}
@media (max-width: 768px){
  .nav-links{display:none}
  .hamburger{display:inline-block}
  .nav-actions .btn-buy{display:none}
  .page-top{flex-direction:column;align-items:stretch;gap:12px}
  .search-inline{width:100%}
  .nav-search{display:none}
  .mobile-menu{display:none}
  .mobile-menu.open{display:flex}
}

/* Matikan tombol panah besar (hanya slider controls) */
.swiper-button-next,
.swiper-button-prev,
.arrow,
.slider-arrow {
    display: none !important;
    opacity: 0 !important;
    visibility: hidden !important;
    pointer-events: none !important;
}

/* Jangan set font-size:0 ke semua button (sebelumnya bermasalah).
   Jika ingin target slider saja, gunakan selektor di atas (swiper-button-*) */
 
/* Fix Laravel pagination SVG arrows */
svg.w-5.h-5,
.pagination svg {
    width: 18px !important;
    height: 18px !important;
    margin: 0 !important;
    padding: 0 !important;
}
svg.w-5.h-5 path,
.pagination svg path {
    fill: var(--primary) !important;
}

/* Pagination: make Bootstrap pagination look neat and centered */
.mt-4.d-flex.justify-content-center nav[role="navigation"] {
  display: block;
  text-align: center;
}

/* target .pagination container */
.pagination {
  display: inline-flex;
  gap: 8px;
  padding-left: 0;
  margin: 12px 0;
  border-radius: 8px;
  list-style: none;
  align-items: center;
}

/* individual page items */
.pagination .page-item { margin: 0; }

/* links */
.pagination .page-link {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  min-width: 42px;
  height: 38px;
  padding: 0 12px;
  border-radius: 8px;
  border: 1px solid rgba(15,23,42,0.06);
  color: #2563eb; /* primary */
  background: #fff;
  font-weight: 600;
}

/* active page */
.pagination .page-item.active .page-link {
  background: #2563eb;
  color: #fff;
  border-color: #2563eb;
  box-shadow: 0 6px 18px rgba(37,99,235,0.12);
}

/* prev/next small chevrons */
.pagination .page-link svg,
.pagination svg.w-5.h-5 {
  width: 18px !important;
  height: 18px !important;
  flex-shrink: 0 !important;
  margin: 0;
  vertical-align: middle;
  color: #2563eb;
}

/* disabled */
.pagination .page-item.disabled .page-link {
  opacity: 0.55;
  pointer-events: none;
  background: #fff;
}

/* responsive: make page links wrap on narrow screens */
@media (max-width:520px) {
  .pagination { gap: 6px; }
  .pagination .page-link { min-width: 36px; height:36px; padding: 0 8px; font-size: 14px; }
}

/* search-inline button fix (past issue: buttons shrinked) */
.search-inline button,
.nav-search-btn {
    font-size: 14px !important;
    padding: 8px 14px !important;
    border-radius: 10px !important;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.search-inline button i {
    font-size: 18px !important;
}
</style>
@endsection

@section('content')
{{-- NAVBAR MANUAL (modern) --}}

{{-- MAIN CONTENT --}}
<div class="container-main">
  <div class="page-top">
    <h3 class="mb-0">Daftar Buku</h3>

    <form class="search-inline" method="GET" action="{{ route('buku.index') }}" aria-label="Pencarian buku">
      <input type="search" name="q" value="{{ $q ?? '' }}" class="input-search" placeholder="Cari judul, penulis, kategori" />
      <button class="btn btn-primary" type="submit" aria-label="Cari"><i class="bi bi-search" aria-hidden="true"></i>🔎</button>
    </form>
  </div>

  @php
    $localFallback = '/mnt/data/bad049ad-932f-40f2-82d2-4d055111cf94.png';
  @endphp

  @if($buku->count())
    <div class="row g-3">
      @foreach($buku as $b)
        <div class="col-6 col-md-4 col-lg-3">
          <article class="card-book shadow-sm" aria-labelledby="b{{ $b->id }}">
            <img
              src="{{ $b->gambar ? secure_asset('storage/' . ltrim($b->gambar,'/')) : secure_asset('assets/img/no-cover.png') }}"
              onerror="this.onerror=null;this.src='{{ $localFallback }}';"
              alt="Cover {{ $b->judul }}"
              class="card-cover"
            >

            <div class="card-body">
              <h4 id="b{{ $b->id }}" class="title-book">{{ \Illuminate\Support\Str::limit($b->judul, 80) }}</h4>

              <div class="meta-book">
                {{ $b->penulis }} @if(!empty($b->kategori)) — {{ $b->kategori }} @endif
              </div>

              <div class="mt-auto d-flex justify-content-between align-items-center">
                <div class="price">Rp {{ number_format($b->harga ?? 0,0,',','.') }}</div>

                <div class="card-actions">
                  <a href="{{ route('buku.show',$b->id) }}" class="btn btn-outline-primary btn-sm">Detail</a>
                  <!-- <a href="{{ route('buku.edit',$b->id) }}" class="btn btn-warning btn-sm">Edit</a> -->
                </div>
              </div>
            </div>
          </article>
        </div>
      @endforeach
    </div>

    <div class="mt-4 d-flex justify-content-center">
      {{ $buku->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
  @else
    <div class="empty-card">
      <p class="mb-2">Belum ada buku.</p>
      <a href="{{ route('buku.create') }}" class="btn btn-primary">Tambah buku baru</a>
    </div>
  @endif
</div>
@endsection

{{-- Scripts: mobile menu toggle & accessibility --}}
@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  const btn = document.getElementById('navToggle');
  const menu = document.getElementById('mobileMenu');

  if (!btn || !menu) return;

  function toggleMenu(open) {
    const isOpen = typeof open === 'boolean' ? open : !menu.classList.contains('open');
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

  // close on outside click
  document.addEventListener('click', function(e){
    if (!menu.classList.contains('open')) return;
    if (!menu.contains(e.target) && e.target !== btn) toggleMenu(false);
  });

  // close on ESC
  document.addEventListener('keydown', function(e){
    if (e.key === 'Escape') toggleMenu(false);
  });
});
</script>
@endsection
