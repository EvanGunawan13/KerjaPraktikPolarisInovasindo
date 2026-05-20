<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PengirimanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaporanController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

Route::middleware('auth')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
    Route::middleware('role:kepala_cabang,gudang')->group(function () {
        Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
        Route::put('/produk/{produk}', [ProdukController::class, 'update'])->name('produk.update');
        Route::delete('/produk/{produk}', [ProdukController::class, 'destroy'])->name('produk.destroy');
    });

    Route::middleware('role:kepala_cabang,pembukuan')->group(function () {
        Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
        Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
        Route::get('/transaksi/{transaksi}/edit', [TransaksiController::class, 'edit'])->name('transaksi.edit');
        Route::put('/transaksi/{transaksi}', [TransaksiController::class, 'update'])->name('transaksi.update');
        Route::delete('/transaksi/{transaksi}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');
    });

    Route::get('/pengiriman', [PengirimanController::class, 'index'])->name('pengiriman.index');
    Route::middleware('role:kepala_cabang,gudang')->group(function () {
        Route::post('/pengiriman', [PengirimanController::class, 'store'])->name('pengiriman.store');
        Route::put('/pengiriman/{pengiriman}', [PengirimanController::class, 'update'])->name('pengiriman.update');
        Route::delete('/pengiriman/{pengiriman}', [PengirimanController::class, 'destroy'])->name('pengiriman.destroy');
    });

    Route::middleware('role:kepala_cabang,pembukuan')->group(function () {
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.exportPdf');
    });

    Route::middleware('role:kepala_cabang')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

});