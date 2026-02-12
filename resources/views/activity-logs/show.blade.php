@extends('layouts.app')

@section('title', 'Detail Log Aktifitas')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Detail Log Aktifitas</h1>
        <p class="text-gray-500 mt-1">Informasi lengkap log aktifitas</p>
    </div>

    <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 border border-gray-100">
        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="p-4 rounded-xl bg-indigo-50/50">
                <dt class="text-sm font-medium text-gray-500">Waktu</dt>
                <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $activityLog->created_at->format('d/m/Y H:i:s') }}</dd>
            </div>
            <div class="p-4 rounded-xl bg-indigo-50/50">
                <dt class="text-sm font-medium text-gray-500">User</dt>
                <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $activityLog->user->name ?? 'System' }}</dd>
            </div>
            <div class="p-4 rounded-xl bg-indigo-50/50">
                <dt class="text-sm font-medium text-gray-500">Aksi</dt>
                <dd class="mt-2">
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
                    <span class="inline-flex px-3 py-1 rounded-full text-sm font-semibold {{ $actionStyles[$activityLog->action] ?? 'bg-gray-100 text-gray-800' }}">
                        {{ ucfirst($activityLog->action) }}
                    </span>
                </dd>
            </div>
            <div class="p-4 rounded-xl bg-indigo-50/50">
                <dt class="text-sm font-medium text-gray-500">Model</dt>
                <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $activityLog->model_type ? class_basename($activityLog->model_type) : '-' }}</dd>
            </div>
            <div class="sm:col-span-2 p-4 rounded-xl bg-gray-50">
                <dt class="text-sm font-medium text-gray-500">Deskripsi</dt>
                <dd class="mt-1 text-gray-900">{{ $activityLog->description }}</dd>
            </div>
            @if($activityLog->old_values)
                <div class="sm:col-span-2 p-4 rounded-xl bg-rose-50/50 border border-rose-100">
                    <dt class="text-sm font-medium text-gray-500">Nilai Lama</dt>
                    <dd class="mt-2">
                        <pre class="bg-white p-4 rounded-xl text-xs overflow-auto border border-rose-100">{{ json_encode($activityLog->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                    </dd>
                </div>
            @endif
            @if($activityLog->new_values)
                <div class="sm:col-span-2 p-4 rounded-xl bg-emerald-50/50 border border-emerald-100">
                    <dt class="text-sm font-medium text-gray-500">Nilai Baru</dt>
                    <dd class="mt-2">
                        <pre class="bg-white p-4 rounded-xl text-xs overflow-auto border border-emerald-100">{{ json_encode($activityLog->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                    </dd>
                </div>
            @endif
            <div class="p-4 rounded-xl bg-indigo-50/50">
                <dt class="text-sm font-medium text-gray-500">IP Address</dt>
                <dd class="mt-1 text-gray-900 font-mono text-sm">{{ $activityLog->ip_address ?? '-' }}</dd>
            </div>
            <div class="p-4 rounded-xl bg-indigo-50/50">
                <dt class="text-sm font-medium text-gray-500">User Agent</dt>
                <dd class="mt-1 text-gray-900 text-sm">{{ $activityLog->user_agent ?? '-' }}</dd>
            </div>
        </dl>

        <div class="mt-8">
            <a href="{{ route('activity-logs.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-xl transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Kembali
            </a>
        </div>
    </div>
</div>
@endsection
