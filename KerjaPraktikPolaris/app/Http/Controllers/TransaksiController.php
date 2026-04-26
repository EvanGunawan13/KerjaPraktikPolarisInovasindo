<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaksi;
use App\Models\Produk;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
{
    $transaksi = Transaksi::latest()->get();    
    $produk = \App\Models\Produk::all(); 
    
    return view('transaksi.index', compact('transaksi', 'produk'));
}

    public function store(Request $request)
    {
    $request->validate([
        'produk_id' => 'required',
        'jumlah_jual' => 'required|numeric|min:1',
        'total_harga' => 'required|numeric',
        'bayar' => 'required|numeric',
        'tanggal_pembayaran' => 'required|date',
    ]);

    $produk = \App\Models\Produk::find($request->produk_id);
    
    if (!$produk) {
        return redirect()->back()->with('error', 'Produk tidak ditemukan!');
    }

    if ($produk->stok < $request->jumlah_jual) {
        return redirect()->back()->with('error', 'Stok ' . $produk->nama_produk . ' tidak cukup! Sisa: ' . $produk->stok);
    }
    try {
        DB::transaction(function () use ($request, $produk) {
            $kembalian = $request->bayar - $request->total_harga;

            // Simpan Transaksi
            \App\Models\Transaksi::create([
                'nomor_invoice' => 'INV-' . date('YmdHis'),
                'nama_toko' => $request->nama_toko,
                'nomor_nota' => $request->nomor_nota,
                'total_harga' => $request->total_harga,
                'bayar' => $request->bayar,
                'kembalian' => $kembalian,
                'tanggal_pembayaran' => $request->tanggal_pembayaran,
                'user_id' => Auth::id() ?? 1,
            ]);

            $produk->decrement('stok', $request->jumlah_jual);
        });

        return redirect()->back()->with('success', 'Transaksi Berhasil & Stok Berkurang!');
        
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}

    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $kembalian = $request->bayar - $request->total_harga;   

        $transaksi->update([
            'nama_toko' => $request->nama_toko,
            'nomor_nota' => $request->nomor_nota,
            'total_harga' => $request->total_harga,
            'bayar' => $request->bayar,
            'kembalian' => $kembalian,
            'tanggal_pembayaran' => $request->tanggal_pembayaran,
        ]);

        return redirect()->back()->with('success', 'Data transaksi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Transaksi::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Transaksi berhasil dihapus!');
    }
}