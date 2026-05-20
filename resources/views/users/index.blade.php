@extends('dashboard')

@section('content')
<div class="p-6 space-y-6">

    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Manajemen User</h2>
            <p class="text-sm text-slate-400 mt-0.5">Kelola akun dan hak akses pengguna sistem</p>
        </div>
        <button onclick="document.getElementById('modalTambah').classList.remove('hidden')"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm font-medium">
            <i class="fa fa-plus mr-2"></i>Tambah User
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
                    <th class="p-4">Nama</th>
                    <th class="p-4">Email</th>
                    <th class="p-4 text-center">Role</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($users as $u)
                <tr class="hover:bg-slate-50">
                    <td class="p-4 font-semibold text-slate-800">
                        {{ $u->name }}
                        @if($u->id === auth()->id())
                            <span class="text-xs bg-blue-100 text-blue-600 px-1.5 py-0.5 rounded ml-1">Anda</span>
                        @endif
                    </td>
                    <td class="p-4 text-slate-500">{{ $u->email }}</td>
                    <td class="p-4 text-center">
                        @php
                            $roleColor = [
                                'kepala_cabang' => 'bg-purple-100 text-purple-700',
                                'gudang'        => 'bg-amber-100 text-amber-700',
                                'pembukuan'     => 'bg-green-100 text-green-700',
                            ][$u->role] ?? 'bg-gray-100 text-gray-600';
                        @endphp
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $roleColor }}">
                            {{ $u->role_label }}
                        </span>
                    </td>
                    <td class="p-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <button onclick="openEditModal({{ $u->id }}, '{{ addslashes($u->name) }}', '{{ $u->email }}', '{{ $u->role }}')"
                                class="text-xs bg-amber-100 text-amber-700 px-3 py-1.5 rounded-lg hover:bg-amber-200 font-medium">
                                <i class="fa fa-edit mr-1"></i>Edit
                            </button>
                            @if($u->id !== auth()->id())
                            <form action="{{ route('users.destroy', $u->id) }}" method="POST"
                                onsubmit="return confirm('Hapus user {{ $u->name }}?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="text-xs bg-red-100 text-red-600 px-3 py-1.5 rounded-lg hover:bg-red-200 font-medium">
                                    <i class="fa fa-trash mr-1"></i>Hapus
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-8 text-center text-slate-400">Belum ada user.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div id="modalTambah" class="hidden fixed inset-0 bg-slate-900/50 flex items-center justify-center z-50 p-4">
    <div class="bg-white w-full max-w-md rounded-2xl p-6 shadow-2xl">
        <h3 class="text-lg font-bold mb-4">Tambah User Baru</h3>
        <form action="{{ route('users.store') }}" method="POST" class="space-y-3">
            @csrf
            <div>
                <label class="text-xs font-medium text-slate-600 mb-1 block">Nama Lengkap *</label>
                <input type="text" name="name" class="w-full border rounded-lg p-2.5 text-sm" required>
            </div>
            <div>
                <label class="text-xs font-medium text-slate-600 mb-1 block">Email *</label>
                <input type="email" name="email" class="w-full border rounded-lg p-2.5 text-sm" required>
            </div>
            <div>
                <label class="text-xs font-medium text-slate-600 mb-1 block">Role *</label>
                <select name="role" class="w-full border rounded-lg p-2.5 text-sm" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="kepala_cabang">Kepala Cabang</option>
                    <option value="gudang">Bagian Gudang</option>
                    <option value="pembukuan">Bagian Pembukuan</option>
                </select>
            </div>
            <div>
                <label class="text-xs font-medium text-slate-600 mb-1 block">Password *</label>
                <input type="password" name="password" class="w-full border rounded-lg p-2.5 text-sm"
                    placeholder="Min. 6 karakter" required>
            </div>
            <div>
                <label class="text-xs font-medium text-slate-600 mb-1 block">Konfirmasi Password *</label>
                <input type="password" name="password_confirmation" class="w-full border rounded-lg p-2.5 text-sm" required>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="document.getElementById('modalTambah').classList.add('hidden')"
                    class="flex-1 border py-2.5 rounded-lg text-sm hover:bg-slate-50">Batal</button>
                <button type="submit"
                    class="flex-1 bg-blue-600 text-white py-2.5 rounded-lg text-sm font-bold hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div id="modalEdit" class="hidden fixed inset-0 bg-slate-900/50 flex items-center justify-center z-50 p-4">
    <div class="bg-white w-full max-w-md rounded-2xl p-6 shadow-2xl">
        <h3 class="text-lg font-bold mb-4">Edit User</h3>
        <form id="formEdit" method="POST" class="space-y-3">
            @csrf @method('PUT')
            <div>
                <label class="text-xs font-medium text-slate-600 mb-1 block">Nama Lengkap *</label>
                <input type="text" name="name" id="edit_name" class="w-full border rounded-lg p-2.5 text-sm" required>
            </div>
            <div>
                <label class="text-xs font-medium text-slate-600 mb-1 block">Email *</label>
                <input type="email" name="email" id="edit_email" class="w-full border rounded-lg p-2.5 text-sm" required>
            </div>
            <div>
                <label class="text-xs font-medium text-slate-600 mb-1 block">Role *</label>
                <select name="role" id="edit_role" class="w-full border rounded-lg p-2.5 text-sm" required>
                    <option value="kepala_cabang">Kepala Cabang</option>
                    <option value="gudang">Bagian Gudang</option>
                    <option value="pembukuan">Bagian Pembukuan</option>
                </select>
            </div>
            <div>
                <label class="text-xs font-medium text-slate-600 mb-1 block">Password Baru <span class="text-slate-400">(kosongkan jika tidak diubah)</span></label>
                <input type="password" name="password" class="w-full border rounded-lg p-2.5 text-sm" placeholder="Min. 6 karakter">
            </div>
            <div>
                <label class="text-xs font-medium text-slate-600 mb-1 block">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" class="w-full border rounded-lg p-2.5 text-sm">
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="document.getElementById('modalEdit').classList.add('hidden')"
                    class="flex-1 border py-2.5 rounded-lg text-sm hover:bg-slate-50">Batal</button>
                <button type="submit"
                    class="flex-1 bg-amber-500 text-white py-2.5 rounded-lg text-sm font-bold hover:bg-amber-600">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditModal(id, name, email, role) {
    document.getElementById('formEdit').action = '/users/' + id;
    document.getElementById('edit_name').value  = name;
    document.getElementById('edit_email').value = email;
    document.getElementById('edit_role').value  = role;
    document.getElementById('modalEdit').classList.remove('hidden');
}
</script>
@endsection