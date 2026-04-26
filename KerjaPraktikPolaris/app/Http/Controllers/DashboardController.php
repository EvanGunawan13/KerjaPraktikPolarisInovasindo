<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Penjualan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
{
    $total_produk = \App\Models\Produk::count();
    $stok_menipis = \App\Models\Produk::whereColumn('stok', '<=', 'stok_minimum')->count();
    $total_pendapatan = \App\Models\Transaksi::sum('total_harga');
    
    try {
        $total_pendapatan = \App\Models\Penjualan::sum('total_harga') ?? 0;
    } catch (\Exception $e) {
        $total_pendapatan = 0;
    }

    $produk_terbaru = \App\Models\Produk::with('kategori')->latest()->take(5)->get();

    return view('dashboard', compact('total_produk', 'stok_menipis', 'total_pendapatan', 'produk_terbaru'));
}
}