<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>InvPolar - Sistem Inventaris</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* ── Sidebar ── */
        .sidebar {
            background: linear-gradient(160deg, #0f2d6b 0%, #1a47a8 60%, #1e56c8 100%);
            box-shadow: 4px 0 24px rgba(15,45,107,0.18);
        }
        .nav-link {
            display: flex; align-items: center; padding: 10px 14px;
            border-radius: 10px; font-size: 13.5px; font-weight: 500;
            color: rgba(255,255,255,0.65); transition: all 0.18s ease;
            text-decoration: none; gap: 10px;
        }
        .nav-link:hover { background: rgba(255,255,255,0.12); color: #fff; }
        .nav-link.active { background: rgba(255,255,255,0.18); color: #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.12); }
        .nav-link i { width: 20px; text-align: center; font-size: 14px; flex-shrink: 0; }

        /* ── Mobile overlay ── */
        #sidebarOverlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,0.45); z-index: 39;
        }
        #sidebarOverlay.show { display: block; }

        /* ── Sidebar mobile ── */
        #sidebar {
            position: fixed; top: 0; left: 0; height: 100%;
            width: 260px; z-index: 40;
            transform: translateX(-100%);
            transition: transform 0.25s ease;
        }
        #sidebar.open { transform: translateX(0); }

        /* Desktop: sidebar always visible */
        @media (min-width: 1024px) {
            #sidebar { position: relative; transform: none !important; width: 240px; flex-shrink: 0; }
            #sidebarOverlay { display: none !important; }
            #menuBtn { display: none !important; }
        }

        /* ── Top header ── */
        .topbar {
            background: #fff;
            border-bottom: 1px solid #e8edf5;
            box-shadow: 0 1px 6px rgba(15,45,107,0.06);
        }

        /* ── Content area ── */
        .main-content { background: #f0f4fb; }

        /* ── User badge ── */
        .user-avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: rgba(255,255,255,0.22);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 13px; color: #fff; flex-shrink: 0;
            border: 2px solid rgba(255,255,255,0.3);
        }

        /* ── Logo area ── */
        .logo-area { border-bottom: 1px solid rgba(255,255,255,0.1); }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #f0f4fb; }
        ::-webkit-scrollbar-thumb { background: #b8c8e8; border-radius: 99px; }

        /* ── Section divider in nav ── */
        .nav-section-label {
            font-size: 10px; font-weight: 700; letter-spacing: 0.08em;
            color: rgba(255,255,255,0.35); text-transform: uppercase;
            padding: 8px 14px 4px;
        }
    </style>
</head>
<body class="bg-blue-50 flex h-screen overflow-hidden">

    {{-- ══ SIDEBAR OVERLAY (mobile) ══ --}}
    <div id="sidebarOverlay" onclick="closeSidebar()"></div>

    {{-- ══ SIDEBAR ══ --}}
    <aside id="sidebar" class="sidebar flex flex-col h-full">

        {{-- Logo --}}
        <div class="logo-area px-5 py-5 flex items-center justify-between">
            <div>
                <div class="flex items-center gap-2">
                    <div style="width:30px;height:30px;background:rgba(255,255,255,0.2);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                        <i class="fa-solid fa-star text-white text-sm"></i>
                    </div>
                    <span style="color:#fff;font-size:17px;font-weight:800;letter-spacing:0.04em;">InvPolar</span>
                </div>
                <p style="color:rgba(255,255,255,0.45);font-size:10px;margin-top:2px;padding-left:38px;">Sistem Inventaris</p>
            </div>
            {{-- Close button (mobile only) --}}
            <button onclick="closeSidebar()" class="lg:hidden text-white/50 hover:text-white p-1">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 px-3 py-3 space-y-0.5 overflow-y-auto">

            <div class="nav-section-label">Menu Utama</div>

            <a href="{{ route('dashboard') }}"
               class="nav-link {{ Request::routeIs('dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-gauge-high"></i>Dashboard
            </a>

            <a href="{{ route('produk.index') }}"
               class="nav-link {{ Request::routeIs('produk.*') ? 'active' : '' }}">
                <i class="fa-solid fa-boxes-stacked"></i>Data Stok Barang
            </a>

            @if(auth()->user()->isKepala() || auth()->user()->isPembukuan())
            <a href="{{ route('transaksi.index') }}"
               class="nav-link {{ Request::routeIs('transaksi.*') ? 'active' : '' }}">
                <i class="fa-solid fa-calculator"></i>Laporan Transaksi
            </a>
            @endif

            <a href="{{ route('pengiriman.index') }}"
               class="nav-link {{ Request::routeIs('pengiriman.*') ? 'active' : '' }}">
                <i class="fa-solid fa-truck"></i>Status Pengiriman
            </a>

            @if(auth()->user()->isKepala() || auth()->user()->isPembukuan())
            <div class="nav-section-label mt-2">Laporan</div>
            <a href="{{ route('laporan.index') }}"
               class="nav-link {{ Request::routeIs('laporan.*') ? 'active' : '' }}">
                <i class="fa-solid fa-file-invoice"></i>Rekap Laporan
            </a>
            @endif

            @if(auth()->user()->isKepala())
            <div class="nav-section-label mt-2">Admin</div>
            <a href="{{ route('users.index') }}"
               class="nav-link {{ Request::routeIs('users.*') ? 'active' : '' }}">
                <i class="fa-solid fa-users"></i>Manajemen User
            </a>
            @endif

        </nav>

        {{-- User info + Logout --}}
        <div class="px-3 py-3 border-t border-white/10">
            <div class="flex items-center gap-2.5 mb-2.5 px-1">
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="overflow-hidden flex-1">
                    <p class="text-white text-sm font-600 truncate leading-tight">{{ auth()->user()->name }}</p>
                    <p class="text-white/45 text-xs truncate">{{ auth()->user()->role_label }}</p>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-link w-full" style="color:rgba(255,255,255,0.5);">
                    <i class="fa-solid fa-right-from-bracket"></i> Keluar
                </button>
            </form>
        </div>

    </aside>

    {{-- ══ MAIN AREA ══ --}}
    <div class="flex-1 flex flex-col overflow-hidden min-w-0">

        {{-- Topbar --}}
        <header class="topbar px-4 py-3 flex items-center justify-between flex-shrink-0">
            <div class="flex items-center gap-3">
                {{-- Hamburger (mobile) --}}
                <button id="menuBtn" onclick="openSidebar()"
                    class="lg:hidden w-9 h-9 rounded-lg bg-blue-50 hover:bg-blue-100 flex items-center justify-center text-blue-700 transition">
                    <i class="fa-solid fa-bars text-sm"></i>
                </button>
                <span class="text-slate-700 font-700 text-sm hidden sm:block">Sistem Inventaris v1.0</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="hidden sm:flex items-center gap-1.5 bg-blue-50 border border-blue-100 rounded-full px-3 py-1.5">
                    <span class="w-2 h-2 rounded-full bg-green-400 inline-block"></span>
                    <span class="text-xs text-slate-600 font-500">{{ auth()->user()->name }}</span>
                    <span class="text-xs text-slate-400">—</span>
                    <span class="text-xs text-blue-600 font-600">{{ auth()->user()->role_label }}</span>
                </div>
                {{-- Mobile user initial --}}
                <div class="sm:hidden w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white text-xs font-700">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            </div>
        </header>

        {{-- Content --}}
        <main class="main-content flex-1 overflow-y-auto">
            @yield('content')
        </main>

    </div>

    <script>
        function openSidebar() {
            document.getElementById('sidebar').classList.add('open');
            document.getElementById('sidebarOverlay').classList.add('show');
            document.body.style.overflow = 'hidden';
        }
        function closeSidebar() {
            document.getElementById('sidebar').classList.remove('open');
            document.getElementById('sidebarOverlay').classList.remove('show');
            document.body.style.overflow = '';
        }
        // Close sidebar on nav link click (mobile)
        document.querySelectorAll('#sidebar .nav-link').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 1024) closeSidebar();
            });
        });
    </script>

</body>
</html>