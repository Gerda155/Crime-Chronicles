<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function usersIndex()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $users = User::where('role', '!=', 'admin')->paginate(10);
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
        return redirect()->back();
    }

    public function activateUser(User $user)
    {
        $user->update(['status' => 'active']);
        return redirect()->back();
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
