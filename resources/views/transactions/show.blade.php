@extends('layouts.app')

@section('title', 'Detail Transaksi')

@section('content')
<div class="py-6">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Detail Transaksi</h1>

    <div class="bg-white shadow rounded-lg p-6">
        <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
            <div>
                <dt class="text-sm font-medium text-gray-500">Peminjam</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $transaction->user->name }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Alat</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $transaction->tool->name }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Jumlah</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $transaction->quantity }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Tanggal Pinjam</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $transaction->borrow_date->format('d/m/Y') }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Tanggal Kembali</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $transaction->return_date->format('d/m/Y') }}</dd>
            </div>
            @if($transaction->actual_return_date)
                <div>
                    <dt class="text-sm font-medium text-gray-500">Tanggal Dikembalikan</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $transaction->actual_return_date->format('d/m/Y') }}</dd>
                </div>
            @endif
            <div>
                <dt class="text-sm font-medium text-gray-500">Status</dt>
                <dd class="mt-1">
                    @if($transaction->status === 'pending')
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                    @elseif($transaction->status === 'approved')
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>
                    @elseif($transaction->status === 'rejected')
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                    @else
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Dikembalikan</span>
                    @endif
                </dd>
            </div>
            @if($transaction->notes)
                <div class="sm:col-span-2">
                    <dt class="text-sm font-medium text-gray-500">Catatan</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $transaction->notes }}</dd>
                </div>
            @endif
        </dl>

        <div class="mt-6 flex justify-end space-x-3">
            @if(auth()->user()->isAdmin() || auth()->user()->isPetugas())
                @if($transaction->status === 'pending')
                    <form action="{{ route('transactions.approve', $transaction) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md">
                            Setujui
                        </button>
                    </form>
                    <form action="{{ route('transactions.reject', $transaction) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md">
                            Tolak
                        </button>
                    </form>
                @endif
            @endif
            @if($transaction->status === 'approved')
                <form action="{{ route('transactions.return', $transaction) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                        Kembalikan
                    </button>
                </form>
            @endif
            <a href="{{ route('transactions.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md">
                Kembali
            </a>
        </div>
    </div>
</div>
@endsection
