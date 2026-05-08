@extends('dashboard')

@section('content')
<div class="p-6 space-y-6">

    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Status Pengiriman</h2>
            <p class="text-sm text-slate-400 mt-0.5">Pantau semua pengiriman barang ke toko</p>
        </div>
        <button onclick="document.getElementById('modalTambah').classList.remove('hidden')"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm font-medium">
            <i class="fa fa-plus mr-2"></i> Buat Pengiriman
        </button>
    </div>

    @if(session('success'))
        <div class="bg-green-500 text-white p-3 rounded-lg">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-500 text-white p-3 rounded-lg">{{ session('error') }}</div>
    @endif


    <div class="grid grid-cols-3 gap-4">
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 flex items-center gap-3">
            <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                <i class="fa-solid fa-clock text-yellow-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-yellow-700">{{ $stats['menunggu'] }}</p>
                <p class="text-xs text-yellow-600">Menunggu</p>
            </div>
        </div>
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 flex items-center gap-3">
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fa-solid fa-truck text-blue-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-blue-700">{{ $stats['perjalanan'] }}</p>
                <p class="text-xs text-blue-600">Dalam Perjalanan</p>
            </div>
        </div>
        <div class="bg-green-50 border border-green-200 rounded-xl p-4 flex items-center gap-3">
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="fa-solid fa-circle-check text-green-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-green-700">{{ $stats['sampai'] }}</p>
                <p class="text-xs text-green-600">Sudah Sampai</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 border-b">
                <tr class="text-xs font-bold text-slate-500 uppercase">
                    <th class="p-4">No. Resi</th>
                    <th class="p-4">Penerima / Toko</th>
                    <th class="p-4">Produk</th>
                    <th class="p-4 text-center">Jml</th>
                    <th class="p-4 text-center">Tgl Kirim</th>
                    <th class="p-4 text-center">Status</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($pengiriman as $pg)
                <tr class="hover:bg-slate-50">
                    <td class="p-4 font-mono text-xs text-slate-600">{{ $pg->nomor_resi }}</td>
                    <td class="p-4">
                        <p class="font-semibold text-slate-800">{{ $pg->nama_penerima }}</p>
                        <p class="text-xs text-slate-400">{{ $pg->nama_toko ?? $pg->alamat_tujuan }}</p>
                    </td>
                    <td class="p-4">{{ optional($pg->produk)->nama_produk ?? '-' }}</td>
                    <td class="p-4 text-center">{{ $pg->jumlah }}</td>
                    <td class="p-4 text-center text-xs text-slate-500">{{ $pg->tanggal_kirim }}</td>
                    <td class="p-4 text-center">
                        @php
                            $badge = [
                                'Menunggu'   => 'bg-yellow-100 text-yellow-700',
                                'Perjalanan' => 'bg-blue-100 text-blue-700',
                                'Sampai'     => 'bg-green-100 text-green-700',
                            ][$pg->status] ?? 'bg-gray-100 text-gray-600';
                        @endphp
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $badge }}">
                            {{ $pg->status }}
                        </span>
                    </td>
                    <td class="p-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <button onclick="openEditModal({{ $pg->id }}, '{{ $pg->status }}', '{{ addslashes($pg->catatan ?? '') }}')"
                                class="text-xs bg-amber-100 text-amber-700 px-3 py-1.5 rounded-lg hover:bg-amber-200 font-medium">
                                <i class="fa fa-edit mr-1"></i>Update
                            </button>
                            <form action="{{ route('pengiriman.destroy', $pg->id) }}" method="POST" onsubmit="return confirm('Hapus pengiriman ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-xs bg-red-100 text-red-600 px-3 py-1.5 rounded-lg hover:bg-red-200 font-medium">
                                    <i class="fa fa-trash mr-1"></i>Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-8 text-center text-slate-400">
                        <i class="fa-solid fa-box-open text-3xl mb-2 block"></i>
                        Belum ada data pengiriman.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div id="modalTambah" class="hidden fixed inset-0 bg-slate-900/50 flex items-center justify-center z-50 p-4">
    <div class="bg-white w-full max-w-lg rounded-2xl p-6 shadow-2xl">
        <h3 class="text-lg font-bold mb-4">Buat Pengiriman Baru</h3>
        <form action="{{ route('pengiriman.store') }}" method="POST" class="space-y-3">
            @csrf
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="text-xs font-medium text-slate-600 mb-1 block">Nama Penerima *</label>
                    <input type="text" name="nama_penerima" class="w-full border rounded-lg p-2.5 text-sm" required>
                </div>
                <div>
                    <label class="text-xs font-medium text-slate-600 mb-1 block">Nama Toko</label>
                    <input type="text" name="nama_toko" class="w-full border rounded-lg p-2.5 text-sm">
                </div>
            </div>
            <div>
                <label class="text-xs font-medium text-slate-600 mb-1 block">Alamat Tujuan *</label>
                <textarea name="alamat_tujuan" rows="2" class="w-full border rounded-lg p-2.5 text-sm" required></textarea>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="text-xs font-medium text-slate-600 mb-1 block">Produk *</label>
                    <select name="produk_id" class="w-full border rounded-lg p-2.5 text-sm" required>
                        <option value="">-- Pilih Produk --</option>
                        @foreach($produk as $p)
                            <option value="{{ $p->id }}">{{ $p->nama_produk }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-xs font-medium text-slate-600 mb-1 block">Jumlah *</label>
                    <input type="number" name="jumlah" min="1" class="w-full border rounded-lg p-2.5 text-sm" required>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="text-xs font-medium text-slate-600 mb-1 block">Tanggal Kirim *</label>
                    <input type="date" name="tanggal_kirim" class="w-full border rounded-lg p-2.5 text-sm" value="{{ date('Y-m-d') }}" required>
                </div>
                <div>
                    <label class="text-xs font-medium text-slate-600 mb-1 block">Transaksi (opsional)</label>
                    <select name="transaksi_id" class="w-full border rounded-lg p-2.5 text-sm">
                        <option value="">-- Pilih Transaksi --</option>
                        @foreach($transaksi as $t)
                            <option value="{{ $t->id }}">{{ $t->nomor_invoice }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div>
                <label class="text-xs font-medium text-slate-600 mb-1 block">Catatan</label>
                <input type="text" name="catatan" class="w-full border rounded-lg p-2.5 text-sm" placeholder="Opsional...">
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="document.getElementById('modalTambah').classList.add('hidden')"
                    class="flex-1 border py-2.5 rounded-lg text-sm hover:bg-slate-50">Batal</button>
                <button type="submit" class="flex-1 bg-blue-600 text-white py-2.5 rounded-lg text-sm font-bold hover:bg-blue-700">
                    Buat Pengiriman
                </button>
            </div>
        </form>
    </div>
</div>

<div id="modalEdit" class="hidden fixed inset-0 bg-slate-900/50 flex items-center justify-center z-50 p-4">
    <div class="bg-white w-full max-w-sm rounded-2xl p-6 shadow-2xl">
        <h3 class="text-lg font-bold mb-4">Update Status Pengiriman</h3>
        <form id="formEditStatus" method="POST" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="text-xs font-medium text-slate-600 mb-1 block">Status</label>
                <select name="status" id="edit_status" class="w-full border rounded-lg p-2.5 text-sm" required>
                    <option value="Menunggu">⏳ Menunggu</option>
                    <option value="Perjalanan">🚚 Dalam Perjalanan</option>
                    <option value="Sampai">✅ Sudah Sampai</option>
                </select>
            </div>
            <div>
                <label class="text-xs font-medium text-slate-600 mb-1 block">Catatan</label>
                <input type="text" name="catatan" id="edit_catatan" class="w-full border rounded-lg p-2.5 text-sm" placeholder="Opsional...">
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="document.getElementById('modalEdit').classList.add('hidden')"
                    class="flex-1 border py-2.5 rounded-lg text-sm hover:bg-slate-50">Batal</button>
                <button type="submit" class="flex-1 bg-amber-500 text-white py-2.5 rounded-lg text-sm font-bold hover:bg-amber-600">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditModal(id, status, catatan) {
    document.getElementById('formEditStatus').action = '/pengiriman/' + id;
    document.getElementById('edit_status').value = status;
    document.getElementById('edit_catatan').value = catatan;
    document.getElementById('modalEdit').classList.remove('hidden');
}
</script>
@endsection