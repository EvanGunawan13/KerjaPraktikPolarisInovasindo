@extends('dashboard')

@section('content')
<div class="p-6 space-y-6">

    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Manajemen Kategori</h2>
            <p class="text-sm text-slate-400 mt-0.5">Kelola kategori produk Polaris</p>
        </div>
        <button onclick="document.getElementById('modalTambah').classList.remove('hidden')"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm font-medium">
            <i class="fa fa-plus mr-2"></i>Tambah Kategori
        </button>
    </div>

    @if(session('success'))
        <div class="bg-green-500 text-white p-3 rounded-lg text-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-500 text-white p-3 rounded-lg text-sm">{{ session('error') }}</div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 border-b">
                <tr class="text-xs font-bold text-slate-500 uppercase">
                    <th class="p-4">#</th>
                    <th class="p-4">Nama Kategori</th>
                    <th class="p-4">Slug</th>
                    <th class="p-4 text-center">Jumlah Produk</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($kategori as $k)
                <tr class="hover:bg-slate-50">
                    <td class="p-4 text-slate-400">{{ $loop->iteration }}</td>
                    <td class="p-4 font-semibold text-slate-800">{{ $k->nama_kategori }}</td>
                    <td class="p-4 font-mono text-xs text-slate-400">{{ $k->slug }}</td>
                    <td class="p-4 text-center">
                        <span class="px-2.5 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">
                            {{ $k->produk_count }} produk
                        </span>
                    </td>
                    <td class="p-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <button onclick="openEditModal({{ $k->id }}, '{{ addslashes($k->nama_kategori) }}')"
                                class="text-xs bg-amber-100 text-amber-700 px-3 py-1.5 rounded-lg hover:bg-amber-200 font-medium">
                                <i class="fa fa-edit mr-1"></i>Edit
                            </button>
                            <form action="{{ route('kategori.destroy', $k->id) }}" method="POST"
                                onsubmit="return confirm('Hapus kategori {{ $k->nama_kategori }}?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="text-xs bg-red-100 text-red-600 px-3 py-1.5 rounded-lg hover:bg-red-200 font-medium">
                                    <i class="fa fa-trash mr-1"></i>Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-8 text-center text-slate-400">
                        <i class="fa-solid fa-tags text-3xl mb-2 block"></i>
                        Belum ada kategori. Tambahkan kategori pertama!
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>


<div id="modalTambah" class="hidden fixed inset-0 bg-slate-900/50 flex items-center justify-center z-50 p-4">
    <div class="bg-white w-full max-w-sm rounded-2xl p-6 shadow-2xl">
        <h3 class="text-lg font-bold mb-4">Tambah Kategori Baru</h3>
        <form action="{{ route('kategori.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="text-xs font-medium text-slate-600 mb-1 block">Nama Kategori *</label>
                <input type="text" name="nama_kategori"
                    class="w-full border rounded-lg p-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Contoh: Kursi, Meja, Lemari..." required autofocus>
                <p class="text-xs text-slate-400 mt-1">Slug akan dibuat otomatis.</p>
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="document.getElementById('modalTambah').classList.add('hidden')"
                    class="flex-1 border py-2.5 rounded-lg text-sm hover:bg-slate-50">Batal</button>
                <button type="submit"
                    class="flex-1 bg-blue-600 text-white py-2.5 rounded-lg text-sm font-bold hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div id="modalEdit" class="hidden fixed inset-0 bg-slate-900/50 flex items-center justify-center z-50 p-4">
    <div class="bg-white w-full max-w-sm rounded-2xl p-6 shadow-2xl">
        <h3 class="text-lg font-bold mb-4">Edit Kategori</h3>
        <form id="formEdit" method="POST" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="text-xs font-medium text-slate-600 mb-1 block">Nama Kategori *</label>
                <input type="text" name="nama_kategori" id="edit_nama"
                    class="w-full border rounded-lg p-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400"
                    required>
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="document.getElementById('modalEdit').classList.add('hidden')"
                    class="flex-1 border py-2.5 rounded-lg text-sm hover:bg-slate-50">Batal</button>
                <button type="submit"
                    class="flex-1 bg-amber-500 text-white py-2.5 rounded-lg text-sm font-bold hover:bg-amber-600">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditModal(id, nama) {
    document.getElementById('formEdit').action = '/kategori/' + id;
    document.getElementById('edit_nama').value = nama;
    document.getElementById('modalEdit').classList.remove('hidden');
}
</script>
@endsection