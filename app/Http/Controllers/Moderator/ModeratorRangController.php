<?php

namespace App\Http\Controllers\Moderator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rang;

class ModeratorRangController extends Controller
{
    public function rangsIndex(Request $request)
    {
        $query = Rang::query();

        // SEARCH
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // SORT
        switch ($request->get('sort')) {
            case 'oldest':
                $query->orderBy('id', 'asc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'points':
                $query->orderBy('min_score', 'desc');
                break;
            default:
                $query->orderBy('id', 'desc');
                break;
        }

        $rangs = $query->paginate(10)->withQueryString();

        return view('moderator.rangs.index', compact('rangs'));
    }

    public function storeRang(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:rangs,name',
            'min_score' => 'required|integer|min:0',
            'max_score' => 'nullable|integer|gt:min_score',
        ]);

        // Проверка на пересечение
        if (Rang::hasOverlap($data['min_score'], $data['max_score'])) {
            return back()->withErrors(['min_score' => 'Šis punktu diapazons pārklājas ar esošu rangu!'])
                ->withInput();
        }

        Rang::create($data);

        return redirect()->route('moderator.rangs.index')
            ->with('success', 'Rangs izveidots!');
    }

    public function updateRang(Request $request, int $id)
    {
        $rang = Rang::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255|unique:rangs,name,' . $id,
            'min_score' => 'required|integer|min:0',
            'max_score' => 'nullable|integer|gt:min_score',
        ]);

        // Проверка на пересечение, исключая текущий ранг
        if (Rang::hasOverlap($data['min_score'], $data['max_score'], $id)) {
            return back()->withErrors(['min_score' => 'Šis punktu diapazons pārklājas ar esošu rangu!'])
                ->withInput();
        }

        $rang->update($data);

        return redirect()->route('moderator.rangs.index')
            ->with('success', 'Rangs atjaunināts!');
    }

    public function destroyRang(int $id)
    {
        $rang = Rang::findOrFail($id);
        $rang->delete();

        return redirect()->route('moderator.rangs.index')
            ->with('success', 'Rangs dzēsts!');
    }

    public function deactivateRang(int $id)
    {
        $rang = Rang::findOrFail($id);
        $rang->update(['status' => 'inactive']);

        return redirect()->route('moderator.rangs.index')
            ->with('success', 'Rangs deaktivēts!');
    }

    public function activateRang(int $id)
    {
        $rang = Rang::findOrFail($id);
        $rang->update(['status' => 'active']);

        return redirect()->route('moderator.rangs.index')
            ->with('success', 'Rangs aktivēts!');
    }

    public function restoreRang(int $id)
    {
        $rang = Rang::withTrashed()->findOrFail($id);
        $rang->restore();

        return back()->with('success', 'Rangs atjaunots!');
    }
}
