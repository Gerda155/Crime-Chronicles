<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CaseModel;
use App\Models\Genre;
use Illuminate\Support\Facades\Auth;

class CaseController extends Controller
{
    public function index(Request $request)
    {
        $query = CaseModel::with('genre')
            ->where('statuss', 'aktīvs');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $sort = $request->get('sort', 'newest');
        switch ($sort) {
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
                $query->join('genres', 'cases.genre_id', '=', 'genres.id')
                    ->orderBy('genres.name', 'asc')
                    ->select('cases.*');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
        }

        $cases = $query->paginate(9)->withQueryString();
        return view('cases.index', compact('cases'));
    }

    public function myCases(Request $request)
    {
        $user = Auth::user();

        $query = CaseModel::with('genre')
            ->where('user_id', $user->id);

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $sort = $request->get('sort', 'newest');
        switch ($sort) {
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
                $query->join('genres', 'cases.genre_id', '=', 'genres.id')
                    ->orderBy('genres.name', 'asc')
                    ->select('cases.*');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $cases = $query->paginate(10)->withQueryString();

        return view('cases.my-cases', compact('cases'));
    }


    public function edit($id)
    {
        $case = CaseModel::findOrFail($id);
        if ($case->user_id != Auth::id()) abort(403);
        return view('cases.edit', compact('case'));
    }

    public function update(Request $request, $id)
    {
        $case = CaseModel::findOrFail($id);
        if ($case->user_id != Auth::id()) abort(403);

        $case->update($request->all());
        return redirect()->route('cases.my-cases');
    }

    public function destroy($id)
    {
        $case = CaseModel::findOrFail($id);
        if ($case->user_id != Auth::id()) abort(403);

        $case->delete();
        return redirect()->route('cases.my-cases');
    }

    public function play(CaseModel $case)
    {
        $evidence = $case->evidence()->get();
        $suspects = $case->suspects()->get();

        return view('cases.play', compact('case', 'evidence', 'suspects'));
    }

    public function submit(Request $request, CaseModel $case)
{
    $request->validate([
        'suspect_id' => 'required|exists:suspects,id',
    ]);

    $user = Auth::user();

    $alreadyCompleted = $user->attempts()
        ->where('case_id', $case->id)
        ->where('is_correct', 1)
        ->exists();

    $isCorrect = $request->suspect_id == $case->answer_id;

    if ($isCorrect && !$alreadyCompleted) {
        $user->attempts()->create([
            'case_id' => $case->id,
            'suspect_id' => $request->suspect_id,
            'is_correct' => true,
        ]);
    }

    $status = $isCorrect ? "Pareizi! Tu atradi īsto aizdomās turamo!" : "Nepareizi. Mēģini vēlreiz.";

    return redirect()->route('cases.play', $case->id)
                     ->with('status', $status);
}

}
