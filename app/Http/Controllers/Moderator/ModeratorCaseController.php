<?php

namespace App\Http\Controllers\Moderator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CaseModel;
use App\Models\Genre;

class ModeratorCaseController extends Controller
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

    public function setTutorial(int $id)
    {
        CaseModel::where('is_tutorial', 1)->update([
            'is_tutorial' => 0
        ]);

        $case = CaseModel::findOrFail($id);

        $case->is_tutorial = 1;
        $case->save();

        return back()->with('success', 'Tutorial veiksmīgi atjaunināts!');
    }
}
