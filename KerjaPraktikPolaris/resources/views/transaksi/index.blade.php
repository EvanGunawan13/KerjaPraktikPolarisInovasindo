@extends('dashboard')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold mb-4 text-slate-800">Pembukuan Transaksi Polaris</h2>

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
                    <input type="number" name="jumlah_jual" class="w-full border rounded-lg p-2.5" placeholder="Berapa pcs?" required>
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
    
    </div>
@endsection