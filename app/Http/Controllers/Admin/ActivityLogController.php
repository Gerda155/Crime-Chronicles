<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::query();

        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->action_type) {
            $query->where('action_type', $request->action_type);
        }

        if ($request->object_type) {
            $query->where('object_type', $request->object_type);
        }

        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->latest()->paginate(20);

        return view('admin.logs.index', compact('logs'));
    }
}
