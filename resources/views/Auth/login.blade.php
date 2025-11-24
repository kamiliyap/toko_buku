@extends('layouts.auth') {{-- gunakan layout tanpa navbar --}}

@section('title', 'Halo Admin')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #5dade2, #2e86de);
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: 'Poppins', sans-serif;
        color: #333;
    }

    .login-box {
        width: 420px;
        background: #fff;
        border-radius: 18px;
        padding: 35px 35px 25px;
        box-shadow: 0px 6px 18px rgba(0,0,0,0.2);
        animation: fadeIn 0.6s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .admin-icon {
        font-size: 70px;
        background: #d6eaf8;
        width: 110px;
        height: 110px;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0 auto;
        border-radius: 50%;
        margin-bottom: 20px;
    }

    input {
        height: 48px !important;
        border-radius: 10px !important;
    }

    .btn-login {
        background: #3498db;
        border: none;
        font-size: 16px;
        padding: 12px;
        border-radius: 10px;
        color: white;
        transition: 0.3s;
    }

    .btn-login:hover {
        background: #2e86c1;
    }

    .btn-back {
        background: #eee;
        border: none;
        width: 100%;
        padding: 10px;
        margin-top: 8px;
        border-radius: 10px;
    }

    .btn-back:hover {
        background: #ddd;
    }

    label {
        font-weight: 600;
    }
</style>

<div class="login-box text-center">
    
    {{-- ICON ADMIN --}}
    <div class="admin-icon">
        👨‍💼
    </div>

    <h2 class="fw-bold">Halo Admin</h2>
    <p class="text-muted" style="margin-top:-5px;">Masukkan email dan password</p>

    <form action="{{ route('login.attempt') }}" method="POST">
        @csrf

        <div class="text-start mt-3">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Masukkan email" required>
        </div>

        <div class="text-start mt-3">
            <label>Password</label>
            <div class="input-group">
                <span class="input-group-text">🔒</span>
                <input type="password" name="password" class="form-control" placeholder="Kata sandi" required>
            </div>
        </div>

        <div class="d-flex align-items-center mt-3">
            <input type="checkbox" style="width:18px;height:18px;" name="remember" id="remember" class="me-2">
            <label for="remember" class="mb-0" style="font-size:15px;">Ingat saya</label>
        </div>

        <button type="submit" class="btn btn-login w-100 mt-4">
            Masuk
        </button>

        <!-- <a href="{{ url('/') }}" class="btn-back">⬅ Kembali ke Home</a> -->
    </form>

    @if ($errors->any())
    <div class="alert alert-danger mt-3">
        Login gagal. Periksa email & password.
    </div>
    @endif

</div>

@endsection
