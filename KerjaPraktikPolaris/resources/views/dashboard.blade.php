<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Polaris Inovasindo - Manajemen Stok</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-100 flex h-screen overflow-hidden">

    <aside class="w-64 bg-slate-900 h-full flex flex-col">

        <div class="p-6">
            <h1 class="text-blue-400 text-xl font-bold uppercase tracking-wider">Polaris</h1>
            <p class="text-slate-500 text-xs uppercase">Inovasindo Furniture</p>
        </div>

        <nav class="flex-1 px-4 space-y-1">

            <a href="{{ route('dashboard') }}"
               class="flex items-center p-3 text-sm font-medium rounded-lg transition
               {{ Request::routeIs('dashboard') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-gauge-high w-6 text-center mr-3"></i>Dashboard
            </a>


            <a href="{{ route('produk.index') }}"
               class="flex items-center p-3 text-sm font-medium rounded-lg transition
               {{ Request::routeIs('produk.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-boxes-stacked w-6 text-center mr-3"></i>Data Stok Barang
            </a>

            @if(auth()->user()->isKepala() || auth()->user()->isGudang())
            <a href="{{ route('kategori.index') }}"
               class="flex items-center p-3 text-sm font-medium rounded-lg transition
               {{ Request::routeIs('kategori.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-tags w-6 text-center mr-3"></i>Manajemen Kategori
            </a>
            @endif

            @if(auth()->user()->isKepala() || auth()->user()->isPembukuan())
            <a href="{{ route('transaksi.index') }}"
               class="flex items-center p-3 text-sm font-medium rounded-lg transition
               {{ Request::routeIs('transaksi.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-calculator w-6 text-center mr-3"></i>Laporan Transaksi
            </a>
            @endif

            <a href="{{ route('pengiriman.index') }}"
               class="flex items-center p-3 text-sm font-medium rounded-lg transition
               {{ Request::routeIs('pengiriman.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-truck w-6 text-center mr-3"></i>Status Pengiriman
            </a>

            @if(auth()->user()->isKepala())
            <a href="{{ route('users.index') }}"
               class="flex items-center p-3 text-sm font-medium rounded-lg transition
               {{ Request::routeIs('users.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-users w-6 text-center mr-3"></i>Manajemen User
            </a>
            @endif

        </nav>

        <div class="p-4 border-t border-slate-700">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="overflow-hidden">
                    <p class="text-white text-sm font-medium truncate">{{ auth()->user()->name }}</p>
                    <p class="text-slate-400 text-xs truncate">{{ auth()->user()->role_label }}</p>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 text-slate-400 hover:text-white hover:bg-slate-800 p-2 rounded-lg text-sm transition">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </button>
            </form>
        </div>

    </aside>

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white shadow-sm p-4 border-b flex items-center justify-between">
            <span class="text-slate-600 font-medium">Sistem Inventaris v1.0</span>
            <span class="text-xs text-slate-400">
                <i class="fa-solid fa-circle text-green-400 mr-1"></i>
                {{ auth()->user()->name }} — {{ auth()->user()->role_label }}
            </span>
        </header>

        <main class="flex-1 overflow-y-auto bg-slate-50">
            @yield('content')
        </main>
    </div>

</body>
</html>