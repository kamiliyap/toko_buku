{{-- resources/views/buku/show-standalone.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Detail Buku - {{ $b->judul }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  {{-- Bootstrap CSS (standalone) --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

  <div class="container py-5">
    {{-- Tombol kembali --}}
    <a href="{{ route('buku.index') }}" class="btn btn-secondary mb-4">← Kembali ke Daftar Buku</a>

    @if($b)
      <div class="card shadow border-0">
        <div class="row g-0">
          <div class="col-md-4">
            <img
              src="{{ $b->gambar ? asset('storage/'.$b->gambar) : asset('assets/img/no-cover.png') }}"
              class="img-fluid rounded-start"
              alt="Cover Buku">
          </div>

          <div class="col-md-8">
            <div class="card-body">
              <h3 class="fw-bold mb-3">{{ $b->judul }}</h3>

              <table class="table table-borderless">
                <tr><th width="150">Penerbit</th><td>{{ $b->penerbit ?? '-' }}</td></tr>
                <tr><th>ISBN</th><td>{{ $b->ISBN ?? '-' }}</td></tr>
                <tr><th>Penulis</th><td>{{ $b->penulis ?? '-' }}</td></tr>
                <tr><th>Kategori</th><td>{{ $b->kategori ?? '-' }}</td></tr>
                <tr><th>Stok</th><td>{{ $b->stok ?? '-' }}</td></tr>
                <tr>
                  <th>Harga</th>
                  <td class="fw-bold text-primary">
                    Rp {{ number_format($b->harga, 0, ',', '.') }}
                  </td>
                </tr>
              </table>

              {{-- opsional: tombol keranjang, kalau route-nya sudah ada --}}
              {{-- 
              <form action="{{ route('cart.add', $b->id) }}" method="POST" class="mt-2">
                @csrf
                <button class="btn btn-primary">Tambah ke Keranjang</button>
              </form>
              --}}
            </div>
          </div>
        </div>
      </div>
    @else
      <div class="alert alert-danger text-center">
        Buku tidak ditemukan!
      </div>
    @endif
  </div>

  {{-- Bootstrap JS (optional, kalau butuh) --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
