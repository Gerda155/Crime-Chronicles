<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
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
        return view('moderator.users.show', compact('user'));
    }

    public function editUser(User $user)
    {
        return view('moderator.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $data = $request->validate([
            'role' => 'required|in:admin,moderator,user',
            'status' => 'required|in:active,inactive',
        ]);

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Lietotājs atjaunināts');
    }


    public function deactivateUser(User $user)
    {
        $user->update(['status' => 'inactive']);
        return redirect()->back()->with('success', 'Lietotājs deaktivizēts!');
    }

    public function activateUser(User $user)
    {
        $user->update(['status' => 'active']);
        return redirect()->back()->with('success', 'Lietotājs aktivizēts!');
    }


    public function destroyUser(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'Lietotājs dzēsts!');
    }

    public function restoreUser(int $id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();
        return redirect()->back()->with('success', 'Lietotājs atjaunots');
    }


    public function storeModerator(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'name' => $data['name'],
            'password' => bcrypt($data['password']),
            'role' => 'moderator',
            'status' => 'active',
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Moderators veiksmīgi pievienots');
    }
}
