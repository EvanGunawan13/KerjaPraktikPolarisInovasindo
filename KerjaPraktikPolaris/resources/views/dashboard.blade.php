<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Polaris Inovasindo - Manajemen Stok</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-100 flex h-screen overflow-hidden">

    <aside class="w-64 bg-slate-900 h-full flex flex-col transition-all duration-300">
        <div class="p-6">
            <h1 class="text-blue-400 text-xl font-bold uppercase tracking-wider">Polaris</h1>
            <p class="text-slate-500 text-xs uppercase">Inovasindo Furniture</p>
        </div>

        <nav class="flex-1 px-4 space-y-1">
            <a href="{{ route('dashboard') }}"
               class="flex items-center p-3 text-sm font-medium rounded-lg group transition
               {{ Request::routeIs('dashboard') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-gauge-high w-6 text-center mr-3"></i>
                Dashboard
            </a>

            <a href="{{ route('produk.index') }}"
               class="flex items-center p-3 text-sm font-medium rounded-lg group transition
               {{ Request::routeIs('produk.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-boxes-stacked w-6 text-center mr-3 group-hover:text-blue-400"></i>
                Data Stok Barang
            </a>

            <a href="{{ route('transaksi.index') }}"
               class="flex items-center p-3 text-sm font-medium rounded-lg group transition
               {{ Request::routeIs('transaksi.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-calculator w-6 text-center mr-3 group-hover:text-green-400"></i>
                Laporan Transaksi
            </a>

            <a href="{{ route('pengiriman.index') }}"
               class="flex items-center p-3 text-sm font-medium rounded-lg group transition
               {{ Request::routeIs('pengiriman.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-truck w-6 text-center mr-3 group-hover:text-amber-400"></i>
                Status Pengiriman
            </a>

            <a href="#"
               class="flex items-center p-3 text-sm font-medium text-slate-300 hover:bg-slate-800 hover:text-white rounded-lg group transition">
                <i class="fa-solid fa-users w-6 text-center mr-3"></i>
                Manajemen User
            </a>
        </nav>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white shadow-sm p-4 border-b">
            <span class="text-slate-600 font-medium">Sistem Inventaris v1.0</span>
        </header>

        <main class="flex-1 overflow-y-auto bg-slate-50">
            @yield('content')
        </main>
    </div>

</body>
</html>