@extends('layouts.auth')

@section('title', 'Keranjang Belanja')

@section('content')

<div class="container py-4">

    <h2 class="fw-bold mb-4">Keranjang Belanja</h2>

    {{-- Alert --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if (empty($cart))
        <div class="alert alert-info text-center py-4">
            <h5 class="mb-0">Keranjang masih kosong.</h5>
        </div>

        <a href="{{ route('pembelian.buku_index') }}" class="btn btn-primary mt-3">
            Belanja Buku
        </a>

    @else

    <div class="card shadow-sm mb-4">
        <div class="card-body">

            <table class="table table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Buku</th>
                        <th>Harga</th>
                        <th style="width:110px;">Qty</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($cart as $id => $item)
                    <tr>
                        <td class="fw-semibold">
                            {{ $item['judul'] }}
                        </td>

                        <td>
                            Rp {{ number_format($item['harga'], 0, ',', '.') }}
                        </td>

                        <td>
                            <form action="{{ route('cart.update', $id) }}" method="POST" class="d-flex">
                                @csrf
                                <input 
                                    type="number" 
                                    name="qty" 
                                    value="{{ $item['qty'] }}" 
                                    min="1" 
                                    class="form-control form-control-sm"
                                >
                                <button class="btn btn-sm btn-primary ms-2">OK</button>
                            </form>
                        </td>

                        <td class="fw-bold">
                            Rp {{ number_format($item['harga'] * $item['qty'], 0, ',', '.') }}
                        </td>

                        <td>
                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <hr>

            <div class="text-end">
                <p class="mb-1">Subtotal: 
                    <strong>Rp {{ number_format($subtotal, 0, ',', '.') }}</strong>
                </p>
                <p class="mb-1">PPN (10%):
                    <strong>Rp {{ number_format($ppn, 0, ',', '.') }}</strong>
                </p>

                <h4 class="fw-bold mt-3">
                    Total: Rp {{ number_format($total, 0, ',', '.') }}
                </h4>

                <a href="{{ route('checkout.form') }}" class="btn btn-success btn-lg mt-3">
                    Lanjut ke Checkout
                </a>
            </div>

        </div>
    </div>

    @endif

    <a href="{{ route('pembelian.buku_index') }}" class="btn btn-link">
        ← Kembali ke Daftar Buku
    </a>

</div>

@endsection
