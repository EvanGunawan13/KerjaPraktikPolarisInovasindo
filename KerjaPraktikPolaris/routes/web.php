<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PengirimanController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('produk', ProdukController::class);
Route::resource('transaksi', TransaksiController::class);
Route::resource('pengiriman', PengirimanController::class);