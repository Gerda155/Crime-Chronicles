<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $query = Notification::where('user_id', Auth::id());

        if ($request->search) {
            $query->where('message', 'like', '%' . $request->search . '%');
        }

        switch ($request->sort) {

            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;

            case 'unread':
                $query->orderBy('is_read', 'asc')
                    ->orderBy('created_at', 'desc');
                break;

            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $notifications = $query->paginate(10)->withQueryString();

        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead(Notification $notification)
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }

        $notification->update([
            'is_read' => true
        ]);

        return back();
    }

    public function destroy(Notification $notification)
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }

        $notification->delete();

        return back()->with('success', 'Paziņojums dzēsts');
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return back()->with('success', 'Visi paziņojumi atzīmēti kā izlasīti');
    }

    public function deleteAll()
    {
        Notification::where('user_id', Auth::id())->delete();
        return back()->with('success', 'Visi paziņojumi dzēsti');
    }
}
