<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CaseModel;
use App\Models\Genre;
use Illuminate\Support\Facades\Auth;

class CaseController extends Controller
{
    // Все дела
    public function index(Request $request)
    {
        $query = CaseModel::with('genre')->where('status', '!=', 'pabeigta');

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

    // Мои уровни
    public function myCases(Request $request)
    {
        $user = Auth::user();

        $query = CaseModel::with('genre')
            ->where('user_id', $user->id);

        // Поиск
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Сортировка
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


    // Редактирование
    public function edit($id)
    {
        $case = CaseModel::findOrFail($id);
        if ($case->user_id != Auth::id()) abort(403); // проверка авторства
        return view('cases.edit', compact('case'));
    }

    public function update(Request $request, $id)
    {
        $case = CaseModel::findOrFail($id);
        if ($case->user_id != Auth::id()) abort(403);

        $case->update($request->all());
        return redirect()->route('cases.my-cases');
    }

    // Удаление
    public function destroy($id)
    {
        $case = CaseModel::findOrFail($id);
        if ($case->user_id != Auth::id()) abort(403);

        $case->delete();
        return redirect()->route('cases.my-cases');
    }
}
