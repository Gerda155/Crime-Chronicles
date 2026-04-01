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
    public function usersIndex(Request $request)
    {
        $query = User::query()->withCount('completedCases')->with('achievements');
        $query->where('id', '!=', Auth::id());

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
                $query->orderBy('id', 'asc');
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
            case 'status':
                $query->orderBy('status', 'asc');
                break;
            default:
                $query->orderBy('id', 'desc');
        }

        $users = $query->paginate(10)->withQueryString();

        return view('moderator.users.index', compact('users'));
    }

    public function showUser(User $user)
    {
        $user->load('achievements');

        return view('moderator.users.show', compact('user'));
    }

    public function deactivateUser(User $user)
    {
        $user->update(['status' => 'inactive']);

        return redirect()->route('moderator.users.index')->with('success', 'Lietotājs deaktivēts');
    }

    public function activateUser(User $user)
    {
        $user->update(['status' => 'active']);

        return redirect()->route('moderator.users.index')->with('success', 'Lietotājs aktivēts');
    }

    public function destroyUser(User $user)
    {
        $user->delete();
        return redirect()->route('moderator.users.index')->with('success', 'Lietotājs dzēsts!');
    }

    public function restoreUser($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();
        return redirect()->route('moderator.users.index')->with('success', 'Lietotājs atjaunots!');
    }



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
                case 'status':
                    $query->orderBy('status', 'asc');
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
        $genres = Genre::all();
        return view('moderator.cases.create', compact('genres'));
    }

    public function storeCase(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'genre_id' => 'nullable|exists:genres,id',
        ]);

        $data['rating'] = 0;

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
        ]);

        $case->update($data);

        return redirect()->route('moderator.cases.index')->with('success', 'Lieta atjaunināta');
    }

    public function deactivateCase(CaseModel $case)
    {
        $case->update(['status' => 'inactive']);
        return redirect()->route('moderator.cases.index')->with('success', 'Lieta deaktivēta');
    }

    public function activateCase(CaseModel $case)
    {
        $case->update(['status' => 'active']);
        return redirect()->route('moderator.cases.index')->with('success', 'Lieta aktivēta');
    }

    public function destroyCase(CaseModel $case)
    {
        $case->delete();
        return redirect()->route('moderator.cases.index')->with('success', 'Lieta dzēsta!');
    }

    public function restoreCase($id)
    {
        $case = CaseModel::withTrashed()->findOrFail($id);
        $case->restore();
        return redirect()->route('moderator.cases.index')->with('success', 'Lieta atjaunota!');
    }



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



    public function achievementsIndex(Request $request)
    {
        $query = Achievement::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $sort = $request->input('sort', 'newest');

        switch ($sort) {
            case 'oldest':
                $query->orderBy('id', 'asc');
                break;
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            case 'points':
                $query->orderBy('required_cases', 'desc');
                break;
            default:
                $query->orderBy('id', 'desc');
                break;
        }

        $achievements = Achievement::whereNull('deleted_at')->paginate(6);

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
            'icon' => 'nullable|image|max:2048',
            'required_cases' => 'required|integer|min:1',
        ]);

        if ($request->hasFile('icon')) {
            $data['icon'] = $request->file('icon')->store('achievements', 'public');
        }

        Achievement::create($data);

        return redirect()->route('moderator.achievements.index')->with('success', 'Sasniegums izveidots!');
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
            'icon' => 'nullable|image|max:2048',
            'required_cases' => 'required|integer|min:1'
        ]);

        if ($request->hasFile('icon')) {

            if ($achievement->icon) {
                Storage::disk('public')->delete($achievement->icon);
            }

            $data['icon'] = $request->file('icon')->store('achievements', 'public');
        }

        $achievement->update($data);

        return redirect()->route('moderator.achievements.index')->with('success', 'Sasniegums atjaunināts!');
    }

    public function deactivateAchievement(Achievement $achievement)
    {
        $achievement->update(['status' => 'inactive']);
        return redirect()->route('moderator.achievements.index')->with('success', 'Sasniegums deaktivēts!');
    }

    public function activateAchievement(Achievement $achievement)
    {
        $achievement->update(['status' => 'active']);
        return redirect()->route('moderator.achievements.index')->with('success', 'Sasniegums aktivēts!');
    }

    public function destroyAchievement(Achievement $achievement)
    {
        if ($achievement->icon) {
            Storage::disk('public')->delete($achievement->icon);
        }
        $achievement->delete();
        return redirect()->route('moderator.achievements.index')->with('success', 'Sasniegums dzēsts!');
    }




    public function genresIndex(Request $request)
    {
        $query = Genre::query();

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        $sort = $request->input('sort', 'newest');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('id', 'asc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->orderBy('id', 'desc');
                break;
        }

        $genres = Genre::whereNull('deleted_at')->paginate(10);

        $editGenre = null;

        return view('moderator.genres.index', compact('genres', 'editGenre'));
    }

    public function storeGenre(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:genres,name',
        ]);

        Genre::create($data);

        return redirect()->route('moderator.genres.index')->with('success', 'Žanrs izveidots!');
    }

    public function editGenre(Genre $genre)
    {
        $query = Genre::query();
        $genres = $query->paginate(10)->withQueryString();

        $editGenre = $genre;

        return view('moderator.genres.index', compact('genres', 'editGenre'));
    }

    public function updateGenre(Request $request, Genre $genre)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:genres,name,' . $genre->id,
        ]);

        $genre->update($data);

        return redirect()->route('moderator.genres.index')->with('success', 'Žanrs atjaunināts!');
    }

    public function deactivateGenre(Genre $genre)
    {
        $genre->update(['status' => 'inactive']);
        return redirect()->route('moderator.genres.index')->with('success', 'Žanrs deaktivēts!');
    }

    public function activateGenre(Genre $genre)
    {
        $genre->update(['status' => 'active']);
        return redirect()->route('moderator.genres.index')->with('success', 'Žanrs aktivēts!');
    }

    public function destroyGenre(Genre $genre)
    {
        $genre->delete();
        return redirect()->route('moderator.genres.index')->with('success', 'Žanrs dzēsts!');
    }
}
