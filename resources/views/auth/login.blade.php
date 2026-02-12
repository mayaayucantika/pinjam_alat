<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Pinjam Alat</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 p-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-6">
                <div class="flex items-center justify-center gap-3">
                    <img src="{{ asset('img/Logo-SMK-Vektor.png') }}" alt="Logo" class="w-8 h-8 md:w-10 md:h-10 rounded-lg ring-1 ring-white/40 bg-white p-1 object-contain shrink-0">
                    <h1 class="text-2xl md:text-3xl font-bold text-white">Pinjam Alat</h1>
                </div>
                <p class="text-center text-indigo-100 text-sm mt-1">Masuk ke akun Anda</p>
            </div>
            <form class="p-8 space-y-6" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                        <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"
                               class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition text-gray-900"
                               placeholder="nama@email.com">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                               class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition text-gray-900"
                               placeholder="••••••••">
                    </div>
                </div>
                <button type="submit" class="w-full py-3 px-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg shadow-indigo-200 hover:shadow-xl transition">
                    Masuk
                </button>
                <p class="text-center text-sm text-gray-600">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:text-indigo-700">Daftar di sini</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>
