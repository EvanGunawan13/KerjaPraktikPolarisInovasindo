<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\Pengiriman;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ── Stat Cards ──────────────────────────────────────────────
        // Total nilai aset: stok * harga_beli
        $totalAset = Produk::selectRaw('SUM(stok * harga_beli) as total')
            ->value('total') ?? 0;

        // Transaksi hari ini
        $transaksiHariIni = Transaksi::whereDate('tanggal_pembayaran', today())->count();

        // Produk hampir habis (stok <= stok_minimum)
        $produkHampirHabis = Produk::whereColumn('stok', '<=', 'stok_minimum')->count();

        // Pengiriman aktif (status Perjalanan)
        $pengirimanAktif = Pengiriman::where('status', 'Perjalanan')->count();

        // ── Charts ───────────────────────────────────────────────────
        // Penjualan 7 hari terakhir
        $penjualan7Hari = Transaksi::selectRaw('DATE(tanggal_pembayaran) as tanggal, SUM(total_harga) as total, COUNT(*) as jumlah')
            ->where('tanggal_pembayaran', '>=', now()->subDays(6)->toDateString())
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get()
            ->keyBy('tanggal');

        $labels7Hari  = [];
        $data7Hari    = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $labels7Hari[] = now()->subDays($i)->format('d M');
            $data7Hari[]   = $penjualan7Hari[$date]->total ?? 0;
        }

        // Kategori terpopuler (berdasarkan total stok per kategori)
        $kategoriData = Produk::with('kategori')
            ->selectRaw('kategori_id, SUM(stok) as total_stok')
            ->groupBy('kategori_id')
            ->with('kategori')
            ->get();

        $kategoriLabels = $kategoriData->map(fn($p) => optional($p->kategori)->nama_kategori ?? 'Lainnya')->toArray();
        $kategoriValues = $kategoriData->pluck('total_stok')->toArray();

        // ── Widgets ──────────────────────────────────────────────────
        // Recent pengiriman (5 terbaru)
        $recentPengiriman = Pengiriman::with('produk')
            ->latest()
            ->take(5)
            ->get();

        // Produk perlu restock
        $restockList = Produk::whereColumn('stok', '<=', 'stok_minimum')
            ->with('kategori')
            ->orderBy('stok')
            ->take(8)
            ->get();

        // Activity feed: gabung transaksi & pengiriman terbaru
        $recentTransaksi = Transaksi::with('produk')
            ->latest()
            ->take(5)
            ->get()
            ->map(fn($t) => [
                'type'    => 'transaksi',
                'icon'    => 'fa-receipt',
                'color'   => 'green',
                'text'    => 'Transaksi baru ' . $t->nomor_invoice . ' — ' . ($t->nama_toko ?? 'Toko'),
                'time'    => $t->created_at,
            ]);

        $recentShipping = Pengiriman::with('produk')
            ->latest()
            ->take(5)
            ->get()
            ->map(fn($p) => [
                'type'    => 'pengiriman',
                'icon'    => 'fa-truck',
                'color'   => 'blue',
                'text'    => 'Pengiriman ' . $p->nomor_resi . ' → ' . $p->status,
                'time'    => $p->updated_at,
            ]);

        $activityFeed = $recentTransaksi->concat($recentShipping)
            ->sortByDesc('time')
            ->take(8)
            ->values();

        return view('welcome', compact(
            'totalAset',
            'transaksiHariIni',
            'produkHampirHabis',
            'pengirimanAktif',
            'labels7Hari',
            'data7Hari',
            'kategoriLabels',
            'kategoriValues',
            'recentPengiriman',
            'restockList',
            'activityFeed'
        ));
    }
}