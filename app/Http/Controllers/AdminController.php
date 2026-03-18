<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function moderatorsIndex()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $moderators = User::where('role', 'moderator')->paginate(10);
        return view('admin.moderators.index', compact('moderators'));
    }

    public function usersIndex(Request $request)
    {
        $query = User::query()->whereIn('role', ['user', 'moderator']);

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
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'email':
                $query->orderBy('email', 'asc');
                break;
            case 'role':
                $query->orderBy('role', 'asc');
                break;
            case 'statuss':
                $query->orderBy('statuss', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $users = $query->paginate(10)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function createModerator()
    {
        return view('admin.users.create');
    }

    public function storeModerator(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:moderator,administrator',
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['statuss'] = 'aktivs';

        User::create($data);

        return redirect()->route('admin.users.index')->with('success', 'Moderators izveidots');
    }

    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $data = $request->validate([
            'role' => 'required|in:moderator,administrator',
            'statuss' => 'required|in:aktivs,neaktivs',
        ]);

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Lietotājs atjaunināts');
    }

    public function deactivateUser(User $user)
    {
        $user->update(['statuss' => 'neaktivs']);
        return redirect()->route('admin.users.index')->with('success', 'Lietotājs deaktivēts');
    }

    public function activateUser(User $user)
    {
        $user->update(['statuss' => 'aktivs']);
        return redirect()->route('admin.users.index')->with('success', 'Lietotājs aktivēts');
    }
}
