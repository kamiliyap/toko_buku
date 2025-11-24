<header id="mainNav" class="main-nav">
    <div class="nav-container">
        <!-- BRAND -->
        <a href="{{ route('home') }}" class="brand d-flex align-items-center">
        </a>
        <!-- NAV LINKS -->
        <nav class="nav-links">
            <a href="/">Home</a>
            <a href="{{ route('buku.index') }}">Daftar Buku</a>
          <a href="{{ route('pembelian.buku_index') }}">pembelian Buku
            </a>
            <a href="#publishers">Penerbit</a>
            <a href="#faq">FAQ</a>
        </nav>

        <!-- ACTIONS -->
        <div class="nav-actions">
            <a href="{{ url('pembelian.php') }}" class="cart">
                🛒 <span>{{ session('cart_count',0) }}</span>
            </a>
            <a href="#shop" class="btn-buy">Belanja Sekarang</a>
            <button id="navToggle" class="hamburger">☰</button>
        </div>
    </div>

    <!-- MOBILE MENU -->
    <div id="mobileMenu" class="mobile-menu">
        <a href="/">Home</a>
        <a href="{{ route('buku.index') }}">Daftar Buku</a>
        <a href="#best-seller">Pembelian Buku</a>
        <a href="#publishers">Penerbit</a>
        <a href="#faq">FAQ</a>
        <a href="#shop" class="btn-buy" style="margin-top:12px">Belanja Sekarang</a>
    </div>
</header>
<script>

  document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('navToggle');
    const menu = document.getElementById('mobileMenu');
    if (!btn || !menu) return;
    btn.addEventListener('click', ()=> {
      const open = menu.classList.toggle('open');
      menu.setAttribute('aria-hidden', open ? 'false' : 'true');
      btn.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
  });
</script>