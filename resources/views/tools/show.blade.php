@extends('layouts.app')

@section('title', $tool->name)

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
        <div class="md:flex">
            <div class="md:w-96 flex-shrink-0">
                @if($tool->image)
                    <img class="h-72 w-full object-cover md:h-full md:min-h-[320px]" src="{{ asset('storage/' . $tool->image) }}" alt="{{ $tool->name }}">
                @else
                    <div class="h-72 w-full bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center md:h-full md:min-h-[320px]">
                        <svg class="w-24 h-24 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                @endif
            </div>
            <div class="p-8 flex-1">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4 mb-6">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">{{ $tool->name }}</h1>
                        <p class="mt-2 inline-flex px-3 py-1 rounded-full text-sm font-semibold bg-indigo-100 text-indigo-800">{{ $tool->category->name }}</p>
                    </div>
                    @if(auth()->user()->isAdmin())
                        <div class="flex gap-2">
                            <a href="{{ route('tools.edit', $tool) }}" class="inline-flex items-center gap-1 bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-xl font-semibold transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                Edit
                            </a>
                            <form action="{{ route('tools.destroy', $tool) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus alat ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-1 bg-rose-500 hover:bg-rose-600 text-white px-4 py-2 rounded-xl font-semibold transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Deskripsi</h3>
                    <p class="text-gray-600">{{ $tool->description ?? 'Tidak ada deskripsi' }}</p>
                </div>
                <div class="mb-6">
                    <span class="text-lg font-semibold text-gray-900">Stok: </span>
                    <span class="text-2xl font-bold {{ $tool->stock > 0 ? 'text-emerald-600' : 'text-rose-600' }}">{{ $tool->stock }}</span>
                </div>
                @if(!auth()->user()->isAdmin() && $tool->stock > 0 && auth()->user()->isActive())
                    <a href="{{ route('transactions.create', ['tool_id' => $tool->id]) }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg shadow-indigo-200 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                        Ajukan Peminjaman
                    </a>
                @endif
            </div>
        </div>
    </div>
    <a href="{{ route('tools.index') }}" class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-700 font-semibold">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        Kembali ke Daftar Alat
    </a>
</div>
@endsection
