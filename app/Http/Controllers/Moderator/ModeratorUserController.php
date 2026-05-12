<?php

namespace App\Http\Controllers\Moderator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
                $query->orderBy('id', 'asc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'email':
                $query->orderBy('email', 'asc');
                break;
            case 'role':
                $query->orderBy('role', 'asc');
                break;
            case 'status':
                $query->orderBy('status', 'asc');
                break;
            default:
                $query->orderBy('id', 'desc');
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
        $user->update(['status' => 'inactive']);

        return redirect()->route('moderator.users.index')->with('success', 'Lietotājs deaktivēts');
    }

    public function activateUser(User $user)
    {
        $user->update(['status' => 'active']);

        return redirect()->route('moderator.users.index')->with('success', 'Lietotājs aktivēts');
    }

    public function destroyUser(User $user)
    {
        $user->delete();
        return redirect()->route('moderator.users.index')->with('success', 'Lietotājs dzēsts!');
    }

    public function restoreUser($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();
        return redirect()->route('moderator.users.index')->with('success', 'Lietotājs atjaunots!');
    }
}
