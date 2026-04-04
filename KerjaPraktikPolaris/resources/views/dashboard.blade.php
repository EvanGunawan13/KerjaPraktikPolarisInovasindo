<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Inventaris | Polaris Inovasindo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-100 font-sans">

    <div class="flex min-h-screen">
        <aside class="w-64 bg-slate-900 text-white flex-shrink-0 shadow-xl">
            <div class="p-6">
                <h2 class="text-xl font-bold tracking-wider text-blue-400">POLARIS</h2>
                <p class="text-xs text-slate-400 uppercase tracking-widest mt-1">Inovasindo Furniture</p>
            </div>

            <nav class="mt-4 px-4 space-y-2">
                <a href="{{ route('dashboard') }}" class="flex items-center p-3 text-sm font-medium rounded-lg bg-blue-600 text-white transition-colors">
                    <i class="fa-solid fa-gauge-high w-6 text-center mr-3"></i>
                    Dashboard
                </a>

                <div class="pt-4 pb-2">
                    <p class="text-[10px] font-bold text-slate-500 uppercase px-3">Manajemen Utama</p>
                </div>

                <a href="#" class="flex items-center p-3 text-sm font-medium text-slate-300 hover:bg-slate-800 hover:text-white rounded-lg transition-all group">
                    <i class="fa-solid fa-boxes-stacked w-6 text-center mr-3 group-hover:text-blue-400"></i>
                    Data Stok Barang
                </a>

                <a href="#" class="flex items-center p-3 text-sm font-medium text-slate-300 hover:bg-slate-800 hover:text-white rounded-lg transition-all group">
                    <i class="fa-solid fa-cart-shopping w-6 text-center mr-3 group-hover:text-green-400"></i>
                    Transaksi Jual
                </a>

                <a href="#" class="flex items-center p-3 text-sm font-medium text-slate-300 hover:bg-slate-800 hover:text-white rounded-lg transition-all group">
                    <i class="fa-solid fa-file-invoice-dollar w-6 text-center mr-3 group-hover:text-yellow-