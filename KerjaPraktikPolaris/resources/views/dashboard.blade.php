<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Polaris Inventory</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50">
    <div class="p-8">
        <header class="mb-8">
            <h1 class="text-2xl font-bold text-slate-800">Sistem Inventaris Polaris</h1>
            <p class="text-slate-500">Ringkasan aktivitas hari ini</p>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                <span class="text-slate-400 text-sm font-semibold uppercase">Total Produk</span>
                <h3 class="text-3xl font-bold text-slate-800">{{ $total_produk }}</h3>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                <span class="text-slate-400 text-sm font-semibold uppercase">Stok Menipis</span>
                <h3 class="text-3xl font-bold text-orange-500">{{ $stok_menipis }}</h3>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                <span class="text-slate-400 text-sm font-semibold uppercase">Total Pendapatan</span>
                <h3 class="text-3xl font-bold text-green-600">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-5 border-b border-slate-100 bg-slate-50">
                <h2 class="font-bold text-slate-700">Produk Terbaru</h2>
            </div>
            <table class="w-full text-left">
                <thead>
                    <tr class="text-slate-400 text-sm uppercase">
                        <th class="p-4 font-medium">SKU</th>
                        <th class="p-4 font-medium">Nama Produk</th>
                        <th class="p-4 font-medium text-center">Stok</th>
                        <th class="p-4 font-medium">Kategori</th>
                    </tr>
                </thead>
                <tbody class="text-slate-600">
                    @forelse($produk_terbaru as $item)
                    <tr class="border-t border-slate-100 hover:bg-slate-50">
                        <td class="p-4 font-mono text-sm">{{ $item->sku }}</td>
                        <td class="p-4 font-semibold text-slate-800">{{ $item->nama_produk }}</td>
                        <td class="p-4 text-center">
                            <span class="px-2 py-1 rounded text-xs {{ $item->stok <= $item->stok_minimum ? 'bg-red-100 text-red-600' : 'bg-blue-100 text-blue-600' }}">
                                {{ $item->stok }}
                            </span>
                        </td>
                        <td class="p-4 text-sm">{{ $item->Kategori->nama_kategori ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-10 text-center text-slate-400 italic">Belum ada data produk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>