<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::prefix('master')->group(function () {
});

Route::prefix('transaksi')->group(function () {
});