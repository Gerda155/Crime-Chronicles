<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Lietotāju meklēšana pēc lietotājvārda
     */
    public function search(Request $request)
    {
        $query = trim($request->input('q'));

        $users = collect();

        if ($query !== '') {
            $users = User::with('achievements') 
                ->where('username', 'LIKE', '%' . $query . '%')
                ->where('id', '!=', Auth::id())
                ->orderBy('username') 
                ->limit(15)
                ->get();
        }

        return view('users.search', [
            'users' => $users,
            'query' => $query,
        ]);
    }
}
