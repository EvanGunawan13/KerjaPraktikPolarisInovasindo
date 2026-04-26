<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('produk', ProdukController::class);
Route::resource('transaksi', TransaksiController::class);

Route::get('/transaksi', function() { return 'Halaman Transaksi Segera Hadir'; })->name('penjualan.index');

Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');