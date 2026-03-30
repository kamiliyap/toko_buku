<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', $storeSettings['store_name'] ?? 'Toko Buku Pintar')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('images/logoweb/logoweb.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logoweb/logoweb.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary: #5b21b6;
            --primary-light: #7c3aed;
            --accent: #06b6d4;
            --bg: #f3f4f6;
            --text: #1f2937;
            --muted: #6b7280;
            --surface: #ffffff;
        }

        body {
            margin: 0;
            background: var(--bg);
            color: var(--text);
        }

        .navbar-modern {
            position: sticky;
            top: 0;
            z-index: 2000;
            background: linear-gradient(90deg, var(--primary), var(--accent));
            box-shadow: 0 12px 30px rgba(31, 41, 55, 0.12);
        }

        .nm-container {
            max-width: 1440px;
            margin: 0 auto;
            padding: 20px 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 32px;
        }

        .nm-brand {
            display: flex;
            align-items: center;
            gap: 20px;
            color: #fff;
            text-decoration: none;
            flex-shrink: 0;
        }

        .nm-logo {
            width: 118px;
            height: 78px;
            border-radius: 20px;
            display: block;
            object-fit: contain;
            flex-shrink: 0;
            padding: 6px 10px;
            background: rgba(255, 255, 255, 0.95);
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.45);
        }

        .nm-title {
            display: flex;
            flex-direction: column;
            line-height: 1.08;
        }

        .nm-title strong {
            font-size: clamp(1.9rem, 1.4rem + 1vw, 2.4rem);
            font-weight: 700;
        }

        .nm-title span {
            margin-top: 4px;
            font-size: clamp(1rem, 0.85rem + 0.3vw, 1.1rem);
            color: rgba(255, 255, 255, 0.82);
        }

        .nm-links {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 28px;
            flex: 1;
        }

        .nm-link {
            color: rgba(255, 255, 255, 0.92);
            text-decoration: none;
            font-size: 1.15rem;
            font-weight: 600;
            padding-bottom: 6px;
            transition: opacity 0.2s ease, border-color 0.2s ease;
            border-bottom: 2px solid transparent;
        }

        .nm-link:hover {
            opacity: 0.82;
            color: #fff;
        }

        .nm-link.active {
            color: #fff;
            font-weight: 700;
            border-color: rgba(255, 255, 255, 0.95);
        }

        .nm-actions {
            display: flex;
            align-items: center;
            gap: 14px;
            flex-shrink: 0;
        }

        .nm-search {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 4px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.28);
            backdrop-filter: blur(10px);
        }

        .nm-search-input {
            min-width: 180px;
            height: 42px;
            border: 0;
            outline: none;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.95);
            padding: 0 14px;
            color: var(--text);
        }

        .nm-search-input::placeholder {
            color: #6b7280;
        }

        .nm-search-btn {
            width: 42px;
            height: 42px;
            border: 0;
            border-radius: 999px;
            background: #1f2937;
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .nm-cart {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 14px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.95);
            color: var(--primary);
            text-decoration: none;
            font-weight: 700;
            box-shadow: 0 10px 24px rgba(31, 41, 55, 0.12);
        }

        .nm-cart span {
            min-width: 22px;
            height: 22px;
            padding: 0 6px;
            border-radius: 999px;
            background: #ef4444;
            color: #fff;
            font-size: 0.75rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .nm-toggle {
            display: none;
            width: 42px;
            height: 42px;
            border: 0;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.18);
            color: #fff;
            font-size: 1.3rem;
            cursor: pointer;
        }

        .nm-mobile {
            display: none;
            flex-direction: column;
            gap: 10px;
            padding: 14px 20px 18px;
            background: #fff;
            box-shadow: 0 18px 40px rgba(31, 41, 55, 0.12);
        }

        .nm-mobile.open {
            display: flex;
        }

        .nm-mobile a {
            color: var(--text);
            text-decoration: none;
            font-weight: 600;
            padding: 8px 0;
        }

        .nm-mobile a.active {
            color: var(--primary);
        }

        .nm-search-mobile {
            display: none;
            background: #f8fafc;
            border: 1px solid #e5e7eb;
        }

        .user-main {
            min-height: calc(100vh - 152px);
        }

        .user-footer {
            padding: 18px 16px 28px;
            color: var(--muted);
            font-size: 0.92rem;
            text-align: center;
        }

        @media (max-width: 1280px) {
            .nm-container {
                padding: 18px 28px;
                gap: 24px;
            }

            .nm-links {
                gap: 20px;
            }

            .nm-link {
                font-size: 1.02rem;
            }

            .nm-search-input {
                min-width: 150px;
            }
        }

        @media (max-width: 1120px) {
            .nm-links {
                gap: 16px;
            }

            .nm-search {
                display: none;
            }

            .nm-logo {
                width: 98px;
                height: 64px;
                padding: 5px 8px;
                border-radius: 18px;
            }

            .nm-title strong {
                font-size: 1.7rem;
            }

            .nm-title span {
                font-size: 0.96rem;
            }
        }

        @media (max-width: 980px) {
            .nm-links,
            .nm-search {
                display: none;
            }

            .nm-toggle,
            .nm-search-mobile {
                display: flex;
            }

            .nm-container {
                padding: 16px 20px;
                gap: 16px;
            }
        }

        @media (max-width: 640px) {
            .nm-brand {
                gap: 12px;
            }

            .nm-logo {
                width: 76px;
                height: 50px;
                padding: 4px 6px;
                border-radius: 14px;
            }

            .nm-title strong {
                font-size: 1.35rem;
            }

            .nm-search-input {
                min-width: 180px;
            }

            .nm-title span {
                display: none;
            }

            .nm-cart {
                padding: 8px 10px;
            }

            .nm-mobile {
                padding-inline: 16px;
            }
        }
    </style>

    @yield('styles')
