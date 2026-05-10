@extends('dashboard')

@section('content')
<div class="p-6 space-y-6">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Rekap Laporan Bulanan</h2>
            <p class="text-sm text-slate-400 mt-0.5">Ringkasan transaksi & pengiriman untuk dikirim ke pusat</p>
        </div>

        <form method="GET" action="{{ route('laporan.index') }}" class="flex gap-2 items-center">
            <select name="bulan" class="border rounded-lg px-3 py-2 text-sm bg-white">
                @foreach(range(1,12) as $b)
                    <option value="{{ $b }}" {{ $bulan == $b ? 'selected' : '' }}>
                        {{ DateTime::createFromFormat('!m', $b)->format('F') }}
                    </option>
                @endforeach
            </select>
            <select name="tahun" class="border rounded-lg px-3 py-2 text-sm bg-white">
                @foreach($tahunList as $t)
                    <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-slate-700 text-white px-4 py-2 rounded-lg text-sm hover:bg-slate-800">
                <i class="fa fa-filter mr-1"></i> Filter
            </button>
            <a href="{{ route('laporan.exportPdf', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
               class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-700 flex items-center gap-2">
                <i class="fa fa-file-pdf"></i> Export PDF
            </a>
        </form>
    </div>

    @php
        $namaBulan = DateTime::createFromFormat('!m', $bulan)->format('F');
    @endphp


    <div class="bg-blue-50 border border-blue-200 rounded-xl px-4 py-3 text-sm text-blue-700 font-medium">
        <i class="fa fa-calendar mr-2"></i>
        Menampilkan laporan periode: <strong>{{ $namaBulan }} {{ $tahun }}</strong>
    </div>

    <div class="grid grid-cols-2 xl:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl border shadow-sm p-5">
            <p class="text-xs text-slate-500 uppercase font-medium mb-1">Total Pendapatan</p>
            <p class="text-xl font-bold text-green-600">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
            <p class="text-xs text-slate-400 mt-1">{{ $totalTransaksi }} nota transaksi</p>
        </div>
        <div class="bg-white rounded-2xl border shadow-sm p-5">
            <p class="text-xs text-slate-500 uppercase font-medium mb-1">Item Terjual</p>
            <p class="text-xl font-bold text-blue-600">{{ number_format($totalItemTerjual, 0, ',', '.') }}</p>
            <p class="text-xs text-slate-400 mt-1">Total pcs terjual</p>
        </div>
        <div class="bg-white rounded-2xl border shadow-sm p-5">
            <p class="text-xs text-slate-500 uppercase font-medium mb-1">Total Pengiriman</p>
            <p class="text-xl font-bold text-slate-800">{{ $totalPengiriman }}</p>
            <p class="text-xs text-slate-400 mt-1">Pengiriman bulan ini</p>
        </div>
        <div class="bg-white rounded-2xl border shadow-sm p-5">
            <p class="text-xs text-slate-500 uppercase font-medium mb-1">Berhasil Sampai</p>
            <p class="text-xl font-bold text-emerald-600">{{ $pengirimanSampai }}</p>
            <p class="text-xs text-slate-400 mt-1">Dari {{ $totalPengiriman }} pengiriman</p>
        </div>
    </div>

    @if($produkTerlaris->isNotEmpty())
    <div class="bg-white rounded-2xl border shadow-sm p-6">
        <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
            <i class="fa fa-trophy text-amber-500"></i> Produk Terlaris Bulan Ini
        </h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-xs uppercase text-slate-500 font-bold border-b">
                    <tr>
                        <th class="p-3">#</th>
                        <th class="p-3">Nama Produk</th>
                        <th class="p-3 text-center">Jumlah Terjual</th>
                        <th class="p-3 text-right">Total Pendapatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($produkTerlaris as $i => $p)
                    <tr class="hover:bg-slate-50">
                        <td class="p-3 font-bold text-slate-400">{{ $i + 1 }}</td>
                        <td class="p-3 font-semibold">{{ $p['nama'] }}</td>
                        <td class="p-3 text-center">{{ $p['jumlah'] }} pcs</td>
                        <td class="p-3 text-right text-green-600 font-medium">Rp {{ number_format($p['total'], 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <div class="bg-white rounded-2xl border shadow-sm overflow-hidden">
        <div class="p-5 border-b flex items-center justify-between">
            <h3 class="font-bold text-slate-800 flex items-center gap-2">
                <i class="fa fa-receipt text-green-500"></i> Detail Transaksi
            </h3>
            <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full font-medium">
                {{ $totalTransaksi }} transaksi
            </span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-xs uppercase text-slate-500 font-bold border-b">
                    <tr>
                        <th class="p-4">Invoice</th>
                        <th class="p-4">Toko</th>
                        <th class="p-4">Produk</th>
                        <th class="p-4 text-center">Jml</th>
                        <th class="p-4 text-right">Total</th>
                        <th class="p-4 text-right">Bayar</th>
                        <th class="p-4 text-right">Kembalian</th>
                        <th class="p-4 text-center">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($transaksi as $t)
                    <tr class="hover:bg-slate-50">
                        <td class="p-4 font-mono text-xs">{{ $t->nomor_invoice }}</td>
                        <td class="p-4">{{ $t->nama_toko ?? '-' }}</td>
                        <td class="p-4">{{ optional($t->produk)->nama_produk ?? '-' }}</td>
                        <td class="p-4 text-center">{{ $t->jumlah_jual }}</td>
                        <td class="p-4 text-right font-medium text-green-600">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                        <td class="p-4 text-right">Rp {{ number_format($t->bayar, 0, ',', '.') }}</td>
                        <td class="p-4 text-right">Rp {{ number_format($t->kembalian, 0, ',', '.') }}</td>
                        <td class="p-4 text-center text-xs text-slate-500">{{ $t->tanggal_pembayaran }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="p-6 text-center text-slate-400">Tidak ada transaksi bulan ini.</td>
                    </tr>
                    @endforelse
                </tbody>
                @if($transaksi->isNotEmpty())
                <tfoot class="bg-slate-50 border-t font-bold text-sm">
                    <tr>
                        <td colspan="4" class="p-4 text-right text-slate-600">TOTAL:</td>
                        <td class="p-4 text-right text-green-600">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                        <td colspan="3"></td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>

    <div class="bg-white rounded-2xl border shadow-sm overflow-hidden">
        <div class="p-5 border-b flex items-center justify-between">
            <h3 class="font-bold text-slate-800 flex items-center gap-2">
                <i class="fa fa-truck text-blue-500"></i> Detail Pengiriman
            </h3>
            <div class="flex gap-2 text-xs">
                <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full font-medium">Sampai: {{ $pengirimanSampai }}</span>
                <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full font-medium">Jalan: {{ $pengirimanJalan }}</span>
                <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full font-medium">Menunggu: {{ $pengirimanMenunggu }}</span>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-xs uppercase text-slate-500 font-bold border-b">
                    <tr>
                        <th class="p-4">No. Resi</th>
                        <th class="p-4">Penerima</th>
                        <th class="p-4">Produk</th>
                        <th class="p-4 text-center">Jml</th>
                        <th class="p-4 text-center">Tgl Kirim</th>
                        <th class="p-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($pengiriman as $pg)
                    <tr class="hover:bg-slate-50">
                        <td class="p-4 font-mono text-xs">{{ $pg->nomor_resi }}</td>
                        <td class="p-4">
                            <p class="font-semibold">{{ $pg->nama_penerima }}</p>
                            <p class="text-xs text-slate-400">{{ $pg->nama_toko ?? $pg->alamat_tujuan }}</p>
                        </td>
                        <td class="p-4">{{ optional($pg->produk)->nama_produk ?? '-' }}</td>
                        <td class="p-4 text-center">{{ $pg->jumlah }}</td>
                        <td class="p-4 text-center text-xs text-slate-500">{{ $pg->tanggal_kirim }}</td>
                        <td class="p-4 text-center">
                            @php
                                $badge = ['Menunggu' => 'bg-yellow-100 text-yellow-700', 'Perjalanan' => 'bg-blue-100 text-blue-700', 'Sampai' => 'bg-green-100 text-green-700'][$pg->status] ?? 'bg-gray-100 text-gray-600';
                            @endphp
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $badge }}">{{ $pg->status }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-6 text-center text-slate-400">Tidak ada pengiriman bulan ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection