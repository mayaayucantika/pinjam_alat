@extends('layouts.app')

@section('title', 'Log Aktifitas')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Log Aktifitas</h1>
        <p class="text-gray-500 mt-1">Riwayat aktivitas pengguna di sistem</p>
    </div>

    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl shadow-xl p-5 text-white">
        <form method="GET" action="{{ route('activity-logs.index') }}" id="logFilterForm" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="action" class="block text-sm font-medium text-indigo-100 mb-1">Aksi</label>
                <select name="action" id="action" class="block w-full rounded-xl border-0 bg-white/90 text-gray-900 focus:ring-2 focus:ring-white">
                    <option value="">Semua Aksi</option>
                    @foreach($actions as $action)
                        <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>{{ ucfirst($action) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="user_id" class="block text-sm font-medium text-indigo-100 mb-1">User</label>
                <select name="user_id" id="user_id" class="block w-full rounded-xl border-0 bg-white/90 text-gray-900 focus:ring-2 focus:ring-white">
                    <option value="">Semua User</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="search" class="block text-sm font-medium text-indigo-100 mb-1">Cari</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}"
                       placeholder="Cari deskripsi..."
                       class="block w-full rounded-xl border-0 bg-white/90 text-gray-900 focus:ring-2 focus:ring-white placeholder-gray-500">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full py-2.5 px-4 bg-white text-indigo-600 font-semibold rounded-xl hover:bg-indigo-50 transition">
                    Terapkan Filter
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-indigo-600">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-black uppercase tracking-wider">Waktu</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-black uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-black uppercase tracking-wider">Aksi</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-black uppercase tracking-wider">Deskripsi</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-black uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($logs as $log)
                        <tr class="hover:bg-indigo-50/50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $log->user->name ?? 'System' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $actionStyles = [
                                        'create' => 'bg-emerald-100 text-emerald-800 ring-1 ring-emerald-200',
                                        'update' => 'bg-sky-100 text-sky-800 ring-1 ring-sky-200',
                                        'delete' => 'bg-rose-100 text-rose-800 ring-1 ring-rose-200',
                                        'approve' => 'bg-emerald-100 text-emerald-800 ring-1 ring-emerald-200',
                                        'reject' => 'bg-rose-100 text-rose-800 ring-1 ring-rose-200',
                                        'return' => 'bg-purple-100 text-purple-800 ring-1 ring-purple-200',
                                        'login' => 'bg-indigo-100 text-indigo-800 ring-1 ring-indigo-200',
                                        'logout' => 'bg-gray-100 text-gray-800 ring-1 ring-gray-200',
                                        'register' => 'bg-indigo-100 text-indigo-800 ring-1 ring-indigo-200',
                                    ];
                                @endphp
                                <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold {{ $actionStyles[$log->action] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($log->action) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $log->description }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('activity-logs.show', $log) }}" class="text-indigo-600 hover:text-indigo-700 font-semibold">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">Tidak ada log aktifitas</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
            {{ $logs->links() }}
        </div>
    </div>
</div>

<script>
document.getElementById('logFilterForm').querySelectorAll('#action, #user_id').forEach(function(el) {
    el.addEventListener('change', function() {
        document.getElementById('logFilterForm').submit();
    });
});
</script>
@endsection
