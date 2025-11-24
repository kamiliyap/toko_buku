@extends('layouts.auth')

@section('title','Pembelian Selesai')

@section('content')
<div class="container-main my-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">

            {{-- CARD UTAMA --}}
            <div class="card shadow-sm rounded-4 p-3 p-md-4">

                <h4 class="fw-bold mb-3">Pembelian Selesai</h4>

                {{-- ALERT --}}
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- KODE PESANAN + BARCODE --}}
                <div class="mb-3">
                    <strong>Kode Pesanan:</strong>

                    {{-- SVG BARCODE --}}
                    <div class="mt-2">
                        <svg id="kode-barcode"></svg>
                    </div>

                    {{-- Teks kode di bawah barcode --}}
                    <small class="text-muted d-block mt-1">
                        {{ $pesanan->kode_pesanan }}
                    </small>
                </div>

                {{-- INFORMASI PESANAN --}}
                <div class="mb-1">
                    <strong>Nama:</strong> {{ $pesanan->nama_pelanggan }}
                </div>

                <div class="mb-1">
                    <strong>No HP:</strong> {{ $pesanan->no_hp ?? '-' }}
                </div>

                <div class="mb-3">
                    <strong>Alamat:</strong> {{ $pesanan->alamat ?? '-' }}
                </div>

                <hr>

                <h5 class="fw-bold">Total Pembayaran</h5>
                <p class="fs-5 text-primary fw-bold mb-3">
                    Rp {{ number_format($pesanan->total, 0, ',', '.') }}
                </p>

                <hr>

                {{-- DETAIL BUKU --}}
                <h5 class="fw-bold mb-2">Detail Buku</h5>

                <div class="table-responsive">
                    <table class="table table-sm table-bordered align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Judul</th>
                                <th width="60">Qty</th>
                                <th width="120">Harga</th>
                                <th width="120">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pesanan->details as $detail)
                                <tr>
                                    <td>{{ $detail->buku->judul ?? '-' }}</td>
                                    <td>{{ $detail->qty }}</td>
                                    <td>Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                                    <td class="fw-bold">
                                        Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- TOMBOL --}}
                <div class="text-center mt-4">
                    <a href="{{ route('pembelian.buku_index') }}" class="btn btn-primary px-4">
                        <i class="bi bi-bag"></i> Kirim Pesaanan
                    </a>
                </div>
                {{-- TOMBOL --}}
                <div class="d-flex justify-content-between align-items-center mt-3 gap-2">
                    <a href="{{ route('pembelian.buku_index') }}" class="btn btn-outline-secondary px-4">
                        <i class="bi bi-bag"></i> Belanja Lagi
                    </a>
                    <form action="{{ route('pembelian.batalkan', $pesanan->id) }}" method="POST" class="mt-3">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger w-100">
                            <i class="bi bi-x-circle"></i> Batalkan Pesanan
                        </button>
                    </form>
                    <a href="{{ route('pembelian.nota', $pesanan->id) }}" class="btn btn-danger px-4">
                        <i class="bi bi-file-earmark-arrow-down"></i> Download PDF
                    </a>
                </div>
            </div>
            {{-- END CARD --}}

        </div>
    </div>
</div>
@endsection

@section('scripts')
    {{-- CDN JsBarcode --}}
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const kode = @json($pesanan->kode_pesanan);
            const svg  = document.querySelector('#kode-barcode');

            if (svg && kode) {
                JsBarcode(svg, kode, {
                    format: "CODE128",
                    displayValue: false,    // kalau mau tulisan di bawah garis, ganti true
                    lineColor: "#111827",
                    width: 1.5,
                    height: 60,
                    margin: 0
                });
            }
        });
    </script>
@endsection
