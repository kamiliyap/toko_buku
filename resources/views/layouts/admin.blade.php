<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard Admin')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap 5 CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: #f5f7fb;
        }
        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }
        .admin-sidebar {
            width: 240px;
            background: #1f2937;
            color: #e5e7eb;
            padding: 20px 16px;
            position: sticky;
            top: 0;
            height: 100vh;
        }
        .admin-sidebar .brand {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .admin-sidebar .brand span.icon {
            background: #2563eb;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }
        .admin-sidebar a {
            color: #e5e7eb;
            text-decoration: none;
        }
        .admin-sidebar .menu-title {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #9ca3af;
            margin: 12px 8px 4px;
        }
        .admin-sidebar .nav-link {
            border-radius: 10px;
            padding: 8px 10px;
            font-size: 14px;
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .admin-sidebar .nav-link:hover,
        .admin-sidebar .nav-link.active {
            background: #111827;
            color: #ffffff;
        }
        .admin-sidebar .nav-sub {
            padding-left: 24px;
            margin-top: 4px;
            margin-bottom: 8px;
        }
        .admin-sidebar .nav-sub .nav-link {
            font-size: 13px;
            padding: 6px 8px;
        }

        .admin-content {
            flex: 1;
            padding: 20px 24px;
        }

        .admin-topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .admin-topbar h1 {
            font-size: 24px;
            font-weight: 600;
            margin: 0;
        }

        .admin-user {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .badge-role {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }
    </style>

    @stack('styles')
</head>
<body>
<div class="admin-wrapper">

    {{-- SIDEBAR --}}
    <aside class="admin-sidebar">
        <div class="brand">
            <span class="icon">📚</span>
            <div>
                <div>Toko Buku</div>
                <small class="text-muted">Panel Admin</small>
            </div>
        </div>

        {{-- MENU UTAMA --}}
        <div class="menu-title">Menu Utama</div>
        <nav class="nav flex-column">

            {{-- Dashboard --}}
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
               href="{{ route('admin.dashboard') }}">
                🏠 <span>Dashboard</span>
            </a>

            {{-- ================= MANEJEMEN BUKU ================= --}}
            <a class="nav-link d-flex justify-content-between align-items-center"
               data-bs-toggle="collapse"
               href="#menuBuku"
               role="button"
               aria-expanded="false"
               aria-controls="menuBuku">
                <span>📚 Manajemen Buku</span>
                <span class="small">▾</span>
            </a>
            <div class="collapse {{ request()->is('admin/buku*') || request()->is('admin/kategori*') || request()->is('admin/penerbit*') ? 'show' : '' }}"
                 id="menuBuku">
                <div class="nav flex-column nav-sub">
                    <a class="nav-link {{ request()->is('admin/buku') ? 'active' : '' }}"
                       href="{{ route('buku.index') }}">
                        • Daftar Buku
                    </a>
                    <a class="nav-link {{ request()->is('admin/buku/create') ? 'active' : '' }}"
                       href="{{ route('buku.create') }}  ">
                        • Tambah Buku
                    </a>
                    <a class="nav-link {{ request()->is('admin/kategori*') ? 'active' : '' }}"
                       href="{{ route('kategori.index') }}">
                        • Kategori
                    </a>
                    <a class="nav-link {{ request()->is('admin/penerbit*') ? 'active' : '' }}"
                       href="{{ url('admin/penerbit') }}">
                        • Penerbit
                    </a>
                </div>
            </div>

            {{-- ================= TRANSAKSI ================= --}}
            <a class="nav-link d-flex justify-content-between align-items-center"
               data-bs-toggle="collapse"
               href="#menuTransaksi"
               role="button"
               aria-expanded="false"
               aria-controls="menuTransaksi">
                <span>🧾 Transaksi</span>
                <span class="small">▾</span>
            </a>
            <div class="collapse {{ request()->is('admin/pesanan*') ? 'show' : '' }}"
                 id="menuTransaksi">
                <div class="nav flex-column nav-sub">
                    <a class="nav-link {{ request()->is('admin/pesanan') ? 'active' : '' }}"
                       href="{{ route('pesanan.index') }}">
                        • Semua Pesanan
                    </a>
                </div>
            </div>

            {{-- ================= BERITA ================= --}}
            <a class="nav-link d-flex justify-content-between align-items-center"
               data-bs-toggle="collapse"
               href="#menuBerita"
               role="button"
               aria-expanded="false"
               aria-controls="menuBerita">
                <span>📰 Berita</span>
                <span class="small">▾</span>
            </a>
            <div class="collapse {{ request()->is('berita*') ? 'show' : '' }}"
                 id="menuBerita">
                <div class="nav flex-column nav-sub">
                    <a class="nav-link {{ request()->routeIs('berita.index') ? 'active' : '' }}"
                       href="{{ route('berita.index') }}">
                        • Daftar Berita
                    </a>
                    <!-- <a class="nav-link {{ request()->routeIs('berita.create') ? 'active' : '' }}"
                       href="{{ route('berita.create') }}">
                        • Tambah Berita
                    </a> -->
                </div>
            </div>

            {{-- ================= USER ================= --}}
            <a class="nav-link d-flex justify-content-between align-items-center"
               data-bs-toggle="collapse"
               href="#menuUser"
               role="button"
               aria-expanded="false"
               aria-controls="menuUser">
                <span>👥 User</span>
                <span class="small">▾</span>
            </a>
            <div class="collapse {{ request()->is('admin/user*') ? 'show' : '' }}"
                 id="menuUser">
                <div class="nav flex-column nav-sub">
                    <a class="nav-link {{ request()->is('admin/user') ? 'active' : '' }}"
                       href="{{ url('admin/user') }}">
                        • Daftar User
                    </a>
                    <a class="nav-link {{ request()->is('admin/user/create') ? 'active' : '' }}"
                       href="{{ url('admin/user/create') }}">
                        • Tambah User
                    </a>
                </div>
            </div>

            {{-- ================= PENGATURAN ================= --}}
            <div class="menu-title mt-3">Pengaturan</div>

            <a class="nav-link d-flex justify-content-between align-items-center"
               data-bs-toggle="collapse"
               href="#menuPengaturan"
               role="button"
               aria-expanded="false"
               aria-controls="menuPengaturan">
                <span>⚙️ Pengaturan</span>
                <span class="small">▾</span>
            </a>
            <div class="collapse" id="menuPengaturan">
                <div class="nav flex-column nav-sub">
                    <a class="nav-link" href="#">
                        • Profil
                    </a>
                    <a class="nav-link" href="#">
                        • Pengaturan Toko
                    </a>
                </div>
            </div>

            {{-- LINK KE FRONTEND / TOKO --}}
            <div class="menu-title mt-3">Lainnya</div>
            <a class="nav-link" href="{{ route('home') }}">
                🏬 <span>Lihat Toko</span>
            </a>

            {{-- LOGOUT --}}
            <form action="{{ route('logout') }}" method="POST" class="mt-2">
                @csrf
                <button type="submit" class="nav-link w-100 text-start border-0 bg-transparent">
                    🚪 <span>Logout</span>
                </button>
            </form>

        </nav>
    </aside>

    {{-- KONTEN --}}
    <main class="admin-content">
        <div class="admin-topbar">
            <h1>@yield('page_title', 'Dashboard')</h1>

            <div class="admin-user">
                <div class="text-end">
                    <div style="font-size: 14px; font-weight: 500;">
                        {{ auth()->user()->name ?? 'Admin' }}
                    </div>
                    <span class="badge bg-primary badge-role">Admin</span>
                </div>
                <div style="width:36px;height:36px;border-radius:50%;background:#dbeafe;display:flex;align-items:center;justify-content:center;font-size:18px;">
                    👩‍💻
                </div>
            </div>
        </div>

        {{-- flash message --}}
        @if (session('success'))
            <div class="alert alert-success py-2">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
