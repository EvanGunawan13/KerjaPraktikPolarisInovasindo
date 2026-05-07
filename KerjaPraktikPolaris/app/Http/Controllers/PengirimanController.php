<?php

namespace App\Http\Controllers;

use App\Models\Pengiriman;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengirimanController extends Controller
{
    public function index()
    {
        $pengiriman = Pengiriman::with(['produk', 'transaksi', 'user'])
            ->latest()
            ->get();

        $produk    = Produk::all();
        $transaksi = Transaksi::latest()->take(50)->get();

        $stats = [
            'menunggu'   => Pengiriman::where('status', 'Menunggu')->count(),
            'perjalanan' => Pengiriman::where('status', 'Perjalanan')->count(),
            'sampai'     => Pengiriman::where('status', 'Sampai')->count(),
        ];

        return view('pengiriman.index', compact('pengiriman', 'produk', 'transaksi', 'stats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_penerima' => 'required|string',
            'alamat_tujuan' => 'required|string',
            'produk_id'     => 'required|exists:produk,id',
            'jumlah'        => 'required|numeric|min:1',
            'tanggal_kirim' => 'required|date',
        ]);

        Pengiriman::create([
            'transaksi_id'  => $request->transaksi_id ?: null,
            'produk_id'     => $request->produk_id,
            'user_id'       => Auth::id() ?? 1,
            'nomor_resi'    => 'PLR-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6)),
            'nama_penerima' => $request->nama_penerima,
            'nama_toko'     => $request->nama_toko,
            'alamat_tujuan' => $request->alamat_tujuan,
            'jumlah'        => $request->jumlah,
            'status'        => 'Menunggu',
            'tanggal_kirim' => $request->tanggal_kirim,
            'catatan'       => $request->catatan,
        ]);

        return redirect()->back()->with('success', 'Pengiriman berhasil dibuat!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Menunggu,Perjalanan,Sampai',
        ]);

        $pengiriman = Pengiriman::findOrFail($id);
        $pengiriman->update([
            'status'         => $request->status,
            'tanggal_sampai' => $request->status === 'Sampai' ? now()->toDateString() : $pengiriman->tanggal_sampai,
            'catatan'        => $request->catatan ?? $pengiriman->catatan,
        ]);

        return redirect()->back()->with('success', 'Status pengiriman diperbarui!');
    }

    public function destroy($id)
    {
        Pengiriman::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data pengiriman dihapus!');
    }
}