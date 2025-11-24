<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    {{-- Tambahkan CSS Bootstrap kalau diperlukan --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    
    {{-- tempat css halaman --}}
    @yield('styles')
</head>
<body class="bg-light">

    {{-- Konten halaman login --}}
    @yield('content')
    @yield('scripts')
</body>
</html>
