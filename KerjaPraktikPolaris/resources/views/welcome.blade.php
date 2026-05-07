@extends('dashboard')

@section('content')
<div class="p-6 space-y-6">

    {{-- ══════════════════════════════════════════
         STAT CARDS
    ══════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">

        {{-- Total Nilai Aset --}}
        <div class="bg-white rounded-2xl shadow-sm border p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-vault text-blue-600 text-xl"></i>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-medium uppercase tracking-wide">Total Nilai Aset</p>
                <p class="text-xl font-bold text-slate-800">Rp {{ number_format($totalAset, 0, ',', '.') }}</p>
                <p class="text-xs text-slate-400 mt-0.5">Stok × Harga Beli</p>
            </div>
        </div>

        {{-- Transaksi Hari Ini --}}
        <div class="bg-white rounded-2xl shadow-sm border p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-receipt text-green-600 text-xl"></i>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-medium uppercase tracking-wide">Transaksi Hari Ini</p>
                <p class="text-xl font-bold text-slate-800">{{ $transaksiHariIni }}</p>
                <p class="text-xs text-slate-400 mt-0.5">Nota masuk hari ini</p>
            </div>
        </div>

        {{-- Produk Hampir Habis --}}
        <div class="bg-white rounded-2xl shadow-sm border p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl {{ $produkHampirHabis > 0 ? 'bg-red-100' : 'bg-slate-100' }} flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-triangle-exclamation {{ $produkHampirHabis > 0 ? 'text-red-500' : 'text-slate-400' }} text-xl"></i>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-medium uppercase tracking-wide">Hampir Habis</p>
                <p class="text-xl font-bold {{ $produkHampirHabis > 0 ? 'text-red-600' : 'text-slate-800' }}">{{ $produkHampirHabis }} Produk</p>
                <p class="text-xs text-slate-400 mt-0.5">Stok ≤ stok minimum</p>
            </div>
        </div>

        {{-- Pengiriman Aktif --}}
        <div class="bg-white rounded-2xl shadow-sm border p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-truck text-amber-600 text-xl"></i>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-medium uppercase tracking-wide">Pengiriman Aktif</p>
                <p class="text-xl font-bold text-slate-800">{{ $pengirimanAktif }}</p>
                <p class="text-xs text-slate-400 mt-0.5">Sedang dalam perjalanan</p>
            </div>
        </div>

    </div>

    {{-- ══════════════════════════════════════════
         CHARTS ROW
    ══════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">

        {{-- Line Chart: Penjualan 7 Hari --}}
        <div class="xl:col-span-2 bg-white rounded-2xl shadow-sm border p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="font-bold text-slate-800">Tren Penjualan</h3>
                    <p class="text-xs text-slate-400">7 hari terakhir</p>
                </div>
                <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full font-medium">Line Chart</span>
            </div>
            <canvas id="salesChart" height="100"></canvas>
        </div>

        {{-- Doughnut Chart: Kategori --}}
        <div class="bg-white rounded-2xl shadow-sm border p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="font-bold text-slate-800">Stok per Kategori</h3>
                    <p class="text-xs text-slate-400">Distribusi stok saat ini</p>
                </div>
                <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full font-medium">Doughnut</span>
            </div>
            <canvas id="categoryChart" height="180"></canvas>
        </div>

    </div>

    {{-- ══════════════════════════════════════════
         WIDGETS ROW
    ══════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">

        {{-- Restock Needed --}}
        <div class="bg-white rounded-2xl shadow-sm border p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-bell text-red-500"></i> Restock Needed
                </h3>
                <a href="{{ route('produk.index') }}" class="text-xs text-blue-600 hover:underline">Lihat semua</a>
            </div>
            @forelse($restockList as $r)
            <div class="flex items-center justify-between py-2 border-b last:border-0">
                <div>
                    <p class="text-sm font-semibold text-slate-700">{{ $r->nama_produk }}</p>
                    <p class="text-xs text-slate-400">Sisa: <span class="text-red-500 font-bold">{{ $r->stok }}</span> / Min: {{ $r->stok_minimum }}</p>
                </div>
                <a href="{{ route('produk.index') }}" class="text-xs bg-red-50 text-red-600 border border-red-200 px-2 py-1 rounded-lg hover:bg-red-100 whitespace-nowrap">
                    + Restock
                </a>
            </div>
            @empty
            <div class="text-center py-6 text-slate-400">
                <i class="fa-solid fa-check-circle text-green-400 text-2xl mb-2 block"></i>
                <p class="text-sm">Semua stok aman!</p>
            </div>
            @endforelse
        </div>

        {{-- Recent Pengiriman --}}
        <div class="bg-white rounded-2xl shadow-sm border p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-truck text-blue-500"></i> Pengiriman Terbaru
                </h3>
                <a href="{{ route('pengiriman.index') }}" class="text-xs text-blue-600 hover:underline">Lihat semua</a>
            </div>
            @forelse($recentPengiriman as $pg)
            <div class="flex items-center justify-between py-2 border-b last:border-0">
                <div>
                    <p class="text-sm font-semibold text-slate-700">{{ $pg->nomor_resi }}</p>
                    <p class="text-xs text-slate-400">{{ $pg->nama_penerima }} • {{ optional($pg->produk)->nama_produk ?? '-' }}</p>
                </div>
                @php
                    $colors = ['Menunggu' => 'yellow', 'Perjalanan' => 'blue', 'Sampai' => 'green'];
                    $c = $colors[$pg->status] ?? 'gray';
                @endphp
                <span class="text-xs px-2 py-0.5 rounded-full font-medium
                    {{ $c === 'yellow' ? 'bg-yellow-100 text-yellow-700' : '' }}
                    {{ $c === 'blue'   ? 'bg-blue-100 text-blue-700'     : '' }}
                    {{ $c === 'green'  ? 'bg-green-100 text-green-700'   : '' }}
                    {{ $c === 'gray'   ? 'bg-gray-100 text-gray-700'     : '' }}
                ">{{ $pg->status }}</span>
            </div>
            @empty
            <div class="text-center py-6 text-slate-400">
                <i class="fa-solid fa-box-open text-2xl mb-2 block"></i>
                <p class="text-sm">Belum ada pengiriman.</p>
            </div>
            @endforelse
        </div>

        {{-- Activity Feed --}}
        <div class="bg-white rounded-2xl shadow-sm border p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left text-purple-500"></i> Aktivitas Terbaru
                </h3>
            </div>
            <div class="space-y-3">
                @forelse($activityFeed as $act)
                <div class="flex items-start gap-3">
                    <div class="w-7 h-7 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5
                        {{ $act['color'] === 'green' ? 'bg-green-100' : 'bg-blue-100' }}">
                        <i class="fa-solid {{ $act['icon'] }} text-xs
                            {{ $act['color'] === 'green' ? 'text-green-600' : 'text-blue-600' }}"></i>
                    </div>
                    <div>
                        <p class="text-xs text-slate-700 leading-snug">{{ $act['text'] }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">{{ \Carbon\Carbon::parse($act['time'])->diffForHumans() }}</p>
                    </div>
                </div>
                @empty
                <p class="text-sm text-slate-400 text-center py-4">Belum ada aktivitas.</p>
                @endforelse
            </div>
        </div>

    </div>
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: @json($labels7Hari),
            datasets: [{
                label: 'Total Penjualan (Rp)',
                data: @json($data7Hari),
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37,99,235,0.08)',
                borderWidth: 2.5,
                pointBackgroundColor: '#2563eb',
                pointRadius: 4,
                tension: 0.4,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: v => 'Rp ' + Intl.NumberFormat('id-ID').format(v),
                        font: { size: 11 }
                    },
                    grid: { color: '#f1f5f9' }
                },
                x: { grid: { display: false }, ticks: { font: { size: 11 } } }
            }
        }
    });

    const catCtx = document.getElementById('categoryChart').getContext('2d');
    new Chart(catCtx, {
        type: 'doughnut',
        data: {
            labels: @json($kategoriLabels),
            datasets: [{
                data: @json($kategoriValues),
                backgroundColor: ['#3b82f6','#10b981','#f59e0b','#ef4444','#8b5cf6','#06b6d4','#f97316'],
                borderWidth: 2,
                borderColor: '#fff',
            }]
        },
        options: {
            responsive: true,
            cutout: '65%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { font: { size: 11 }, padding: 10, boxWidth: 12 }
                }
            }
        }
    });
</script>
@endsection