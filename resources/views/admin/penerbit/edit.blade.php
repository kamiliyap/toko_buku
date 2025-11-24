@extends('layouts.admin')

@section('title', 'Edit Penerbit')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold text-secondary">✏️ Edit Penerbit</h3>
        <a href="{{ route('penerbit.index') }}" class="btn btn-outline-secondary btn-sm">
            Kembali
        </a>
    </div>

    {{-- Alert jika sukses --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <form action="{{ route('penerbit.update', $penerbit->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nama Penerbit</label>
                    <input type="text"
                           name="nama"
                           class="form-control"
                           value="{{ old('nama', $penerbit->nama) }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <input type="text"
                           name="alamat"
                           class="form-control"
                           value="{{ old('alamat', $penerbit->alamat) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Kontak</label>
                    <input type="text"
                           name="kontak"
                           class="form-control"
                           value="{{ old('kontak', $penerbit->kontak) }}">
                </div>

                <button type="submit" class="btn btn-primary">
                    Simpan Perubahan
                </button>

            </form>

        </div>
    </div>

</div>
@endsection
