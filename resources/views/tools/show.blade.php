@extends('layouts.app')

@section('title', $tool->name)

@section('content')
<div class="py-6">
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="md:flex">
            <div class="md:flex-shrink-0">
                @if($tool->image)
                    <img class="h-48 w-full object-cover md:w-96" src="{{ asset('storage/' . $tool->image) }}" alt="{{ $tool->name }}">
                @else
                    <div class="h-48 w-full bg-gray-200 flex items-center justify-center md:w-96">
                        <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                @endif
            </div>
            <div class="p-8">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">{{ $tool->name }}</h1>
                        <p class="mt-2 text-sm text-gray-500">Kategori: {{ $tool->category->name }}</p>
                    </div>
                    @if(auth()->user()->isAdmin())
                        <div class="flex space-x-2">
                            <a href="{{ route('tools.edit', $tool) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md text-sm font-medium">
                                Edit
                            </a>
                            <form action="{{ route('tools.destroy', $tool) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus alat ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md text-sm font-medium">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
                <div class="mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Deskripsi</h3>
                    <p class="text-gray-600">{{ $tool->description ?? 'Tidak ada deskripsi' }}</p>
                </div>
                <div class="mb-6">
                    <span class="text-lg font-semibold text-gray-900">Stok: </span>
                    <span class="text-lg font-bold {{ $tool->stock > 0 ? 'text-green-600' : 'text-red-600' }}">{{ $tool->stock }}</span>
                </div>
                @if(!auth()->user()->isAdmin() && $tool->stock > 0 && auth()->user()->isActive())
                    <a href="{{ route('transactions.create', ['tool_id' => $tool->id]) }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-md font-medium">
                        Ajukan Peminjaman
                    </a>
                @endif
            </div>
        </div>
    </div>
    <div class="mt-4">
        <a href="{{ route('tools.index') }}" class="text-indigo-600 hover:text-indigo-800">← Kembali ke Daftar Alat</a>
    </div>
</div>
@endsection
