<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — InvPolar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        body {
            background: linear-gradient(135deg, #0f2d6b 0%, #1a47a8 50%, #2563eb 100%);
            min-height: 100vh;
        }
        .card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 24px 64px rgba(15,45,107,0.22);
        }
        .input-field {
            width: 100%; border: 1.5px solid #e2e8f0; border-radius: 10px;
            padding: 10px 14px 10px 38px; font-size: 14px; color: #1e293b;
            transition: border-color 0.15s; outline: none;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .input-field:focus { border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,0.1); }
        .btn-login {
            width: 100%; background: linear-gradient(135deg, #1a47a8, #2563eb);
            color: #fff; border: none; border-radius: 10px; padding: 11px;
            font-size: 14px; font-weight: 700; cursor: pointer;
            transition: opacity 0.15s, transform 0.1s;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .btn-login:hover { opacity: 0.92; transform: translateY(-1px); }
        .btn-login:active { transform: translateY(0); }
        .bg-pattern {
            position: fixed; inset: 0; overflow: hidden; pointer-events: none;
        }
        .bg-circle {
            position: absolute; border-radius: 50%;
            background: rgba(255,255,255,0.05);
        }
    </style>
</head>
<body class="flex items-center justify-center p-4">

    {{-- Background decorations --}}
    <div class="bg-pattern">
        <div class="bg-circle" style="width:400px;height:400px;top:-100px;right:-100px;"></div>
        <div class="bg-circle" style="width:300px;height:300px;bottom:-80px;left:-80px;"></div>
        <div class="bg-circle" style="width:200px;height:200px;top:50%;left:10%;"></div>
    </div>

    <div class="w-full max-w-sm relative z-10">

        {{-- Logo --}}
        <div class="text-center mb-7">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl mb-3"
                 style="background:rgba(255,255,255,0.15);backdrop-filter:blur(10px);">
                <i class="fa-solid fa-star text-white text-2xl"></i>
            </div>
            <h1 class="text-blue-400 text-3xl font-bold uppercase tracking-widest">INVPOLAR</h1>
<p class="text-slate-500 text-sm uppercase tracking-wider mt-1">Sistem Inventaris</p>
        </div>

        {{-- Card --}}
        <div class="card p-7">
            <h2 class="text-slate-800 text-lg font-700 mb-0.5">Selamat Datang 👋</h2>
            <p class="text-slate-400 text-sm mb-5">Masuk ke sistem inventaris Polaris</p>

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 p-3 rounded-lg mb-4 text-sm">
                    <i class="fa-solid fa-circle-check mr-1.5"></i>{{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 p-3 rounded-lg mb-4 text-sm">
                    <i class="fa-solid fa-circle-exclamation mr-1.5"></i>{{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-600 text-slate-600 mb-1.5">Email</label>
                    <div class="relative">
                        <i class="fa-solid fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="input-field" placeholder="email@gmail.com" required autofocus>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-600 text-slate-600 mb-1.5">Password</label>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <input type="password" name="password" id="passwordInput"
                            class="input-field" style="padding-right:38px;" placeholder="••••••••" required>
                        <button type="button" onclick="togglePassword()"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                            <i class="fa-solid fa-eye text-sm" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" name="remember" id="remember"
                        class="w-4 h-4 rounded border-slate-300 text-blue-600 accent-blue-600">
                    <label for="remember" class="text-sm text-slate-500 cursor-pointer select-none">Ingat saya</label>
                </div>

                <button type="submit" class="btn-login">
                    <i class="fa-solid fa-right-to-bracket mr-2"></i>Masuk ke Sistem
                </button>
            </form>
        </div>

        <p class="text-center text-white/30 text-xs mt-5">
            Sistem Inventaris v1.0 &copy; {{ date('Y') }} Polaris Inovasindo
        </p>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('passwordInput');
            const icon  = document.getElementById('eyeIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</body>
</html>