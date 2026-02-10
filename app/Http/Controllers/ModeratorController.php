<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\User;
use App\Models\CaseModel;
use App\Models\Genre;
use Illuminate\Support\Facades\Storage;
use App\Models\Achievement;


class ModeratorController extends Controller
{
    public function casesIndex(Request $request)
    {
        $query = CaseModel::query();

        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->sort) {
            switch ($request->sort) {
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'rating':
                    $query->orderBy('rating', 'desc');
                    break;
                case 'title':
                    $query->orderBy('title', 'asc');
                    break;
                case 'genre':
                    $query->orderBy('genre_id', 'asc');
                    break;
                case 'statuss':
                    $query->orderBy('statuss', 'asc');
                    break;
            }
        } else {
            $query->latest();
        }

        $cases = $query->paginate(10)->withQueryString();
        return view('moderator.cases.index', compact('cases'));
    }

    public function createCase()
    {
        $genres = Genre::all(); // для селекта
        return view('moderator.cases.create', compact('genres'));
    }

    public function storeCase(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'genre_id' => 'nullable|exists:genres,id',
            'rating' => 'nullable|numeric|min:0|max:5',
        ]);

        CaseModel::create($data);

        return redirect()->route('moderator.cases.index')->with('success', 'Lieta izveidota!');
    }

    public function editCase(CaseModel $case)
    {
        $genres = Genre::all();
        return view('moderator.cases.edit', compact('case', 'genres'));
    }

    public function updateCase(Request $request, CaseModel $case)
    {
        $data = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'genre_id' => 'nullable|exists:genres,id',
            'rating' => 'nullable|numeric|min:0|max:5',
        ]);

        $case->update($data);

        return redirect()->route('moderator.cases.index')->with('success', 'Lieta atjaunināta');
    }

    public function deactivateCase(CaseModel $case)
    {
        $case->update(['statuss' => 'neaktivs']);
        return redirect()->route('moderator.cases.index')->with('success', 'Lieta deaktivēta');
    }

    public function activateCase(CaseModel $case)
    {
        $case->update(['statuss' => 'aktivs']);
        return redirect()->route('moderator.cases.index')->with('success', 'Lieta aktivēta');
    }

    public function usersIndex(Request $request)
    {
        $query = User::query();

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

        return view('moderator.users', compact('users'));
    }

    public function stats()
    {
        $totalCases = CaseModel::count();
        $activeCases = CaseModel::where('statuss', 'aktivs')->count();

        $totalUsers = User::whereNotIn('role', ['moderator', 'administrator'])->count();
        $activeUsers = User::where('statuss', 'aktivs')->count();
        $activeUsers = User::where('statuss', 'aktivs')
            ->where('role', '!=', 'administrator')
            ->where('role', '!=', 'moderator')
            ->count();


        $casesByGenre = CaseModel::where('statuss', '!=', 'neaktivs')
            ->selectRaw('genre_id, count(*) as count')
            ->groupBy('genre_id')
            ->with('genre')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->genre->name ?? 'Nav žanra' => $item->count];
            });

        $genreLabels = $casesByGenre->keys();
        $genreData = $casesByGenre->values();

        $registrations = User::where('statuss', '!=', 'neaktivs')
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

    public function achievementsIndex()
    {
        $achievements = Achievement::orderBy('created_at', 'desc')->paginate(10);
        return view('moderator.achievements.index', compact('achievements'));
    }

    public function createAchievement()
    {
        return view('moderator.achievements.create');
    }

    public function storeAchievement(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'icon' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('icon')) {
            $data['icon'] = $request->file('icon')->store('achievements', 'public');
        }

        Achievement::create($data);

        return redirect()->route('moderator.achievements.index')
            ->with('success', 'Sasniegums izveidots!');
    }

    public function editAchievement(Achievement $achievement)
    {
        return view('moderator.achievements.edit', compact('achievement'));
    }

    public function updateAchievement(Request $request, Achievement $achievement)
    {
        $data = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'icon' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('icon')) {

            if ($achievement->icon) {
                Storage::disk('public')->delete($achievement->icon);
            }

            $data['icon'] = $request->file('icon')->store('achievements', 'public');
        }


        $achievement->update($data);

        return redirect()->route('moderator.achievements.index')
            ->with('success', 'Sasniegums atjaunināts!');
    }

    public function destroyAchievement(Achievement $achievement)
    {
        if ($achievement->icon) {
            Storage::disk('public')->delete($achievement->icon);
        }

        $achievement->delete();

        return redirect()->route('moderator.achievements.index')
            ->with('success', 'Sasniegums dzēsts!');
    }
}
