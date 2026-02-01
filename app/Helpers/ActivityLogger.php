<?php

namespace App\Helpers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogger
{
    public static function log(string $action, string $description, $model = null, array $oldValues = null, array $newValues = null): void
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'model_type' => $model ? get_class($model) : null,
            'model_id' => $model?->id,
            'description' => $description,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }

    public static function logCreate($model, string $description = null): void
    {
        self::log(
            'create',
            $description ?? 'Membuat ' . class_basename($model) . ': ' . ($model->name ?? $model->id),
            $model,
            null,
            $model->getAttributes()
        );
    }

    public static function logUpdate($model, array $oldValues, string $description = null): void
    {
        self::log(
            'update',
            $description ?? 'Memperbarui ' . class_basename($model) . ': ' . ($model->name ?? $model->id),
            $model,
            $oldValues,
            $model->getAttributes()
        );
    }

    public static function logDelete($model, string $description = null): void
    {
        self::log(
            'delete',
            $description ?? 'Menghapus ' . class_basename($model) . ': ' . ($model->name ?? $model->id),
            $model,
            $model->getAttributes(),
            null
        );
    }

    public static function logAction(string $action, string $description, $model = null): void
    {
        self::log($action, $description, $model);
    }
}
