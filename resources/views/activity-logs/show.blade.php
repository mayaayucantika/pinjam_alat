@extends('layouts.app')

@section('title', 'Detail Log Aktifitas')

@section('content')
<div class="py-6">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Detail Log Aktifitas</h1>

    <div class="bg-white shadow rounded-lg p-6">
        <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
            <div>
                <dt class="text-sm font-medium text-gray-500">Waktu</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $activityLog->created_at->format('d/m/Y H:i:s') }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">User</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $activityLog->user->name ?? 'System' }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Aksi</dt>
                <dd class="mt-1">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                        @if($activityLog->action == 'create') bg-green-100 text-green-800
                        @elseif($activityLog->action == 'update') bg-blue-100 text-blue-800
                        @elseif($activityLog->action == 'delete') bg-red-100 text-red-800
                        @elseif($activityLog->action == 'approve') bg-green-100 text-green-800
                        @elseif($activityLog->action == 'reject') bg-red-100 text-red-800
                        @elseif($activityLog->action == 'return') bg-purple-100 text-purple-800
                        @elseif($activityLog->action == 'login') bg-indigo-100 text-indigo-800
                        @elseif($activityLog->action == 'logout') bg-gray-100 text-gray-800
                        @else bg-gray-100 text-gray-800
                        @endif">
                        {{ ucfirst($activityLog->action) }}
                    </span>
                </dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Model</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $activityLog->model_type ? class_basename($activityLog->model_type) : '-' }}</dd>
            </div>
            <div class="sm:col-span-2">
                <dt class="text-sm font-medium text-gray-500">Deskripsi</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $activityLog->description }}</dd>
            </div>
            @if($activityLog->old_values)
                <div class="sm:col-span-2">
                    <dt class="text-sm font-medium text-gray-500">Nilai Lama</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        <pre class="bg-gray-50 p-3 rounded text-xs overflow-auto">{{ json_encode($activityLog->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                    </dd>
                </div>
            @endif
            @if($activityLog->new_values)
                <div class="sm:col-span-2">
                    <dt class="text-sm font-medium text-gray-500">Nilai Baru</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        <pre class="bg-gray-50 p-3 rounded text-xs overflow-auto">{{ json_encode($activityLog->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                    </dd>
                </div>
            @endif
            <div>
                <dt class="text-sm font-medium text-gray-500">IP Address</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $activityLog->ip_address ?? '-' }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">User Agent</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $activityLog->user_agent ?? '-' }}</dd>
            </div>
        </dl>

        <div class="mt-6">
            <a href="{{ route('activity-logs.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md">
                Kembali
            </a>
        </div>
    </div>
</div>
@endsection