</head>
<body>
    @php
        $cartCount = collect(session('cart', []))->sum(function ($item) {
            return (int) ($item['qty'] ?? 0);
        });

        $navSearchAction = trim($__env->yieldContent('nav_search_action'));

        if ($navSearchAction === '') {
            $navSearchAction = request()->routeIs('user.buku.*')
                ? route('user.buku.index')
                : route('pembelian.buku_index');
        }

        $isPembelianRoute = request()->routeIs('pembelian.*')
            || request()->routeIs('cart.*')
            || request()->routeIs('checkout.*');
    @endphp

    <header class="navbar-modern">
        <div class="nm-container">
            <a href="{{ route('home') }}" class="nm-brand">
                <img src="{{ asset('images/logoweb/logoweb.png') }}" alt="Logo {{ $storeSettings['store_name'] ?? 'Toko Buku Pintar' }}" class="nm-logo">
                <div class="nm-title">
                    <strong>{{ $storeSettings['store_name'] ?? 'Toko Buku Pintar' }}</strong>
                    <span>{{ $storeSettings['tagline'] ?? 'Buku pendidikan dan literatur' }}</span>
                </div>
            </a>

            <nav class="nm-links">
                <a href="{{ route('home') }}" class="nm-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
                <a href="{{ route('user.buku.index') }}" class="nm-link {{ request()->routeIs('user.buku.*') ? 'active' : '' }}">Daftar Buku</a>
                <a href="{{ route('pembelian.buku_index') }}" class="nm-link {{ $isPembelianRoute ? 'active' : '' }}">Pembelian</a>
                <a href="{{ route('home') }}#publishers" class="nm-link">Penerbit</a>
                <a href="{{ route('home') }}#faq" class="nm-link">FAQ</a>
            </nav>

            <div class="nm-actions">
                <form class="nm-search" method="GET" action="{{ $navSearchAction }}">
                    <input
                        type="search"
                        name="q"
                        value="{{ request('q') }}"
                        class="nm-search-input"
                        placeholder="Cari buku..."
                    >
                    <button type="submit" class="nm-search-btn" aria-label="Cari buku">
                        <i class="bi bi-search"></i>
                    </button>
                </form>

                <a href="{{ route('cart.index') }}" class="nm-cart" aria-label="Keranjang belanja">
                    <i class="bi bi-cart3"></i>
                    <span>{{ $cartCount }}</span>
                </a>

                <button
                    id="nm-toggle"
                    class="nm-toggle"
                    type="button"
                    aria-label="Buka menu"
                    aria-expanded="false"
                    aria-controls="nm-mobile"
                >
                    <i class="bi bi-list"></i>
                </button>
            </div>
        </div>

        <div id="nm-mobile" class="nm-mobile" aria-hidden="true">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
            <a href="{{ route('user.buku.index') }}" class="{{ request()->routeIs('user.buku.*') ? 'active' : '' }}">Daftar Buku</a>
            <a href="{{ route('pembelian.buku_index') }}" class="{{ $isPembelianRoute ? 'active' : '' }}">Pembelian</a>
            <a href="{{ route('home') }}#publishers">Penerbit</a>
            <a href="{{ route('home') }}#faq">FAQ</a>

            <form class="nm-search nm-search-mobile" method="GET" action="{{ $navSearchAction }}">
                <input
                    type="search"
                    name="q"
                    value="{{ request('q') }}"
                    class="nm-search-input"
                    placeholder="Cari buku..."
                >
                <button type="submit" class="nm-search-btn" aria-label="Cari buku">
                    <i class="bi bi-search"></i>
                </button>
            </form>

            <a href="{{ route('cart.index') }}" class="nm-cart">
                <i class="bi bi-cart3"></i>
                <span>{{ $cartCount }}</span>
            </a>
        </div>
    </header>

    <main class="user-main">
        @yield('content')
    </main>

    <footer class="user-footer">
        &copy; {{ date('Y') }} {{ $storeSettings['store_name'] ?? 'Toko Buku Pintar' }}
    </footer>

    @include('partials.service_chatbot')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggle = document.getElementById('nm-toggle');
            const mobileMenu = document.getElementById('nm-mobile');

            if (!toggle || !mobileMenu) {
                return;
            }

            function setMenuState(open) {
                mobileMenu.classList.toggle('open', open);
                mobileMenu.setAttribute('aria-hidden', open ? 'false' : 'true');
                toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            }

            toggle.addEventListener('click', function (event) {
                event.stopPropagation();
                setMenuState(!mobileMenu.classList.contains('open'));
            });

            document.addEventListener('click', function (event) {
                if (!mobileMenu.classList.contains('open')) {
                    return;
                }

                if (!mobileMenu.contains(event.target) && event.target !== toggle) {
                    setMenuState(false);
                }
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    setMenuState(false);
                }
            });
        });
    </script>

    @yield('scripts')
</body>
</html>
