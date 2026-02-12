@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Edit Kategori</h1>
        <p class="text-gray-500 mt-1">Perbarui data kategori</p>
    </div>

    <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 border border-gray-100">
        <form action="{{ route('categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nama Kategori</label>
                    <input type="text" name="name" id="name" required value="{{ old('name', $category->name) }}"
                           class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition">
                </div>
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="description" id="description" rows="4"
                              class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition">{{ old('description', $category->description) }}</textarea>
                </div>
            </div>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('categories.index') }}" class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-xl transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg shadow-indigo-200 transition">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
