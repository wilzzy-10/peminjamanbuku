<?php

namespace App\Support;

use App\Models\ActivityLog;
use Illuminate\Contracts\Auth\Authenticatable;

class ActivityLogger
{
    public static function log(
        string $action,
        string $description,
        array $metadata = [],
        ?Authenticatable $actor = null
    ): void {
        $actor = $actor ?: auth()->user();

        ActivityLog::create([
            'user_id' => $actor?->getAuthIdentifier(),
            'role' => $actor?->role ?? 'guest',
            'action' => $action,
            'description' => $description,
            'metadata' => $metadata,
            'ip_address' => request()?->ip(),
            'user_agent' => request()?->userAgent(),
        ]);
    }
}
