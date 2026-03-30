<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Buku - {{ $book->judul }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logoweb/logoweb.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logoweb/logoweb.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    @php
        $imgFile = basename($book->gambar ?? '');
        $imgUrl = $imgFile ? asset('images/buku/' . $imgFile) : asset('images/no-cover.png');
        $isbn = $book->ISBN ?? $book->isbn ?? '-';
    @endphp

    <div class="container py-5">
        <a href="{{ route('user.buku.index') }}" class="btn btn-secondary mb-4">&larr; Kembali ke Daftar Buku</a>

        <div class="card shadow-sm border-0">
            <div class="row g-0">
                <div class="col-md-4">
                    <img
                        src="{{ $imgUrl }}"
                        alt="Cover {{ $book->judul }}"
                        class="img-fluid w-100 h-100 object-fit-cover rounded-start"
                        style="min-height: 360px;"
                    >
                </div>

                <div class="col-md-8">
                    <div class="card-body p-4">
                        <span class="badge text-bg-primary mb-3">{{ $book->kategori ?? 'Tanpa kategori' }}</span>
                        <h1 class="h3 fw-bold mb-3">{{ $book->judul }}</h1>

                        <table class="table table-borderless align-middle mb-4">
                            <tr>
                                <th class="text-secondary" style="width: 180px;">Penulis</th>
                                <td>{{ $book->penulis ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th class="text-secondary">Penerbit</th>
                                <td>{{ $book->penerbit ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th class="text-secondary">ISBN</th>
                                <td>{{ $isbn }}</td>
                            </tr>
                            <tr>
                                <th class="text-secondary">Stok</th>
                                <td>{{ $book->stok ?? 0 }}</td>
                            </tr>
                            <tr>
                                <th class="text-secondary">Harga</th>
                                <td class="fw-semibold text-primary">Rp {{ number_format($book->harga ?? 0, 0, ',', '.') }}</td>
                            </tr>
                        </table>

                        <div class="mb-4">
                            <h2 class="h5 fw-semibold">Deskripsi</h2>
                            <p class="text-secondary mb-0">
                                {{ $book->deskripsi ?: 'Belum ada deskripsi untuk buku ini.' }}
                            </p>
                        </div>

                        <form action="{{ route('cart.add', $book->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                + Keranjang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
