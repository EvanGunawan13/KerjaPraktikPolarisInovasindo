<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProdukController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('produk', ProdukController::class);

Route::get('/transaksi', function() { return 'Halaman Transaksi Segera Hadir'; })->name('penjualan.index');