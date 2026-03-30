@extends('layouts.user')

@section('title', 'Keranjang Belanja')
@section('nav_search_action', route('pembelian.buku_index'))

@section('styles')
<style>
    .cart-shell {
        max-width: 1240px;
        margin: 0 auto;
        padding: 28px 20px 44px;
    }

    .cart-header {
        display: flex;
        justify-content: space-between;
        align-items: end;
        gap: 16px;
        margin-bottom: 20px;
    }

    .cart-header h1 {
        margin: 0;
        font-size: clamp(1.8rem, 3vw, 2.3rem);
        font-weight: 800;
    }

    .cart-header p {
        margin: 6px 0 0;
        color: #64748b;
    }

    .cart-card {
        border: 0;
        border-radius: 24px;
        background: #fff;
        box-shadow: 0 16px 40px rgba(15, 23, 42, 0.08);
    }

    .cart-table thead th {
        border-bottom-width: 1px;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        font-size: 0.78rem;
    }

    .cart-table td,
    .cart-table th {
        vertical-align: middle;
    }

    .cart-qty-form {
        display: flex;
        gap: 8px;
        align-items: center;
        min-width: 150px;
    }

    .cart-summary {
        margin-top: 18px;
        padding-top: 18px;
        border-top: 1px solid #e5e7eb;
    }

    .cart-empty {
        padding: 42px 24px;
        border-radius: 24px;
        background: #fff;
        text-align: center;
        box-shadow: 0 16px 40px rgba(15, 23, 42, 0.08);
    }

    .cart-footer-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        margin-top: 18px;
        flex-wrap: wrap;
    }

    @media (max-width: 768px) {
        .cart-shell {
            padding: 24px 16px 36px;
        }

        .cart-header {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>
@endsection

@section('content')
<div class="cart-shell">
    <div class="cart-header">
        <div>
            <h1>Keranjang Belanja</h1>
            <p>Periksa buku yang dipilih sebelum lanjut ke checkout.</p>
        </div>
        <a href="{{ route('pembelian.buku_index') }}" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left"></i>
            Lanjut Belanja
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if (empty($cart))
        <div class="cart-empty">
            <h3 class="fw-bold mb-2">Keranjang masih kosong</h3>
            <p class="text-muted mb-4">Tambahkan buku dari halaman pembelian untuk mulai checkout.</p>
            <a href="{{ route('pembelian.buku_index') }}" class="btn btn-primary px-4">Belanja Buku</a>
        </div>
    @else
        <div class="card cart-card">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table align-middle cart-table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Buku</th>
                                <th>Harga</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cart as $id => $item)
                                <tr>
                                    <td class="fw-semibold">{{ $item['judul'] }}</td>
                                    <td>Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                                    <td>
                                        <form action="{{ route('cart.update', $id) }}" method="POST" class="cart-qty-form">
                                            @csrf
                                            <input
                                                type="number"
                                                name="qty"
                                                value="{{ $item['qty'] }}"
                                                min="1"
                                                class="form-control form-control-sm"
                                            >
                                            <button class="btn btn-sm btn-primary" type="submit">Update</button>
                                        </form>
                                    </td>
                                    <td class="fw-bold">Rp {{ number_format($item['harga'] * $item['qty'], 0, ',', '.') }}</td>
                                    <td>
                                        <form action="{{ route('cart.remove', $id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" type="submit">
                                                <i class="bi bi-trash3"></i>
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="cart-summary">
                    <div class="text-end">
                        <p class="mb-1">Subtotal: <strong>Rp {{ number_format($subtotal, 0, ',', '.') }}</strong></p>
                        <p class="mb-1">PPN (10%): <strong>Rp {{ number_format($ppn, 0, ',', '.') }}</strong></p>
                        <h4 class="fw-bold mt-3">Total: Rp {{ number_format($total, 0, ',', '.') }}</h4>
                    </div>

                    <div class="cart-footer-actions">
                        <a href="{{ route('pembelian.buku_index') }}" class="btn btn-link text-decoration-none px-0">
                            <i class="bi bi-arrow-left"></i>
                            Kembali ke Daftar Buku
                        </a>
                        <a href="{{ route('checkout.form') }}" class="btn btn-success btn-lg">
                            <i class="bi bi-credit-card"></i>
                            Lanjut ke Checkout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
