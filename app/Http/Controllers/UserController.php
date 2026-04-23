<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            $users = User::query()
                ->leftJoin('user_progress', 'users.id', '=', 'user_progress.user_id')
                ->select(
                    'users.*',
                    DB::raw('COALESCE(SUM(user_progress.score), 0) as total_score')
                )
                ->withCount('completedCases')
                ->withCount('achievements')
                ->where('username', 'LIKE', '%' . $query . '%')
                ->where('users.id', '!=', Auth::id())
                ->groupBy('users.id')
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
