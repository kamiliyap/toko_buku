<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\EnsureUserIsAdmin;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\BukuUserController;
use App\Http\Controllers\UserBukuController;
use App\Http\Controllers\CartController;



// CONTROLLER ADMIN
use App\Http\Controllers\Admin\BukuController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\PenerbitController;
use App\Http\Controllers\Admin\PesananController;
use App\Http\Controllers\Admin\SettingsController;

// =========================
// HALAMAN DEPAN
// =========================
Route::get('/', [HomeController::class, 'index'])->name('home');

// =========================
// BERITA (FRONT / UMUM)
// =========================
Route::resource('berita', BeritaController::class);

// =========================
/** LOGIN / AUTH */
// =========================
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.attempt');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// =========================
// ADMIN AREA (URL: /admin/...)
// =========================
Route::prefix('admin')->middleware(EnsureUserIsAdmin::class)->group(function () {

    // Dashboard admin
    Route::get('/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');

    // CRUD Buku (URL: /admin/buku, nama route: buku.*)
    Route::resource('buku', BukuController::class);

    // CRUD Kategori (URL: /admin/kategori, nama route: kategori.*)
    Route::resource('kategori', KategoriController::class);

    // CRUD Penerbit (URL: /admin/penerbit, nama route: penerbit.*)
    Route::resource('penerbit', PenerbitController::class);

    // ====== PESANAN ADMIN ======
    // LIST SEMUA PESANAN
    Route::get('pesanan', [PesananController::class, 'index'])->name('pesanan.index');

    // FORM EDIT PESANAN
    Route::get('pesanan/{id}/edit', [PesananController::class, 'edit'])->name('pesanan.edit');

    // PROSES UPDATE PESANAN
    Route::put('pesanan/{id}', [PesananController::class, 'update'])->name('pesanan.update');

    // HAPUS PESANAN
    Route::delete('pesanan/{id}', [PesananController::class, 'destroy'])->name('pesanan.destroy');

    // USER ADMIN
    Route::get('user', [UserController::class, 'index'])->name('admin.user.index');
    Route::get('user/create', [UserController::class, 'create'])->name('admin.user.create');
    Route::post('user', [UserController::class, 'store'])->name('admin.user.store');

    // PENGATURAN
    Route::get('pengaturan', [SettingsController::class, 'edit'])->name('admin.settings.edit');
    Route::put('pengaturan/profil', [SettingsController::class, 'updateProfile'])->name('admin.settings.profile.update');
    Route::put('pengaturan/toko', [SettingsController::class, 'updateStore'])->name('admin.settings.store.update');
});

// =========================
// PEMBELIAN & KERANJANG
// (PAKAI PembelianController SAJA)
// =========================

// Daftar buku untuk pembelian
Route::get('/pembelian/buku', [PembelianController::class, 'indexBuku'])
    ->name('pembelian.buku_index');

// KERANJANG
Route::get('/cart', [PembelianController::class, 'cart'])
    ->name('cart.index');

Route::post('/cart/add/{id}', [PembelianController::class, 'addToCart'])
    ->name('cart.add');

Route::post('/cart/update/{id}', [PembelianController::class, 'updateCart'])
    ->name('cart.update');

Route::delete('/cart/remove/{id}', [PembelianController::class, 'removeFromCart'])
    ->name('cart.remove');

// CHECKOUT
Route::get('/checkout', [PembelianController::class, 'checkoutForm'])
    ->name('checkout.form');

Route::post('/checkout', [PembelianController::class, 'prosesCheckout'])
    ->name('checkout.proses');

// SELESAI / DETAIL PESANAN
Route::get('/pembelian/selesai/{id}', [PembelianController::class, 'selesai'])
    ->name('pembelian.selesai');

Route::get('/pembelian/{id}/nota', [PembelianController::class, 'downloadPdf'])
    ->name('pembelian.nota');

Route::get('/pembelian/{id}/detail', [PembelianController::class, 'detail'])
    ->name('pembelian.detail');

// PEMBELIAN - BATALKAN
Route::delete('/pembelian/batal/{id}', [PembelianController::class, 'batalkan'])
    ->name('pembelian.batalkan');



// USER – daftar buku
Route::get('/buku', [UserBukuController::class, 'index'])
    ->name('user.buku.index');

// USER – detail buku
Route::get('/buku/{id}', [UserBukuController::class, 'show'])
    ->name('user.buku.show');
