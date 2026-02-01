@extends('layouts.app')

@section('title', 'Ajukan Peminjaman')

@section('content')
<div class="py-6">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Ajukan Peminjaman</h1>

    <div class="bg-white shadow rounded-lg p-6">
        <form action="{{ route('transactions.store') }}" method="POST">
            @csrf
            <div class="space-y-6">
                <div>
                    <label for="tool_id" class="block text-sm font-medium text-gray-700">Alat</label>
                    <select name="tool_id" id="tool_id" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">Pilih Alat</option>
                        @foreach($tools as $tool)
                            <option value="{{ $tool->id }}" {{ old('tool_id', request('tool_id')) == $tool->id ? 'selected' : '' }}>
                                {{ $tool->name }} (Stok: {{ $tool->stock }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="quantity" class="block text-sm font-medium text-gray-700">Jumlah</label>
                    <input type="number" name="quantity" id="quantity" required min="1" value="{{ old('quantity', 1) }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <div>
                    <label for="borrow_date" class="block text-sm font-medium text-gray-700">Tanggal Pinjam</label>
                    <input type="date" name="borrow_date" id="borrow_date" required value="{{ old('borrow_date') }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <div>
                    <label for="return_date" class="block text-sm font-medium text-gray-700">Tanggal Kembali</label>
                    <input type="date" name="return_date" id="return_date" required value="{{ old('return_date') }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
                    <textarea name="notes" id="notes" rows="3"
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('notes') }}</textarea>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('transactions.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md">
                    Batal
                </a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md">
                    Ajukan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
