<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Polaris Inovasindo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-900 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md">

        <div class="text-center mb-8">
            <h1 class="text-blue-400 text-3xl font-bold uppercase tracking-widest">POLARIS</h1>
            <p class="text-slate-500 text-sm uppercase tracking-wider mt-1">Inovasindo Furniture</p>
        </div>

        <div class="bg-slate-800 rounded-2xl p-8 shadow-2xl border border-slate-700">

            <h2 class="text-white text-xl font-bold mb-1">Selamat Datang</h2>
            <p class="text-slate-400 text-sm mb-6">Masuk ke sistem inventaris Polaris</p>

            @if(session('success'))
                <div class="bg-green-500/20 border border-green-500/30 text-green-400 p-3 rounded-lg mb-4 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-500/20 border border-red-500/30 text-red-400 p-3 rounded-lg mb-4 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1.5">Email</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500">
                            <i class="fa-solid fa-envelope text-sm"></i>
                        </span>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg pl-9 pr-4 py-2.5 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 placeholder-slate-500"
                            placeholder="email@polaris.com" required autofocus>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1.5">Password</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500">
                            <i class="fa-solid fa-lock text-sm"></i>
                        </span>
                        <input type="password" name="password" id="passwordInput"
                            class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg pl-9 pr-10 py-2.5 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 placeholder-slate-500"
                            placeholder="••••••••" required>
                        <button type="button" onclick="togglePassword()"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-300">
                            <i class="fa-solid fa-eye text-sm" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" name="remember" id="remember"
                        class="w-4 h-4 rounded border-slate-600 bg-slate-700 text-blue-500">
                    <label for="remember" class="text-sm text-slate-400 cursor-pointer">Ingat saya</label>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-lg transition text-sm mt-2">
                    <i class="fa-solid fa-right-to-bracket mr-2"></i>Masuk
                </button>
            </form>
        </div>

        <p class="text-center text-slate-600 text-xs mt-6">
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