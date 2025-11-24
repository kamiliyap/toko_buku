@extends('layouts.admin')

@section('title', 'Edit Pesanan')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold text-secondary">✏️ Edit Pesanan</h3>
        <a href="{{ route('pesanan.index') }}" class="btn btn-outline-secondary btn-sm">
            Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('pesanan.update', $pesanan->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Kode Pesanan</label>
                    <input type="text" class="form-control" value="{{ $pesanan->kode_pesanan ?? $pesanan->id }}" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Pelanggan</label>
                    <input type="text"
                           name="nama_pelanggan"
                           class="form-control"
                           value="{{ old('nama_pelanggan', $pesanan->nama_pelanggan ?? '') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Total</label>
                    <input type="number"
                           name="total"
                           class="form-control"
                           value="{{ old('total', $pesanan->total ?? 0) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        @php
                            $statusList = ['pending', 'proses', 'selesai', 'batal'];
                        @endphp
                        @foreach($statusList as $s)
                            <option value="{{ $s }}" {{ ($pesanan->status ?? '') == $s ? 'selected' : '' }}>
                                {{ ucfirst($s) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">
                    Simpan Perubahan
                </button>
            </form>

            {{-- Tombol Hapus --}}
            <form action="{{ route('pesanan.destroy', $pesanan->id) }}"
                  method="POST"
                  class="mt-3"
                  onsubmit="return confirm('Yakin ingin menghapus pesanan ini?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm">
                    Hapus Pesanan
                </button>
            </form>

        </div>
    </div>
</div>
@endsection
