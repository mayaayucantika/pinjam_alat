@extends('layouts.app')

@section('title', 'Transaksi')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Transaksi Peminjaman</h1>
            <p class="text-gray-500 mt-1">Kelola pengajuan dan status peminjaman alat</p>
        </div>
        @if(!auth()->user()->isAdmin() && !auth()->user()->isPetugas())
            <a href="{{ route('transactions.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-5 py-2.5 rounded-xl font-semibold shadow-lg shadow-indigo-200 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Ajukan Peminjaman
            </a>
        @endif
    </div>

    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-indigo-600">
                    <tr>
                        @if(auth()->user()->isAdmin() || auth()->user()->isPetugas())
                            <th class="px-6 py-3 text-left text-xs font-bold text-black uppercase tracking-wider">Peminjam</th>
                        @endif
                        <th class="px-6 py-3 text-left text-xs font-bold text-black uppercase tracking-wider">Alat</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-black uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-black uppercase tracking-wider">Tanggal Pinjam</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-black uppercase tracking-wider">Tanggal Kembali</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-black uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-black uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($transactions as $transaction)
                        <tr class="hover:bg-indigo-50/50 transition">
                            @if(auth()->user()->isAdmin() || auth()->user()->isPetugas())
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $transaction->user->name }}</td>
                            @endif
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $transaction->tool->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $transaction->quantity }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $transaction->borrow_date->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $transaction->return_date->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($transaction->status === 'pending')
                                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 ring-1 ring-amber-200">Pending</span>
                                @elseif($transaction->status === 'approved')
                                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 ring-1 ring-emerald-200">Disetujui</span>
                                @elseif($transaction->status === 'rejected')
                                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-100 text-rose-800 ring-1 ring-rose-200">Ditolak</span>
                                @else
                                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-sky-100 text-sky-800 ring-1 ring-sky-200">Dikembalikan</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-3">
                                <a href="{{ route('transactions.show', $transaction) }}" class="text-indigo-600 hover:text-indigo-700 font-semibold">Detail</a>
                                @if(auth()->user()->isAdmin() || auth()->user()->isPetugas())
                                    @if($transaction->status === 'pending')
                                        <form action="{{ route('transactions.approve', $transaction) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-emerald-600 hover:text-emerald-700 font-semibold">Setujui</button>
                                        </form>
                                        <form action="{{ route('transactions.reject', $transaction) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-rose-600 hover:text-rose-700 font-semibold">Tolak</button>
                                        </form>
                                    @endif
                                @endif
                                @if($transaction->status === 'approved')
                                    <form action="{{ route('transactions.return', $transaction) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-sky-600 hover:text-sky-700 font-semibold">Kembalikan</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ (auth()->user()->isAdmin() || auth()->user()->isPetugas()) ? '7' : '6' }}" class="px-6 py-12 text-center">
                                <div class="text-gray-500">
                                    <svg class="mx-auto h-14 w-14 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    <p class="mt-3 font-medium">Tidak ada transaksi</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $transactions->links() }}
    </div>
</div>
@endsection
