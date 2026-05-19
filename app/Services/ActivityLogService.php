<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityLogService
{
    public static function log(
        string $actionType,
        string $objectType,
        $objectId = null,
        $oldValue = null,
        $newValue = null
    ) {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'username' => Auth::check() ? Auth::user()->username : 'guest',

            'action_type' => $actionType,
            'object_type' => $objectType,
            'object_id' => $objectId,

            'old_value' => $oldValue,
            'new_value' => $newValue,

            'ip_address' => request()->ip(),
        ]);
    }
}
