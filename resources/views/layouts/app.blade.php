<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title','Toko Buku Pintar')</title>

    {{-- Bootstrap CSS (global untuk layout ini) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- CSS global (kalau ada) --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    {{-- Kalau route sekarang = home, ikutkan home.css --}}
    @if (request()->routeIs('home'))
        <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    @endif

    {{-- CSS tambahan per-halaman --}}
    @yield('styles')
    @stack('head')
</head>
<body>

    {{-- NAVBAR UMUM (bukan admin, bukan user khusus) --}}
    @includeIf('layouts.navbar')

    {{-- KONTEN HALAMAN --}}
    <main class="py-4">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    @includeIf('partials.footer')

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Script tambahan per-halaman --}}
    @stack('scripts')
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
