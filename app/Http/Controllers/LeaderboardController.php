<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class LeaderboardController extends Controller
{

    public function index()
    {
        $topDetectives = User::where('status', 'active')
            ->leftJoin('user_progress', 'users.id', '=', 'user_progress.user_id')
            ->leftJoin('achievement_user', 'users.id', '=', 'achievement_user.user_id')
            ->select(
                'users.*',
                DB::raw('COALESCE(SUM(user_progress.score), 0) as total_score'),
                DB::raw('COUNT(DISTINCT CASE WHEN user_progress.completed = 1 THEN user_progress.id END) as completed_cases_count'),
                DB::raw('COUNT(DISTINCT achievement_user.achievement_id) as achievements_count')
            )
            ->groupBy('users.id')
            ->orderByDesc('total_score')
            ->take(10)
            ->get();

        return view('leaderboard.index', compact('topDetectives'));
    }
}
