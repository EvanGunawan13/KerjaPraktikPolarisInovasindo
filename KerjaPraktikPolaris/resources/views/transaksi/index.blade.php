@extends('dashboard')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold mb-4 text-slate-800">Pembukuan Transaksi Polaris</h2>

    @if(session('success'))
        <div class="bg-green-500 text-white p-3 rounded-lg mb-4">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="bg-red-500 text-white p-3 rounded-lg mb-4">{{ session('error') }}</div>
    @endif

    {{-- Form Tambah Transaksi --}}
    <div class="bg-white p-6 rounded-xl shadow border mb-6">
        <form action="{{ route('transaksi.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <input type="text" name="nama_toko" placeholder="Nama Toko" class="border rounded-lg p-2.5">
                <input type="text" name="nomor_nota" placeholder="Nomor Nota" class="border rounded-lg p-2.5">
                <input type="date" name="tanggal_pembayaran" class="border rounded-lg p-2.5" value="{{ date('Y-m-d') }}">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Pilih Produk</label>
                    <select name="produk_id" class="w-full border rounded-lg p-2.5" required>
                        <option value="">-- Pilih Barang --</option>
                        @foreach($produk as $p)
                            <option value="{{ $p->id }}">{{ $p->nama_produk }} (Stok: {{ $p->stok }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Jumlah Jual</label>
                    <input type="number" name="jumlah_jual" class="w-full border rounded-lg p-2.5" placeholder="Berapa pcs?" min="1" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <input type="number" name="total_harga" placeholder="Total Harga (Rp)" class="border rounded-lg p-2.5" required>
                <input type="number" name="bayar" placeholder="Bayar (Rp)" class="border rounded-lg p-2.5" required>
                <button type="submit" class="bg-blue-600 text-white rounded-lg p-2.5 font-bold hover:bg-blue-700">
                    Simpan Transaksi
                </button>
            </div>
        </form>
    </div>

    {{-- Tabel Riwayat Transaksi --}}
    <div class="bg-white rounded-xl shadow border overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-slate-50 border-b">
                <tr class="text-xs font-bold text-slate-500 uppercase">
                    <th class="p-4">Invoice</th>
                    <th class="p-4">Toko</th>
                    <th class="p-4">Produk</th>
                    <th class="p-4 text-center">Jml</th>
                    <th class="p-4 text-right">Total</th>
                    <th class="p-4 text-right">Bayar</th>
                    <th class="p-4 text-right">Kembalian</th>
                    <th class="p-4 text-center">Tanggal</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($transaksi as $t)
                <tr class="hover:bg-slate-50">
                    <td class="p-4 text-sm font-mono">{{ $t->nomor_invoice }}</td>
                    <td class="p-4">{{ $t->nama_toko ?? '-' }}</td>
                    <td class="p-4">{{ optional($t->produk)->nama_produk ?? '-' }}</td>
                    <td class="p-4 text-center">{{ $t->jumlah_jual }}</td>
                    <td class="p-4 text-right">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                    <td class="p-4 text-right">Rp {{ number_format($t->bayar, 0, ',', '.') }}</td>
                    <td class="p-4 text-right">Rp {{ number_format($t->kembalian, 0, ',', '.') }}</td>
                    <td class="p-4 text-center text-sm">{{ $t->tanggal_pembayaran }}</td>
                    <td class="p-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('transaksi.edit', $t->id) }}"
                               class="bg-yellow-500 text-white px-3 py-2 rounded-lg text-sm hover:bg-yellow-600">
                                Edit
                            </a>

                            <form action="{{ route('transaksi.destroy', $t->id) }}" method="POST" onsubmit="return confirm('Hapus transaksi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-3 py-2 rounded-lg text-sm hover:bg-red-600">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="p-6 text-center text-slate-400">Belum ada transaksi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection