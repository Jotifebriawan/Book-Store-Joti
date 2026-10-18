<?php

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PembeliController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\M5Controller;
use App\Http\Controllers\M6Controller;
use Illuminate\Support\Facades\Route;

// Auth Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/', [PageController::class, 'home'])->name('home');
    
    // Admin & Kasir Core Resources
    Route::resource('kategori', KategoriController::class);
    Route::resource('penjualan', PenjualanController::class);
    Route::resource('produk', ProdukController::class);
    Route::resource('user', UserController::class);

    // Profile & Password
    Route::get('password', [UserController::class, 'password'])->name('user.password');
    Route::post('password', [UserController::class, 'passwordAction'])->name('user.password.action');
    Route::get('logout', [UserController::class, 'logout'])->name('user.logout');

    // Pembeli (Buyer) Storefront, QRIS Payment, and Digital Book Library
    Route::get('/katalog', [PembeliController::class, 'katalog'])->name('pembeli.katalog');
    Route::get('/checkout/{id}', [PembeliController::class, 'checkout'])->name('pembeli.checkout');
    Route::post('/pembayaran/qris', [PembeliController::class, 'prosesBayar'])->name('pembeli.bayar.qris');
    Route::get('/koleksi-buku', [PembeliController::class, 'koleksi'])->name('pembeli.koleksi');
    Route::get('/buku/download/{id}', [PembeliController::class, 'download'])->name('pembeli.download');
    Route::get('/buku/baca/{id}', [PembeliController::class, 'baca'])->name('pembeli.baca');
});

// Guest Auth Routes
Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/login/action', [UserController::class, 'loginAction'])->name('user.login.action');
Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/register/action', [UserController::class, 'registerAction'])->name('user.register.action');

// Academic Modules (M5 & M6)
Route::get('m6/lat2', [M6Controller::class, 'lat2']);
Route::post('m6/lat2_action', [M6Controller::class, 'lat2Action'])->name('m6.lat2.action');
Route::get('/m6/lat1', [M6Controller::class, 'lat1']);
Route::get('/m5/lat4', [M5Controller::class, 'lat4']);
Route::get('/m5/lat3', [M5Controller::class, 'lat3']);
Route::get('/m5/lat2', [M5Controller::class, 'lat2']);
Route::get('/m5/lat1', [M5Controller::class, 'lat1']);