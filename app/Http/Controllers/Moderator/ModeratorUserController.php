<?php

namespace App\Http\Controllers\Moderator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Services\ActivityLogService;

class ModeratorUserController extends Controller
{
    public function usersIndex(Request $request)
    {
        $query = User::query()->withCount('completedCases')->with('achievements');
        $query->where('id', '!=', Auth::id());

        if (Auth::user()->role === 'moderator') {
            $query->where('role', 'user');
        } elseif (Auth::user()->role === 'admin') {
            $query->whereIn('role', ['user', 'moderator']);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        switch ($request->get('sort')) {

            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;

            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;

            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;

            case 'email_asc':
                $query->orderBy('email', 'asc');
                break;

            case 'role':
                $query->orderBy('role', 'asc');
                break;

            case 'most_cases':
                $query->withCount('cases')
                    ->orderBy('cases_count', 'desc');
                break;

            case 'most_achievements':
                $query->withCount('achievements')
                    ->orderBy('achievements_count', 'desc');
                break;

            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $users = $query->paginate(10)->withQueryString();

        return view('moderator.users.index', compact('users'));
    }

    public function showUser(User $user)
    {
        $user->load('achievements');

        return view('moderator.users.show', compact('user'));
    }

    public function deactivateUser(User $user)
    {
        ActivityLogService::log('update', 'user', $user->id, $user->toArray(), ['status' => 'inactive']);
        $user->update(['status' => 'inactive']);

        return redirect()->route('moderator.users.index')->with('success', 'Lietotājs deaktivēts');
    }

    public function activateUser(User $user)
    {
        ActivityLogService::log('update', 'user', $user->id, $user->toArray(), ['status' => 'active']);
        $user->update(['status' => 'active']);

        return redirect()->route('moderator.users.index')->with('success', 'Lietotājs aktivēts');
    }

    public function destroyUser(User $user)
    {
        ActivityLogService::log('delete', 'user', $user->id, $user->toArray(), null);
        $user->delete();
        return redirect()->route('moderator.users.index')->with('success', 'Lietotājs dzēsts!');
    }

    public function restoreUser(int $id)
    {
        ActivityLogService::log('update', 'user', $id, [], ['status' => 'active']);
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();
        return redirect()->route('moderator.users.index')->with('success', 'Lietotājs atjaunots!');
    }
}
