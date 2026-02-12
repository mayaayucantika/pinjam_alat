@extends('layouts.app')

@section('title', 'Ajukan Peminjaman')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Ajukan Peminjaman</h1>
        <p class="text-gray-500 mt-1">Isi formulir untuk mengajukan peminjaman alat</p>
    </div>

    <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 border border-gray-100">
        <form action="{{ route('transactions.store') }}" method="POST">
            @csrf
            <div class="space-y-6">
                <div>
                    <label for="tool_id" class="block text-sm font-semibold text-gray-700 mb-1">Alat</label>
                    <select name="tool_id" id="tool_id" required
                            class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition">
                        <option value="">Pilih Alat</option>
                        @foreach($tools as $tool)
                            <option value="{{ $tool->id }}" {{ old('tool_id', request('tool_id')) == $tool->id ? 'selected' : '' }}>
                                {{ $tool->name }} (Stok: {{ $tool->stock }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="quantity" class="block text-sm font-semibold text-gray-700 mb-1">Jumlah</label>
                    <input type="number" name="quantity" id="quantity" required min="1" value="{{ old('quantity', 1) }}"
                           class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition">
                </div>

                <div>
                    <label for="borrow_date" class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Pinjam</label>
                    <input type="date" name="borrow_date" id="borrow_date" required value="{{ old('borrow_date') }}"
                           class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition">
                </div>

                <div>
                    <label for="return_date" class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Kembali</label>
                    <input type="date" name="return_date" id="return_date" required value="{{ old('return_date') }}"
                           @if(auth()->user()->isPeminjam()) readonly class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-50 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition"
                           @else class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition" @endif>
                    @if(auth()->user()->isPeminjam())
                    <p class="mt-2 text-sm text-amber-600 font-medium bg-amber-50 px-3 py-2 rounded-lg">Peminjam hanya dapat meminjam 1 hari. Tanggal kembali otomatis 1 hari setelah tanggal pinjam.</p>
                    @endif
                </div>

                <div>
                    <label for="notes" class="block text-sm font-semibold text-gray-700 mb-1">Catatan (Opsional)</label>
                    <textarea name="notes" id="notes" rows="3"
                              class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition"
                              placeholder="Catatan tambahan...">{{ old('notes') }}</textarea>
                </div>
            </div>

            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('transactions.index') }}" class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-xl transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg shadow-indigo-200 transition">
                    Ajukan Peminjaman
                </button>
            </div>
        </form>
    </div>
</div>

@if(auth()->user()->isPeminjam())
<script>
document.getElementById('borrow_date').addEventListener('change', function() {
    var borrow = this.value;
    if (!borrow) return;
    var d = new Date(borrow);
    d.setDate(d.getDate() + 1);
    var returnDate = d.toISOString().split('T')[0];
    document.getElementById('return_date').value = returnDate;
});
var borrowEl = document.getElementById('borrow_date');
if (borrowEl.value) {
    var d = new Date(borrowEl.value);
    d.setDate(d.getDate() + 1);
    document.getElementById('return_date').value = d.toISOString().split('T')[0];
}
</script>
@endif
@endsection
