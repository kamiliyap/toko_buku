@extends('layouts.admin')

@section('title', 'Tambah User')
@section('page_title', 'Tambah User')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="fw-bold text-secondary mb-1">Tambah User</h3>
            <p class="text-muted mb-0">Buat akun baru untuk user biasa atau admin.</p>
        </div>
        <a href="{{ route('admin.user.index') }}" class="btn btn-outline-secondary btn-sm">
            Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <div class="fw-semibold mb-2">Data belum bisa disimpan.</div>
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('admin.user.store') }}" method="POST">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Lengkap</label>
                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            value="{{ old('name') }}"
                            required
                        >
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Username</label>
                        <input
                            type="text"
                            name="username"
                            class="form-control"
                            value="{{ old('username') }}"
                            placeholder="Opsional"
                        >
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            value="{{ old('email') }}"
                            required
                        >
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Role</label>
                        <select name="is_admin" class="form-select" required>
                            <option value="0" {{ old('is_admin', '0') === '0' ? 'selected' : '' }}>User Biasa</option>
                            <option value="1" {{ old('is_admin') === '1' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Password</label>
                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            required
                        >
                        <small class="text-muted">Minimal 8 karakter.</small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Konfirmasi Password</label>
                        <input
                            type="password"
                            name="password_confirmation"
                            class="form-control"
                            required
                        >
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('admin.user.index') }}" class="btn btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan User</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
