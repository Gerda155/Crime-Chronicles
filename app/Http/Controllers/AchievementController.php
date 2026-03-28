<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    public function index()
    {
        $achievements = Achievement::whereNull('deleted_at')->where('status', 'active')->paginate(9);
        return view('achievements.index', compact('achievements'));
    }
}
