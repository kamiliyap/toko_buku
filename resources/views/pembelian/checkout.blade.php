@extends('layouts.auth')

@section('title', 'Checkout')

@section('content')
<div class="container-main">

    <h3 class="fw-bold mb-4">Checkout</h3>

    {{-- ERROR ALERT --}}
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
        
        {{-- FORM --}}
        <div class="col-lg-7">
            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <form action="{{ route('checkout.proses') }}" method="POST">
                        @csrf

                        {{-- Nama --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Pelanggan</label>
                            <input type="text" name="nama_pelanggan" class="form-control"
                                value="{{ old('nama_pelanggan') }}" required>
                        </div>

                        {{-- No HP --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">No HP</label>
                            <input type="text" name="no_hp" class="form-control"
                                value="{{ old('no_hp') }}">
                        </div>

                        {{-- Alamat --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="3">{{ old('alamat') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2">
                            <i class="bi bi-check-circle"></i> Konfirmasi & Simpan Pesanan
                        </button>

                    </form>

                </div>
            </div>
        </div>

        {{-- RINGKASAN --}}
        <div class="col-lg-5">
            <div class="card shadow-sm border-0">
                <div class="card-body">

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

                </div>
            </div>
        </div>

    </div>

</div>
@endsection
