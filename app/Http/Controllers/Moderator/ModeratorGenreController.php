<?php

namespace App\Http\Controllers\Moderator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Genre;
use App\Services\ActivityLogService;

class ModeratorGenreController extends Controller
{
    public function genresIndex(Request $request)
    {
        $query = Genre::query();

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        $sort = $request->input('sort', 'newest');

        switch ($sort) {

            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;

            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;

            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;

            case 'active':
                $query->where('status', 'active')
                    ->orderBy('name', 'asc');
                break;

            case 'inactive':
                $query->where('status', 'inactive')
                    ->orderBy('name', 'asc');
                break;

            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
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
        
        ActivityLogService::log('create', 'genre', null, null, $data);

        Genre::create($data);

        return redirect()->route('moderator.genres.index')->with('success', 'Žanrs izveidots!');
    }

    public function editGenre(Genre $genre)
    {
        $query = Genre::query();
        $genres = $query->paginate(10)->withQueryString();

        ActivityLogService::log('read', 'genre', $genre->id, $genre->toArray(), null);

        $editGenre = $genre;

        return view('moderator.genres.index', compact('genres', 'editGenre'));
    }

    public function updateGenre(Request $request, Genre $genre)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:genres,name,' . $genre->id,
        ]);

        ActivityLogService::log('update', 'genre', $genre->id, $genre->toArray(), $data);

        $genre->update($data);

        return redirect()->route('moderator.genres.index')->with('success', 'Žanrs atjaunināts!');
    }

    public function deactivateGenre(Genre $genre)
    {
        ActivityLogService::log('update', 'genre', $genre->id, $genre->toArray(), ['status' => 'inactive']);
        $genre->update(['status' => 'inactive']);
        return redirect()->route('moderator.genres.index')->with('success', 'Žanrs deaktivēts!');
    }

    public function activateGenre(Genre $genre)
    {
        ActivityLogService::log('update', 'genre', $genre->id, $genre->toArray(), ['status' => 'active']);
        $genre->update(['status' => 'active']);
        return redirect()->route('moderator.genres.index')->with('success', 'Žanrs aktivēts!');
    }

    public function destroyGenre(Genre $genre)
    {
        ActivityLogService::log('delete', 'genre', $genre->id, $genre->toArray(), null);
        $genre->delete();
        return redirect()->route('moderator.genres.index')->with('success', 'Žanrs dzēsts!');
    }
}
