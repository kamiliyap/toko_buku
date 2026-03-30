@extends('layouts.admin')

@section('title', 'Pengaturan')
@section('page_title', 'Pengaturan')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="fw-bold text-secondary mb-1">Pengaturan</h3>
            <p class="text-muted mb-0">Kelola profil admin dan identitas toko dari satu halaman.</p>
        </div>
        <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">Lihat Toko</a>
    </div>

    <div class="row g-3">
        <div class="col-12 col-lg-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="text-muted text-uppercase small fw-semibold mb-2">Preview Toko</div>
                    <h4 class="fw-bold mb-1">{{ $storeSettings['store_name'] }}</h4>
                    <p class="text-muted mb-3">{{ $storeSettings['tagline'] }}</p>

                    <div class="small text-muted mb-1">Email Kontak</div>
                    <div class="fw-semibold mb-3">{{ $storeSettings['contact_email'] ?: '-' }}</div>

                    <div class="small text-muted mb-1">Telepon</div>
                    <div class="fw-semibold mb-3">{{ $storeSettings['contact_phone'] ?: '-' }}</div>

                    <div class="small text-muted mb-1">Alamat</div>
                    <div class="fw-semibold">{{ $storeSettings['address'] ?: '-' }}</div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-8">
            <div id="profil" class="card shadow-sm border-0 mb-3">
                <div class="card-body">
                    <h5 class="fw-bold mb-1">Profil Admin</h5>
                    <p class="text-muted mb-3">Perbarui identitas akun yang sedang login.</p>

                    <form action="{{ route('admin.settings.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $adminUser->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username', $adminUser->username) }}">
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $adminUser->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Password Saat Ini</label>
                                <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" placeholder="Isi jika ingin ganti password">
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Password Baru</label>
                                <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror">
                                @error('new_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" name="new_password_confirmation" class="form-control">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary">Simpan Profil</button>
                        </div>
                    </form>
                </div>
            </div>

            <div id="toko" class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="fw-bold mb-1">Pengaturan Toko</h5>
                    <p class="text-muted mb-3">Nilai ini dipakai untuk identitas toko di frontend dan admin.</p>

                    <form action="{{ route('admin.settings.store.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama Toko</label>
                                <input type="text" name="store_name" class="form-control @error('store_name') is-invalid @enderror" value="{{ old('store_name', $storeSettings['store_name']) }}" required>
                                @error('store_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Tagline</label>
                                <input type="text" name="tagline" class="form-control @error('tagline') is-invalid @enderror" value="{{ old('tagline', $storeSettings['tagline']) }}">
                                @error('tagline')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email Kontak</label>
                                <input type="email" name="contact_email" class="form-control @error('contact_email') is-invalid @enderror" value="{{ old('contact_email', $storeSettings['contact_email']) }}">
                                @error('contact_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Nomor Telepon</label>
                                <input type="text" name="contact_phone" class="form-control @error('contact_phone') is-invalid @enderror" value="{{ old('contact_phone', $storeSettings['contact_phone']) }}">
                                @error('contact_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Alamat Toko</label>
                                <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address', $storeSettings['address']) }}">
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Teks Banner Berjalan</label>
                                <textarea name="running_banner" class="form-control @error('running_banner') is-invalid @enderror" rows="4">{{ old('running_banner', $storeSettings['running_banner']) }}</textarea>
                                @error('running_banner')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary">Simpan Pengaturan Toko</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
