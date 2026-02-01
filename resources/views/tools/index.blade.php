@extends('layouts.app')

@section('title', 'Daftar Alat')

@section('content')
<div class="py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Daftar Alat</h1>
        @if(auth()->user()->isAdmin())
            <a href="{{ route('tools.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                Tambah Alat
            </a>
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($tools as $tool)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                @if($tool->image)
                    <img src="{{ asset('storage/' . $tool->image) }}" alt="{{ $tool->name }}" class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                @endif
                <div class="p-6">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-xl font-semibold text-gray-900">{{ $tool->name }}</h3>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">
                            {{ $tool->category->name }}
                        </span>
                    </div>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $tool->description }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">
                            Stok: <span class="font-semibold {{ $tool->stock > 0 ? 'text-green-600' : 'text-red-600' }}">{{ $tool->stock }}</span>
                        </span>
                        <a href="{{ route('tools.show', $tool) }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                            Lihat Detail →
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-12">
                <p class="text-gray-500">Tidak ada alat tersedia.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $tools->links() }}
    </div>
</div>
@endsection
