<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Pengiriman;
use App\Models\Produk;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        $transaksi = Transaksi::with('produk')
            ->whereMonth('tanggal_pembayaran', $bulan)
            ->whereYear('tanggal_pembayaran', $tahun)
            ->latest()
            ->get();

        $totalPendapatan  = $transaksi->sum('total_harga');
        $totalTransaksi   = $transaksi->count();
        $totalItemTerjual = $transaksi->sum('jumlah_jual');

        $pengiriman = Pengiriman::with('produk')
            ->whereMonth('tanggal_kirim', $bulan)
            ->whereYear('tanggal_kirim', $tahun)
            ->latest()
            ->get();

        $totalPengiriman   = $pengiriman->count();
        $pengirimanSampai  = $pengiriman->where('status', 'Sampai')->count();
        $pengirimanJalan   = $pengiriman->where('status', 'Perjalanan')->count();
        $pengirimanMenunggu = $pengiriman->where('status', 'Menunggu')->count();

        $produkTerlaris = Transaksi::with('produk')
            ->whereMonth('tanggal_pembayaran', $bulan)
            ->whereYear('tanggal_pembayaran', $tahun)
            ->get()
            ->groupBy('produk_id')
            ->map(fn($t) => [
                'nama'   => optional($t->first()->produk)->nama_produk ?? 'N/A',
                'jumlah' => $t->sum('jumlah_jual'),
                'total'  => $t->sum('total_harga'),
            ])
            ->sortByDesc('jumlah')
            ->take(5)
            ->values();

        $tahunList = range(date('Y'), date('Y') - 3);

        return view('laporan.index', compact(
            'bulan', 'tahun', 'tahunList',
            'transaksi', 'totalPendapatan', 'totalTransaksi', 'totalItemTerjual',
            'pengiriman', 'totalPengiriman', 'pengirimanSampai', 'pengirimanJalan', 'pengirimanMenunggu',
            'produkTerlaris'
        ));
    }

    public function exportPdf(Request $request)
    {
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        $transaksi = Transaksi::with('produk')
            ->whereMonth('tanggal_pembayaran', $bulan)
            ->whereYear('tanggal_pembayaran', $tahun)
            ->latest()
            ->get();

        $pengiriman = Pengiriman::with('produk')
            ->whereMonth('tanggal_kirim', $bulan)
            ->whereYear('tanggal_kirim', $tahun)
            ->latest()
            ->get();

        $totalPendapatan   = $transaksi->sum('total_harga');
        $totalTransaksi    = $transaksi->count();
        $totalItemTerjual  = $transaksi->sum('jumlah_jual');
        $totalPengiriman   = $pengiriman->count();
        $pengirimanSampai  = $pengiriman->where('status', 'Sampai')->count();
        $pengirimanJalan   = $pengiriman->where('status', 'Perjalanan')->count();
        $pengirimanMenunggu = $pengiriman->where('status', 'Menunggu')->count();

        $namaBulan = \DateTime::createFromFormat('!m', $bulan)->format('F');

        $html = view('laporan.pdf', compact(
            'bulan', 'tahun', 'namaBulan',
            'transaksi', 'totalPendapatan', 'totalTransaksi', 'totalItemTerjual',
            'pengiriman', 'totalPengiriman', 'pengirimanSampai', 'pengirimanJalan', 'pengirimanMenunggu'
        ))->render();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html)
            ->setPaper('a4', 'portrait');

        return $pdf->download("Laporan-Polaris-{$namaBulan}-{$tahun}.pdf");
    }
}