@extends('layouts.app')

@section('title', 'Detail Transaksi')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Detail Transaksi</h1>
        <p class="text-gray-500 mt-1">Informasi lengkap pengajuan peminjaman</p>
    </div>

    <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 border border-gray-100">
        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="p-4 rounded-xl bg-indigo-50/50">
                <dt class="text-sm font-medium text-gray-500">Peminjam</dt>
                <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $transaction->user->name }}</dd>
            </div>
            <div class="p-4 rounded-xl bg-indigo-50/50">
                <dt class="text-sm font-medium text-gray-500">Alat</dt>
                <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $transaction->tool->name }}</dd>
            </div>
            <div class="p-4 rounded-xl bg-indigo-50/50">
                <dt class="text-sm font-medium text-gray-500">Jumlah</dt>
                <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $transaction->quantity }}</dd>
            </div>
            <div class="p-4 rounded-xl bg-indigo-50/50">
                <dt class="text-sm font-medium text-gray-500">Tanggal Pinjam</dt>
                <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $transaction->borrow_date->format('d/m/Y') }}</dd>
            </div>
            <div class="p-4 rounded-xl bg-indigo-50/50">
                <dt class="text-sm font-medium text-gray-500">Tanggal Kembali</dt>
                <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $transaction->return_date->format('d/m/Y') }}</dd>
            </div>
            @if($transaction->actual_return_date)
                <div class="p-4 rounded-xl bg-emerald-50/50">
                    <dt class="text-sm font-medium text-gray-500">Tanggal Dikembalikan</dt>
                    <dd class="mt-1 text-lg font-semibold text-emerald-800">{{ $transaction->actual_return_date->format('d/m/Y') }}</dd>
                </div>
            @endif
            <div class="p-4 rounded-xl bg-indigo-50/50">
                <dt class="text-sm font-medium text-gray-500">Status</dt>
                <dd class="mt-2">
                    @if($transaction->status === 'pending')
                        <span class="inline-flex px-3 py-1 rounded-full text-sm font-semibold bg-amber-100 text-amber-800 ring-1 ring-amber-200">Pending</span>
                    @elseif($transaction->status === 'approved')
                        <span class="inline-flex px-3 py-1 rounded-full text-sm font-semibold bg-emerald-100 text-emerald-800 ring-1 ring-emerald-200">Disetujui</span>
                    @elseif($transaction->status === 'rejected')
                        <span class="inline-flex px-3 py-1 rounded-full text-sm font-semibold bg-rose-100 text-rose-800 ring-1 ring-rose-200">Ditolak</span>
                    @else
                        <span class="inline-flex px-3 py-1 rounded-full text-sm font-semibold bg-sky-100 text-sky-800 ring-1 ring-sky-200">Dikembalikan</span>
                    @endif
                </dd>
            </div>
            @if($transaction->notes)
                <div class="sm:col-span-2 p-4 rounded-xl bg-gray-50">
                    <dt class="text-sm font-medium text-gray-500">Catatan</dt>
                    <dd class="mt-1 text-gray-900">{{ $transaction->notes }}</dd>
                </div>
            @endif
        </dl>

        <div class="mt-8 flex flex-wrap gap-3">
            @if(auth()->user()->isAdmin() || auth()->user()->isPetugas())
                @if($transaction->status === 'pending')
                    <form action="{{ route('transactions.approve', $transaction) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold rounded-xl transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Setujui
                        </button>
                    </form>
                    <form action="{{ route('transactions.reject', $transaction) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-rose-500 hover:bg-rose-600 text-white font-semibold rounded-xl transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            Tolak
                        </button>
                    </form>
                @endif
            @endif
            @if($transaction->status === 'approved')
                <form action="{{ route('transactions.return', $transaction) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-sky-500 hover:bg-sky-600 text-white font-semibold rounded-xl transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        Kembalikan
                    </button>
                </form>
            @endif
            <a href="{{ route('transactions.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-xl transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Kembali
            </a>
        </div>
    </div>
</div>
@endsection
