<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Penjualan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $total_produk = Produk::count();
        $stok_menipis = Produk::whereColumn('stok', '<=', 'stok_minimum')->count();
        $total_pendapatan = Penjualan::sum('total_harga') ?? 0;
        $produk_terbaru = Produk::with('Kategori')->latest()->take(5)->get();

        return view('dashboard', compact(
            'total_produk', 
            'stok_menipis', 
            'total_pendapatan', 
            'produk_terbaru'
        ));
    }
}