@extends('layouts.app')
@section('title','Daftar Buku')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
/* ==== (CSS MU TETAP — tidak aku ubah) ==== */
:root{
  --bg: #f8fafc;
  --card: #ffffff;
  --muted: #64748b;
  --primary: #2563eb;
  --accent: #1e3a8a;
  --radius: 12px;
}
.card-book{
  border-radius: var(--radius);
  overflow:hidden;
  background:var(--card);
  height:100%;
  display:flex;
  flex-direction:column;
  transition:.2s;
}
.card-book:hover{transform:translateY(-6px);box-shadow:0 18px 40px rgba(11,15,33,0.08);}
.card-cover{width:100%;height:230px;object-fit:cover;}
.meta-book{font-size:13px;color:#64748b;}
.price{color:var(--primary);font-weight:800;}
.empty-card{text-align:center;padding:25px;color:#64748b;}
</style>
@endsection


@section('content')

<div class="container-main">

    <div class="page-top">
        <h3 class="mb-0">Daftar Buku</h3>

        <form class="search-inline" method="GET" action="{{ route('buku.index') }}">
            <input type="search" name="q" value="{{ $q ?? '' }}" class="input-search"
                   placeholder="Cari judul, penulis, kategori">
            <button class="btn btn-primary" type="submit">🔎</button>
        </form>
    </div>

    {{-- ======================= DATA ADA ======================= --}}
    @if($buku->count())
    <div class="row g-3">
        @foreach($buku as $b)
        <div class="col-6 col-md-4 col-lg-3">
            <article class="card-book shadow-sm">

                @php
                    // Ambil nama file asli
                    $img = $b->gambar ? basename($b->gambar) : null;

                    // Path final
                    $imgUrl = $img
                        ? secure_asset('images/' . $img)
                        : secure_asset('images/no-cover.png');

                    $fallback = secure_asset('images/no-cover.png');
                @endphp

                <img src="{{ $imgUrl }}"
                     onerror="this.onerror=null;this.src='{{ $fallback }}';"
                     alt="{{ $b->judul }}"
                     class="card-cover">

                <div class="card-body">
                    <h4 class="title-book">{{ \Illuminate\Support\Str::limit($b->judul, 70) }}</h4>

                    <div class="meta-book">
                        {{ $b->penulis }}
                        @if($b->kategori)
                            — {{ $b->kategori }}
                        @endif
                    </div>

                    <div class="mt-auto d-flex justify-content-between align-items-center">
                        <div class="price">
                            Rp {{ number_format($b->harga ?? 0, 0, ',', '.') }}
                        </div>
                        <a href="{{ route('buku.show', $b->id) }}" class="btn btn-outline-primary btn-sm">
                            Detail
                        </a>
                    </div>
                </div>

            </article>
        </div>
        @endforeach
    </div>

    {{-- PAGINATION --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $buku->withQueryString()->links('pagination::bootstrap-5') }}
    </div>

    {{-- ======================= TIDAK ADA DATA ======================= --}}
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
