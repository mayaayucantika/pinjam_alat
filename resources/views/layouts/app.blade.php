<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Pinjam Alat') - {{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-slate-50 via-indigo-50/30 to-purple-50/40 min-h-screen">
    @auth
        <nav class="bg-gradient-to-r from-indigo-600 to-purple-600 shadow-xl">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <a href="{{ route('tools.index') }}" class="inline-flex items-center gap-3 text-black hover:text-black transition">
                                <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center overflow-hidden ring-1 ring-black/10">
                                    <img src="{{ asset('img/Logo-SMK-Vektor.png') }}" alt="Logo" class="w-full h-full object-cover">
                                </div>
                                <div class="leading-tight">
                                    <span class="text-xl font-bold">Pinjam Alat</span>
                                    <span class="block text-xs font-medium text-black/80">SMKN 8 JEMBER</span>
                                </div>
                            </a>
                        </div>
                        <div class="hidden sm:ml-8 sm:flex sm:space-x-1">
                            <a href="{{ route('tools.index') }}" class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('tools.*') ? 'bg-white/20 text-black' : 'text-black hover:bg-white/10 hover:text-black' }} transition">
                                Alat
                            </a>
                            <a href="{{ route('transactions.index') }}" class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('transactions.*') ? 'bg-white/20 text-black' : 'text-black hover:bg-white/10 hover:text-black' }} transition">
                                Transaksi
                            </a>
                            @if(auth()->user()->isAdmin() || auth()->user()->isPetugas())
                                <a href="{{ route('reports.index') }}" class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('reports.*') ? 'bg-white/20 text-black' : 'text-black hover:bg-white/10 hover:text-black' }} transition">
                                    Laporan
                                </a>
                            @endif
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-white/20 text-black' : 'text-black hover:bg-white/10 hover:text-black' }} transition">
                                    Dashboard
                                </a>
                                <a href="{{ route('categories.index') }}" class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('categories.*') ? 'bg-white/20 text-black' : 'text-black hover:bg-white/10 hover:text-black' }} transition">
                                    Kategori
                                </a>
                                <a href="{{ route('users.index') }}" class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('users.*') ? 'bg-white/20 text-black' : 'text-black hover:bg-white/10 hover:text-black' }} transition">
                                    User
                                </a>
                                <a href="{{ route('activity-logs.index') }}" class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('activity-logs.*') ? 'bg-white/20 text-black' : 'text-black hover:bg-white/10 hover:text-black' }} transition">
                                    Log
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="hidden sm:flex sm:items-center sm:gap-4">
                        <span class="text-black text-sm font-medium">{{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="bg-white/20 hover:bg-white/30 text-black px-4 py-2 rounded-lg text-sm font-medium transition">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
    @endauth

    <main class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 flex items-center gap-3 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 px-4 py-3 rounded-r-xl shadow-sm" role="alert">
                    <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 flex items-start gap-3 bg-rose-50 border-l-4 border-rose-500 text-rose-800 px-4 py-3 rounded-r-xl shadow-sm" role="alert">
                    <svg class="w-5 h-5 text-rose-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>
</body>
</html>
