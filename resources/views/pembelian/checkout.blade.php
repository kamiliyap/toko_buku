@extends('layouts.user')

@section('title', 'Checkout')
@section('nav_search_action', route('pembelian.buku_index'))

@section('styles')
<style>
    .checkout-shell {
        max-width: 1240px;
        margin: 0 auto;
        padding: 28px 20px 44px;
    }

    .checkout-shell h1 {
        margin-bottom: 20px;
        font-size: clamp(1.8rem, 3vw, 2.3rem);
        font-weight: 800;
    }

    .checkout-card {
        border: 0;
        border-radius: 24px;
        box-shadow: 0 16px 40px rgba(15, 23, 42, 0.08);
    }

    @media (max-width: 768px) {
        .checkout-shell {
            padding: 24px 16px 36px;
        }
    }
</style>
@endsection

@section('content')
<div class="checkout-shell">
    <h1>Checkout</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card checkout-card">
                <div class="card-body p-4">
                    <form action="{{ route('checkout.proses') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Pelanggan</label>
                            <input type="text" name="nama_pelanggan" class="form-control" value="{{ old('nama_pelanggan') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">No HP</label>
                            <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="3">{{ old('alamat') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2">
                            <i class="bi bi-check-circle"></i>
                            Konfirmasi dan Simpan Pesanan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card checkout-card">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Ringkasan Pesanan</h5>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <strong>Rp {{ number_format($subtotal, 0, ',', '.') }}</strong>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>PPN (10%)</span>
                        <strong>Rp {{ number_format($ppn, 0, ',', '.') }}</strong>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between">
                        <h5 class="fw-bold">Total</h5>
                        <h5 class="fw-bold text-primary">Rp {{ number_format($total, 0, ',', '.') }}</h5>
                    </div>

                    <a href="{{ route('cart.index') }}" class="btn btn-link text-decoration-none px-0 mt-3">
                        <i class="bi bi-arrow-left"></i>
                        Kembali ke keranjang
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
