@extends('layouts.user')

@section('title', 'Pembelian Selesai')
@section('nav_search_action', route('pembelian.buku_index'))

@section('styles')
<style>
    .order-shell {
        max-width: 980px;
        margin: 0 auto;
        padding: 28px 20px 44px;
    }

    .order-card {
        border: 0;
        border-radius: 24px;
        box-shadow: 0 16px 40px rgba(15, 23, 42, 0.08);
    }

    .order-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .order-barcode {
        margin-top: 10px;
    }

    .barcode-wrap {
        display: inline-block;
        max-width: 100%;
    }

    .barcode-table {
        border-collapse: collapse;
        margin: 0 auto;
    }

    .barcode-table td {
        padding: 0;
    }

    .barcode-black {
        background: #111827;
    }

    .barcode-space {
        background: transparent;
    }

    .barcode-label {
        margin-top: 8px;
        text-align: center;
        font-family: "DejaVu Sans", Arial, sans-serif;
        font-size: 12px;
        color: #111827;
        letter-spacing: 0.04em;
    }

    @media (max-width: 768px) {
        .order-shell {
            padding: 24px 16px 36px;
        }
    }
</style>
@endsection

@section('content')
<div class="order-shell">
    <div class="card order-card">
        <div class="card-body p-4 p-md-5">
            <h1 class="fw-bold mb-3">Pembelian Selesai</h1>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-3">
                <strong>Kode Pesanan:</strong>
                <div class="order-barcode">{!! $barcodeHtml !!}</div>
                <small class="text-muted d-block mt-1">{{ $pesanan->kode_pesanan }}</small>
            </div>

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
                                <td class="fw-bold">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="order-actions mt-4">
                <a href="{{ route('pembelian.buku_index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i>
                    Belanja Lagi
                </a>

                <div class="d-flex flex-wrap gap-2">
                    <form action="{{ route('pembelian.batalkan', $pesanan->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">
                            <i class="bi bi-x-circle"></i>
                            Batalkan Pesanan
                        </button>
                    </form>

                    <a href="{{ route('pembelian.nota', $pesanan->id) }}" class="btn btn-primary">
                        <i class="bi bi-file-earmark-arrow-down"></i>
                        Download PDF
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
