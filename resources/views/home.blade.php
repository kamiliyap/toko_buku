{{-- resources/views/home.blade.php --}}
@extends('layouts.user')


@section('title', 'Toko Buku Pintar')
@section('styles')
    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Home CSS -->
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">

    <!-- NAVBAR CUSTOM CSS -->

@endsection


@section('content')
<!-- ================= Welcome Rotator (letakkan di atas poster / hero) ================= -->
<!-- === RUNNING TEXT / MARQUEE === -->
<div class="running-banner">
    <div class="running-track" id="runningTrack">
        ⭐ Selamat datang di Toko Buku — Temukan bacaan terbaik setiap hari!  
        ⭐ Cek promo terbaru dan diskon menarik minggu ini!  
        ⭐ Rekomendasi buku pendidikan & literatur tersedia lengkap!
    </div>
</div>

<!-- Poster carousel -->
<div class="poster-carousel fade-in delay-2" aria-hidden="true">
  <div class="poster-slides">
    @forelse($posterFiles as $p)
      <div class="poster-slide">
        <img src="{{ asset('storage/' . $p) }}" alt="Poster" />
      </div>
    @empty
      <div class="poster-slide">
        <img src="{{ asset('storage/poster/poster.png') }}" alt="Poster default" />
      </div>
    @endforelse
  </div>
  <div class="poster-controls">
    <button class="prev" aria-label="Prev">‹</button>
    <button class="next" aria-label="Next">›</button>
  </div>
</div>

<!-- MAIN WRAPPER: gunakan class agar CSS tidak terganggu bootstrap -->
<main class="home-wrapper">
  {{-- HERO --}}
  <section class="hero">
    <div class="hero-card fade-in delay-1">
      <div class="eyebrow">Selamat datang di</div>
      <h1>Perpustakaan digital & toko buku lokal yang ramah</h1>
      <p class="lead">Kurasi buku best seller, rekomendasi personal, dan penawaran dari penerbit terpercaya — semua dikemas rapi supaya mudah dicari.</p>

      <div class="hero-ctas">
        <a class="btn" href="#best-seller">Lihat Best Seller</a>
        <a class="btn outline" href="#publishers">Penerbit</a>
      </div>

      <div style="margin-top:18px;color:#6b7280;font-size:14px">
        Pilihan kategori:
        <strong style="color:var(--primary)">Fiksi</strong> · Nonfiksi · Anak · Pendidikan
      </div>
    </div>

    <!-- <div class="book-wrap fade-in delay-2" aria-hidden="true">
      <div class="book" role="img" aria-label="Ilustrasi buku terbaik kami">
        <h3>100 Cara Menjadi Pembaca Hebat</h3>
      </div>
    </div> -->
  </section>

  {{-- BEST SELLER --}}
  <section id="best-seller" class="section">
    <div style="display:flex;justify-content:space-between;align-items:end;margin-bottom:14px">
      <div>
        <h2 style="margin:0">Buku Best Seller</h2>
        <div style="color:var(--muted);font-size:14px">Pilihan berdasarkan penjualan & rating</div>
      </div>

      <div style="color:var(--muted);font-size:14px">
        Filter:
        <select aria-label="Filter kategori" id="filter-kategori">
          <option value="">Semua</option>
        </select>
      </div>
    </div>

    <div class="grid" id="books-grid">
      @forelse($books as $b)
        <article class="card fade-in" tabindex="0" aria-labelledby="b{{ $b->id }}">
          <div class="cover">
            @if($b->gambar)
              <img src="{{ asset('storage/' . ltrim($b->gambar, '/')) }}" alt="Cover {{ $b->judul }}" style="width:100%;height:100%;object-fit:cover">
            @else
              <img src="https://via.placeholder.com/150x220?text=No+Cover" alt="No Cover">
            @endif
          </div>

          <div class="title" id="b{{ $b->id }}">{{ $b->judul }}</div>
          <div class="author">{{ $b->penulis }}</div>
          <div class="price">Rp {{ number_format($b->harga ?? 0, 0, ',', '.') }}</div>
        </article>
      @empty
        <p>Tidak ada buku untuk ditampilkan.</p>
      @endforelse
    </div>
  </section>

  {{-- PENERBIT --}}
<!-- Penerbit (Slider) -->
<section id="publishers" class="section">
  <h2>Penerbit yang hadir</h2>
  <div style="color:var(--muted);margin-bottom:12px">Kerja sama dengan penerbit lokal dan nasional</div>

  <div class="publisher-slider" aria-label="Slider logo penerbit" id="pubSlider">
    <div class="slider-track">
      @foreach($publishers as $p)
        {{-- pastikan $p['logo'] berisi URL; jika ada kemungkinan masih ui-avatars, bisa skip --}}
        <div class="slide">
          <img
            src="{{ $p['logo'] }}"
            alt="Logo {{ $p['name'] }}"
            class="slide-logo"
            loading="lazy"
            onerror="this.onerror=null;this.src='/mnt/data/656ad747-c57a-466e-8292-386cad4a5966.png';"
          >
        </div>
      @endforeach
    </div>
