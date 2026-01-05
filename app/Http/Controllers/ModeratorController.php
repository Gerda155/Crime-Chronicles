<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\User;
use App\Models\CaseModel;
use Illuminate\Support\Facades\Storage;

class ModeratorController extends Controller
{
    public function index()
    {
        $cases = CaseModel::latest()->get();
        $users = User::all();
        return view('moderator.stats', compact('cases', 'users'));
    }

    public function editCase(CaseModel $case)
    {
        return view('moderator.edit-case', compact('case'));
    }

    public function updateCase(Request $request, CaseModel $case)
    {
        $case->update($request->only(['title', 'description', 'genre_id', 'rating']));
        return redirect()->route('moderator.cases.index')->with('success', 'Lieta atjaunināta');
    }

public function deactivateCase(CaseModel $case)
{
    $case->update(['statuss' => 'neaktivs']);
    return redirect()->route('moderator.cases.index')->with('success', 'Lieta deaktivēta');
}


    public function deactivateUser(User $user)
    {
        $user->update(['active' => false]);
        return redirect()->route('moderator.users')->with('success', 'Lietotājs deaktivēts');
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
        case 'statuss': 
            $query->orderBy('statuss', 'asc');
            break;
    }
} else {
    $query->latest();
}


        $cases = $query->paginate(10)->withQueryString();

        return view('moderator.cases', compact('cases'));
    }


    public function usersIndex()
    {
        $users = User::all();
        return view('moderator.users', compact('users'));
    }

    public function stats()
    {
        $totalCases = CaseModel::count();
        $activeCases = CaseModel::where('statuss', 'aktīvs')->count();
        $totalUsers = User::count();
        $activeUsers = User::where('active', true)->count();

        return view('moderator.stats', compact('totalCases', 'activeCases', 'totalUsers', 'activeUsers'));
    }
}
