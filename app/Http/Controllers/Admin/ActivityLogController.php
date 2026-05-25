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

        if ($search = $request->search) {

            $query->where(function ($q) use ($search) {

                $q->where('username', 'like', "%{$search}%")
                    ->orWhere('action_type', 'like', "%{$search}%")
                    ->orWhere('object_type', 'like', "%{$search}%");
            });
        }

        $sort = $request->get('sort', 'newest');

        switch ($sort) {

            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;

            case 'login':
                $query->where('action_type', 'login')
                    ->orderBy('created_at', 'desc');
                break;

            case 'logout':
                $query->where('action_type', 'logout')
                    ->orderBy('created_at', 'desc');
                break;

            case 'delete':
                $query->where('action_type', 'delete')
                    ->orderBy('created_at', 'desc');
                break;

            case 'approve':
                $query->where('action_type', 'approve')
                    ->orderBy('created_at', 'desc');
                break;

            case 'case':
                $query->where('object_type', 'case')
                    ->orderBy('created_at', 'desc');
                break;

            case 'user':
                $query->where('object_type', 'user')
                    ->orderBy('created_at', 'desc');
                break;

            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $logs = $query->paginate(15)->withQueryString();

        return view('admin.logs.index', compact('logs'));
    }
}
