{{-- resources/views/layouts/user.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Toko Buku - User')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons (opsional) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    {{-- CSS Global User --}}
    <style>
        :root {
        --primary: #5b21b6;         /* ungu deep */
        --primary-light: #7c3aed;   /* ungu terang */
        --accent: #06b6d4;          /* cyan */
        --bg: #f3f4f6;
        --text: #1f2937;
        --muted: #6b7280;
    }

    /* NAVBAR WRAPPER */
    .navbar-modern {
        background: linear-gradient(90deg, var(--primary), var(--accent));
        position: sticky;
        top: 0;
        width: 100%;
        z-index: 2000;
        box-shadow: 0 2px 12px rgba(0,0,0,0.1);
    }

    /* CONTAINER */
    .nm-container {
        max-width: 1200px;
        margin: auto;
        padding: 12px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    /* LOGO */
    .nm-brand {
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
        color: white;
    }

    .nm-logo {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        background: white;
        opacity: 0.9;
    }

    .nm-title span {
        display: block;
        font-size: 11px;
        color: #e5e7eb;
    }

    /* MENU DESKTOP */
    .nm-links {
        display: flex;
        gap: 20px;
    }

    .nm-link {
        color: white;
        text-decoration: none;
        font-weight: 500;
        padding-bottom: 3px;
        transition: 0.2s;
    }

    .nm-link:hover {
        opacity: 0.75;
    }

    .nm-link.active {
        border-bottom: 2px solid white;
        font-weight: 700;
    }

    /* CART */
    .nm-cart {
        background: white;
        color: var(--primary);
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 700;
        text-decoration: none;
        display: flex;
        gap: 4px;
        align-items: center;
    }

    .nm-cart span {
        background: var(--primary);
        color: white;
        padding: 2px 6px;
        border-radius: 40px;
        font-size: 12px;
    }

    /* TOGGLE MENU */
    .nm-toggle {
        display: none;
        font-size: 24px;
        color: white;
        background: transparent;
        border: none;
        cursor: pointer;
    }

    /* MOBILE MENU */
    .nm-mobile {
        display: none;
        flex-direction: column;
        background: white;
        padding: 14px 20px;
    }

    .nm-mobile a {
        padding: 10px 0;
        color: var(--text);
        text-decoration: none;
        font-weight: 600;
    }

    /* RESPONSIVE */
    @media(max-width: 768px) {
        .nm-links {
            display: none;
        }
        .nm-toggle {
            display: block;
        }
    }

    /* SHOW MOBILE MENU */
    .nm-mobile.open {
        display: flex;
    }

    </style>

    {{-- CSS tambahan per halaman --}}
    @yield('styles')
</head>
<body>

    {{-- NAVBAR USER --}}
   <header class="navbar-modern">
    <div class="nm-container">

        <!-- Logo -->
        <a href="{{ route('home') }}" class="nm-brand">
            <div class="nm-logo"></div>
            <div class="nm-title">
                <strong>Toko Buku Pintar</strong>
                <span>Buku pendidikan & literatur</span>
            </div>
        </a>

        <!-- Menu -->
        <nav class="nm-links">
            <a href="{{ route('home') }}" class="nm-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
            <a href="{{ route('user.buku.index') }}" class="nm-link {{ request()->routeIs('user.buku.*') ? 'active' : '' }}">Daftar Buku</a>
            <a href="{{ route('pembelian.buku_index') }}" class="nm-link">Pembelian</a>
            <a href="#penerbit" class="nm-link">Penerbit</a>
            <a href="#faq" class="nm-link">FAQ</a>
        </nav>

        <!-- Aksi -->
        <div class="nm-actions">
            <a href="{{ route('cart.index') }}" class="nm-cart">
                🛒 <span>{{ session('cart_count', 0) }}</span>
            </a>
            <button id="nm-toggle" class="nm-toggle">☰</button>
        </div>
    </div>

    <!-- Mobile menu -->
    <div id="nm-mobile" class="nm-mobile">
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('user.buku.index') }}">Daftar Buku</a>
        <a href="{{ route('pembelian.buku_index') }}">Pembelian</a>
        <a href="#penerbit">Penerbit</a>
        <a href="#faq">FAQ</a>
    </div>
</header>

    {{-- KONTEN HALAMAN USER --}}
    <main class="user-main">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="user-footer">
        <div class="container text-center">
            © {{ date('Y') }} Toko Buku Pintar — Halaman User
        </div>
    </footer>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Script tambahan per halaman --}}
    <script>
document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.getElementById('nm-toggle');
    const mobileMenu = document.getElementById('nm-mobile');

    if (!toggle || !mobileMenu) return;

    toggle.addEventListener('click', function () {
        mobileMenu.classList.toggle('open');
    });
});
</script>

    @yield('scripts')
</body>
</html>