</section>


  {{-- FAQ --}}
  <section id="faq" class="section">
    <h2>FAQ</h2>
    <div class="faq">
      @foreach($faqs as $f)
        <div class="qa fade-in">
          <div class="q" data-open="false">
            <div><strong>{{ $f['q'] }}</strong></div>
            <button aria-expanded="false" class="toggle">+</button>
          </div>
          <div class="a" style="display:none">{{ $f['a'] }}</div>
        </div>
      @endforeach
    </div>
  </section>

</main>

<footer>
  <div class="ft-grid">
    <div>
      <div style="font-weight:700">Toko Buku Pintar</div>
      <div style="color:var(--muted);margin-top:8px">Alamat kantor pusat • Email: halo@tokobukupintar.id</div>
      <div style="margin-top:14px" class="socials">
        <a href="#" aria-label="Instagram">IG</a>
        <a href="#" aria-label="Facebook">FB</a>
        <a href="#" aria-label="Twitter">TW</a>
      </div>
    </div>

    <div>
      <div style="font-weight:700;margin-bottom:8px">Langganan</div>
      <form onsubmit="event.preventDefault();alert('Terima kasih, kamu telah berlangganan!')">
        <label style="display:block;font-size:13px;color:var(--muted)" for="email">Dapatkan update & promo</label>
        <div style="display:flex;gap:8px;margin-top:8px">
          <input id="email" type="email" required placeholder="email@contoh.com" style="padding:10px;border-radius:10px;border:1px solid rgba(15,20,36,0.06);flex:1">
          <button class="btn">Daftar</button>
        </div>
      </form>
    </div>
  </div>
</footer>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  // ---------- FAQ accordion ----------
  document.querySelectorAll('.q').forEach(q => {
    q.addEventListener('click', () => {
      const qa = q.parentElement;
      const a = qa.querySelector('.a');
      const btn = q.querySelector('.toggle');
      const open = q.getAttribute('data-open') === 'true';
      if (open) {
        a.style.display = 'none';
        q.setAttribute('data-open','false');
        btn.textContent = '+';
        btn.setAttribute('aria-expanded','false');
      } else {
        a.style.display = 'block';
        q.setAttribute('data-open','true');
        btn.textContent = '−';
        btn.setAttribute('aria-expanded','true');
      }
    });
  });

  // ---------- Appear animation (IntersectionObserver) ----------
  if ('IntersectionObserver' in window) {
    const io = new IntersectionObserver((entries)=>{
      entries.forEach(e=>{
        if(e.isIntersecting) e.target.classList.add('visible');
      });
    },{threshold:0.12});
    document.querySelectorAll('.fade-in').forEach(el=> io.observe(el));
  } else {
    document.querySelectorAll('.fade-in').forEach(el=> el.classList.add('visible'));
  }

  // ---------- Poster carousel (robust) ----------
  (function(){
    const carousel = document.querySelector('.poster-carousel');
    const slides = carousel ? carousel.querySelector('.poster-slides') : null;
    if(!carousel || !slides) return;

    const slideEls = Array.from(slides.querySelectorAll('.poster-slide'));
    const total = slideEls.length;
    if(total === 0) return;

    // ensure layout: each slide fixed to 100% width
    slideEls.forEach(s => {
      s.style.flex = '0 0 100%';
      s.style.maxWidth = '100%';
    });

    slides.style.display = 'flex';
    slides.style.transition = 'transform 0.6s ease-in-out';

    const prevBtn = carousel.querySelector('.poster-controls .prev');
    const nextBtn = carousel.querySelector('.poster-controls .next');

    let idx = 0, timer = null;
    const INTERVAL = 3500;

    function update() {
      slides.style.transform = `translateX(-${idx * 100}%)`;
    }
    function next() { idx = (idx + 1) % total; update(); }
    function prev() { idx = (idx - 1 + total) % total; update(); }
    function start() { stop(); timer = setInterval(next, INTERVAL); }
    function stop() { if(timer){ clearInterval(timer); timer = null; } }

    if(nextBtn) nextBtn.addEventListener('click', ()=> { stop(); next(); start(); });
    if(prevBtn) prevBtn.addEventListener('click', ()=> { stop(); prev(); start(); });

    carousel.addEventListener('mouseenter', stop);
    carousel.addEventListener('mouseleave', start);

    // init
    update();
    start();
  })();

  // ---------- Client filter (kategori) ----------
  const filterSelect = document.getElementById('filter-kategori');
  if(filterSelect) {
    filterSelect.addEventListener('change', function(){
      const val = this.value.trim().toLowerCase();
      document.querySelectorAll('#books-grid .card').forEach(card=>{
        const kategori = (card.querySelector('.author')?.textContent || '').toLowerCase();
        if(!val || (kategori && kategori.includes(val))) card.style.display='';
        else card.style.display='none';
      });
    });
  }

  // ---------- Optional: running marquee fallback JS (if you used wrText rotator) ----------
  // If you implemented the wrText rotator earlier, make sure those elements exist before using them.
  // (Not required if you are using purely CSS marquee .running-track)
});

document.addEventListener('DOMContentLoaded', function () {
    const burger = document.querySelector('.hamburger');
    const mobileMenu = document.querySelector('.mobile-menu');

    // kalau elemen nggak ketemu, jangan apa-apa
    if (!burger || !mobileMenu) return;

    burger.addEventListener('click', function () {
        mobileMenu.classList.toggle('is-open');
    });
});


</script>
@endsection
