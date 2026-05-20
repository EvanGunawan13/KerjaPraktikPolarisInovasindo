@extends('dashboard')

@section('content')
<div class="p-6 max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold mb-6 text-slate-800">Edit Transaksi</h2>

    @if(session('error'))
        <div class="bg-red-500 text-white p-3 rounded-lg mb-4">{{ session('error') }}</div>
    @endif

    <div class="bg-white p-6 rounded-xl shadow border">
        <form action="{{ route('transaksi.update', $transaksi->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Nama Toko</label>
                    <input type="text" name="nama_toko" value="{{ $transaksi->nama_toko }}"
                        class="w-full border rounded-lg p-2.5">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Nomor Nota</label>
                    <input type="text" name="nomor_nota" value="{{ $transaksi->nomor_nota }}"
                        class="w-full border rounded-lg p-2.5">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Pilih Produk</label>
                    <select name="produk_id" class="w-full border rounded-lg p-2.5" required>
                        <option value="">-- Pilih Barang --</option>
                        @foreach($produk as $p)
                            <option value="{{ $p->id }}" {{ $transaksi->produk_id == $p->id ? 'selected' : '' }}>
                                {{ $p->nama_produk }} (Stok: {{ $p->stok }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Jumlah Jual</label>
                    <input type="number" name="jumlah_jual" value="{{ $transaksi->jumlah_jual }}"
                        class="w-full border rounded-lg p-2.5" min="1" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium mb-1">Total Harga</label>
                    <input type="number" name="total_harga" value="{{ $transaksi->total_harga }}"
                        class="w-full border rounded-lg p-2.5" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Bayar</label>
                    <input type="number" name="bayar" value="{{ $transaksi->bayar }}"
                        class="w-full border rounded-lg p-2.5" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Tanggal</label>
                    <input type="date" name="tanggal_pembayaran" value="{{ $transaksi->tanggal_pembayaran }}"
                        class="w-full border rounded-lg p-2.5" required>
                </div>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('transaksi.index') }}"
                    class="flex-1 text-center border py-2.5 rounded-lg hover:bg-slate-50">Batal</a>
                <button type="submit"
                    class="flex-1 bg-amber-500 text-white py-2.5 rounded-lg font-bold hover:bg-amber-600">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection