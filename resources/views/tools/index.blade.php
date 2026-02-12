@extends('layouts.app')

@section('title', 'Daftar Alat')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Daftar Alat</h1>
            <p class="text-gray-500 mt-1">Telusuri alat yang tersedia untuk dipinjam</p>
        </div>
        @if(auth()->user()->isAdmin())
            <a href="{{ route('tools.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-5 py-2.5 rounded-xl font-semibold shadow-lg shadow-indigo-200 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Alat
            </a>
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($tools as $tool)
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-gray-100">
                @if($tool->image)
                    <img src="{{ asset('storage/' . $tool->image) }}" alt="{{ $tool->name }}" class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center">
                        <svg class="w-20 h-20 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                @endif
                <div class="p-6">
                    <div class="flex justify-between items-start mb-3">
                        <h3 class="text-xl font-bold text-gray-900 line-clamp-1">{{ $tool->name }}</h3>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800 shrink-0">
                            {{ $tool->category->name }}
                        </span>
                    </div>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $tool->description ?? 'Tidak ada deskripsi' }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-sm">
                            Stok: <span class="font-bold {{ $tool->stock > 0 ? 'text-emerald-600' : 'text-rose-600' }}">{{ $tool->stock }}</span>
                        </span>
                        <a href="{{ route('tools.show', $tool) }}" class="inline-flex items-center gap-1 text-indigo-600 hover:text-indigo-700 font-semibold text-sm">
                            Lihat Detail
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-16 bg-white rounded-2xl border-2 border-dashed border-gray-200">
                <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                <p class="mt-4 text-gray-500 font-medium">Tidak ada alat tersedia</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $tools->links() }}
    </div>
</div>
@endsection
