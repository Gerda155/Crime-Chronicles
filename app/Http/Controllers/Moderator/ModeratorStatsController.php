<?php

namespace App\Http\Controllers\Moderator;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\CaseModel;
use Illuminate\Support\Facades\DB;

class ModeratorStatsController extends Controller
{
    public function index()
    {
        $totalCases = CaseModel::count();
        $activeCases = CaseModel::where('status', 'published')->count();
        $totalUsers = User::count();
        $activeUsers = User::where('status', 'active')->count();

        $casesByGenre = CaseModel::select('genre_id', DB::raw('count(*) as count'))
            ->groupBy('genre_id')
            ->get();

        $casesByGenreData = [
            'labels' => $casesByGenre->pluck('genre_id')->toArray(),
            'data' => $casesByGenre->pluck('count')->toArray()
        ];

        $registrations = User::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('count(*) as count')
        )
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $regLabels = [];
        $regData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $regLabels[] = $date;

            $found = $registrations->firstWhere('date', $date);
            $regData[] = $found ? $found->count : 0;
        }


        return view('moderator.stats', compact(
            'totalCases',
            'activeCases',
            'totalUsers',
            'activeUsers',
            'casesByGenreData',
            'regLabels',
            'regData'
        ));
    }
}
