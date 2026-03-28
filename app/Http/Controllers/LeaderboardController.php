<?php

namespace App\Http\Controllers;

use App\Models\User;

class LeaderboardController extends Controller
{
    public function index()
    {

        $topDetectives = User::where('status', 'active') 
            ->withCount('completedCases') 
            ->withCount('achievements')   
            ->orderByDesc('completed_cases_count') 
            ->take(10)  
            ->get();

        return view('leaderboard.index', compact('topDetectives'));
    }
}
