<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CaseModel;
use App\Models\Genre;

class CaseController extends Controller
{
    public function index(Request $request)
    {
        $query = CaseModel::with('genre')->where('status', '!=', 'pabeigta');

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
                // сортировка по жанру через relationship
                $query->join('genres', 'cases.genre_id', '=', 'genres.id')
                      ->orderBy('genres.name', 'asc')
                      ->select('cases.*');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
        }

        // Пагинация
        $cases = $query->paginate(9)->withQueryString();

        return view('cases.index', compact('cases'));
    }
}

