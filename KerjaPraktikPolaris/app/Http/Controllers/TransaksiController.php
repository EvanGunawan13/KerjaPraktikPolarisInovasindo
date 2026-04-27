<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaksi;
use App\Models\Produk;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::latest()->get();
        $produk = Produk::all();

        return view('transaksi.index', compact('transaksi', 'produk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'jumlah_jual' => 'required|numeric|min:1',
            'total_harga' => 'required|numeric|min:0',
            'bayar' => 'required|numeric|min:0',
            'tanggal_pembayaran' => 'required|date',
        ]);

        $produk = Produk::findOrFail($request->produk_id);

        if ($produk->stok < $request->jumlah_jual) {
            return back()->with('error', 'Stok tidak cukup! Sisa: ' . $produk->stok);
        }

        try {
            DB::transaction(function () use ($request, $produk) {
                $kembalian = $request->bayar - $request->total_harga;

                Transaksi::create([
                    'nomor_invoice' => 'INV-' . date('Ymd') . '-' . strtoupper(uniqid()),
                    'produk_id' => $request->produk_id,
                    'jumlah_jual' => $request->jumlah_jual,
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

            return back()->with('success', 'Transaksi berhasil disimpan dan stok berkurang!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'jumlah_jual' => 'required|numeric|min:1',
            'total_harga' => 'required|numeric|min:0',
            'bayar' => 'required|numeric|min:0',
            'tanggal_pembayaran' => 'required|date',
        ]);

        try {
            DB::transaction(function () use ($request, $id) {
                $transaksi = Transaksi::findOrFail($id);

                $produkLama = Produk::findOrFail($transaksi->produk_id);
                $produkBaru = Produk::findOrFail($request->produk_id);

                $produkLama->increment('stok', $transaksi->jumlah_jual);

                if ($produkBaru->stok < $request->jumlah_jual) {
                    throw new \Exception('Stok produk baru tidak cukup! Sisa: ' . $produkBaru->stok);
                }

                $produkBaru->decrement('stok', $request->jumlah_jual);

                $kembalian = $request->bayar - $request->total_harga;

                $transaksi->update([
                    'produk_id' => $request->produk_id,
                    'jumlah_jual' => $request->jumlah_jual,
                    'nama_toko' => $request->nama_toko,
                    'nomor_nota' => $request->nomor_nota,
                    'total_harga' => $request->total_harga,
                    'bayar' => $request->bayar,
                    'kembalian' => $kembalian,
                    'tanggal_pembayaran' => $request->tanggal_pembayaran,
                ]);
            });

            return back()->with('success', 'Data transaksi berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal update transaksi: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $transaksi = Transaksi::findOrFail($id);

                $produk = Produk::findOrFail($transaksi->produk_id);
                $produk->increment('stok', $transaksi->jumlah_jual);

                $transaksi->delete();
            });

            return back()->with('success', 'Transaksi berhasil dihapus dan stok dikembalikan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus transaksi: ' . $e->getMessage());
        }
    }
}