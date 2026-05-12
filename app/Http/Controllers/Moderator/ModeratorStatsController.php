<?php

namespace App\Http\Controllers\Moderator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CaseModel;
use App\Models\User;
use App\Models\Genre;
use App\Models\Achievement;
use App\Models\Rang;

class ModeratorStatsController extends Controller
{
    public function stats()
    {
        $totalCases = CaseModel::count();
        $activeCases = CaseModel::where('status', 'active')->count();

        $totalUsers = User::whereNotIn('role', ['moderator', 'administrator'])->count();
        $activeUsers = User::where('status', 'active')->count();
        $activeUsers = User::where('status', 'active')
            ->where('role', '!=', 'administrator')
            ->where('role', '!=', 'moderator')
            ->count();


        $casesByGenre = CaseModel::where('status', '!=', 'inactive')
            ->selectRaw('genre_id, count(*) as count')
            ->groupBy('genre_id')
            ->with('genre')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->genre->name ?? 'Nav žanra' => $item->count];
            });

        $genreLabels = $casesByGenre->keys();
        $genreData = $casesByGenre->values();

        $registrations = User::where('status', '!=', 'inactive')
            ->where('created_at', '>=', now()->subDays(7))
            ->selectRaw('DATE(created_at) as date, count(*) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $regLabels = $registrations->pluck('date')->map(fn($d) => \Carbon\Carbon::parse($d)->format('d.m'))->toArray();
        $regData = $registrations->pluck('total')->toArray();

        return view('moderator.stats', [
            'totalCases' => $totalCases,
            'activeCases' => $activeCases,
            'totalUsers' => $totalUsers,
            'activeUsers' => $activeUsers,
            'casesByGenre' => [
                'labels' => $genreLabels,
                'data' => $genreData,
            ],
            'regLabels' => $regLabels,
            'regData' => $regData,
        ]);
    }
}
