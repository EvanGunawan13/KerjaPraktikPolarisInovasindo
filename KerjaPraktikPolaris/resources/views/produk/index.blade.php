@extends('dashboard')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-slate-800">Manajemen Stok Polaris</h2>
        <button onclick="document.getElementById('modalTambah').classList.remove('hidden')" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            <i class="fa fa-plus mr-2"></i> Tambah Produk
        </button>
    </div>

    @if(session('success'))
        <div class="bg-green-500 text-white p-3 rounded-lg mb-4">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-xl shadow border overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-slate-50 border-b">
                <tr class="text-xs font-bold text-slate-500 uppercase">
                    <th class="p-4">SKU</th>
                    <th class="p-4">Nama Barang</th>
                    <th class="p-4">Kategori</th>
                    <th class="p-4 text-center">Stok</th>
                    <th class="p-4 text-right">Harga Jual</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($produk as $p)
                <tr class="hover:bg-slate-50">
                    <td class="p-4 text-sm font-mono">{{ $p->sku }}</td>
                    <td class="p-4 font-semibold">{{ $p->nama_produk }}</td>
                    <td class="p-4 text-sm text-slate-500">{{ $p->kategori->nama_kategori ?? 'N/A' }}</td>
                    <td class="p-4 text-center">{{ $p->stok }}</td>
                    <td class="p-4 text-right">Rp {{ number_format($p->harga_jual, 0, ',', '.') }}</td>
                    <td class="p-4 text-center flex justify-center gap-2">
                        <button onclick="openEditModal({{ $p }})" class="text-amber-500 hover:bg-amber-50 p-2 rounded">
                            <i class="fa fa-edit"></i>
                        </button>
                        <form action="{{ route('produk.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus barang?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:bg-red-50 p-2 rounded">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div id="modalTambah" class="hidden fixed inset-0 bg-slate-900/50 flex items-center justify-center z-50 p-4">
    <div class="bg-white w-full max-w-md rounded-xl p-6">
        <h3 class="text-lg font-bold mb-4">Tambah Produk Baru</h3>
        <form action="{{ route('produk.store') }}" method="POST" class="space-y-4">
            @csrf
            <input type="text" name="nama_produk" class="w-full border rounded p-2" placeholder="Nama Produk" required>
            <input type="text" name="sku" class="w-full border rounded p-2" placeholder="SKU (Contoh: KRS-001)" required>
            <select name="kategori_id" class="w-full border rounded p-2" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($kategori as $kat)
                    <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                @endforeach
            </select>
            <div class="grid grid-cols-2 gap-4">
                <input type="number" name="stok" class="border rounded p-2" placeholder="Stok" required>
                <input type="number" name="stok_minimum" class="border rounded p-2" placeholder="Stok Min" required>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <input type="number" name="harga_beli" class="border rounded p-2" placeholder="Harga Beli" required>
                <input type="number" name="harga_jual" class="border rounded p-2" placeholder="Harga Jual" required>
            </div>
            <div class="flex gap-2">
                <button type="button" onclick="document.getElementById('modalTambah').classList.add('hidden')" class="flex-1 border py-2 rounded">Batal</button>
                <button type="submit" class="flex-1 bg-blue-600 text-white py-2 rounded">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div id="modalEdit" class="hidden fixed inset-0 bg-slate-900/50 flex items-center justify-center z-50 p-4">
    <div class="bg-white w-full max-w-md rounded-xl p-6 shadow-2xl">
        <h3 class="text-lg font-bold mb-4">Edit Produk</h3>
        <form id="formEdit" method="POST" class="space-y-4">
            @csrf @method('PUT')
            <input type="text" name="nama_produk" id="edit_nama" class="w-full border rounded p-2" placeholder="Nama Produk" required>
            <input type="text" name="sku" id="edit_sku" class="w-full border rounded p-2" placeholder="SKU" required>
            <select name="kategori_id" id="edit_kategori" class="w-full border rounded p-2" required>
                @foreach($kategori as $kat)
                    <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                @endforeach
            </select>
            <div class="grid grid-cols-2 gap-4">
                <input type="number" name="stok" id="edit_stok" class="border rounded p-2" placeholder="Stok" required>
                {{-- ✅ TAMBAH INI --}}
                <input type="number" name="stok_minimum" id="edit_stok_minimum" class="border rounded p-2" placeholder="Stok Min" required>
            </div>
            <div class="grid grid-cols-2 gap-4">
                {{-- ✅ TAMBAH INI --}}
                <input type="number" name="harga_beli" id="edit_harga_beli" class="border rounded p-2" placeholder="Harga Beli" required>
                <input type="number" name="harga_jual" id="edit_harga_jual" class="border rounded p-2" placeholder="Harga Jual" required>
            </div>
            <div class="flex gap-2">
                <button type="button" onclick="document.getElementById('modalEdit').classList.add('hidden')" class="flex-1 border py-2 rounded">Batal</button>
                <button type="submit" class="flex-1 bg-amber-500 text-white py-2 rounded">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditModal(produk) {
    document.getElementById('formEdit').action = '/produk/' + produk.id;
    document.getElementById('edit_nama').value = produk.nama_produk;
    document.getElementById('edit_sku').value = produk.sku;
    document.getElementById('edit_kategori').value = produk.kategori_id;
    document.getElementById('edit_stok').value = produk.stok;
    document.getElementById('edit_stok_minimum').value = produk.stok_minimum; // ✅ TAMBAH
    document.getElementById('edit_harga_beli').value = produk.harga_beli;     // ✅ TAMBAH
    document.getElementById('edit_harga_jual').value = produk.harga_jual;
    document.getElementById('modalEdit').classList.remove('hidden');
}
</script>
@endsection