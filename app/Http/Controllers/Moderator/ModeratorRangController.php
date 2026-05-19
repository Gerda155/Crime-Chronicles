<?php

namespace App\Http\Controllers\Moderator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rang;
use App\Services\ActivityLogService;

class ModeratorRangController extends Controller
{
    public function rangsIndex(Request $request)
    {
        $query = Rang::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        switch ($request->get('sort')) {

            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;

            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;

            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;

            case 'low_score':
                $query->orderBy('min_score', 'asc');
                break;

            case 'high_score':
                $query->orderBy('min_score', 'desc');
                break;

            case 'active':
                $query->where('status', 'active')
                    ->orderBy('min_score', 'asc');
                break;

            case 'inactive':
                $query->where('status', 'inactive')
                    ->orderBy('min_score', 'asc');
                break;

            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
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

        if (Rang::hasOverlap($data['min_score'], $data['max_score'])) {
            return back()->withErrors(['min_score' => 'Šis punktu diapazons pārklājas ar esošu rangu!'])
                ->withInput();
        }

        ActivityLogService::log('create', 'rang', null, null, $data);

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

        if (Rang::hasOverlap($data['min_score'], $data['max_score'], $id)) {
            return back()->withErrors(['min_score' => 'Šis punktu diapazons pārklājas ar esošu rangu!'])
                ->withInput();
        }

        ActivityLogService::log('update', 'rang', $rang->id, $rang->toArray(), $data);
        
        $rang->update($data);

        return redirect()->route('moderator.rangs.index')
            ->with('success', 'Rangs atjaunināts!');
    }

    public function destroyRang(int $id)
    {
        $rang = Rang::findOrFail($id);
        ActivityLogService::log('delete', 'rang', $rang->id, $rang->toArray(), null);
        $rang->delete();

        return redirect()->route('moderator.rangs.index')
            ->with('success', 'Rangs dzēsts!');
    }

    public function deactivateRang(int $id)
    {
        $rang = Rang::findOrFail($id);
        ActivityLogService::log('update', 'rang', $rang->id, $rang->toArray(), ['status' => 'inactive']);   
        $rang->update(['status' => 'inactive']);

        return redirect()->route('moderator.rangs.index')
            ->with('success', 'Rangs deaktivēts!');
    }

    public function activateRang(int $id)
    {
        $rang = Rang::findOrFail($id);
        ActivityLogService::log('update', 'rang', $rang->id, $rang->toArray(), ['status' => 'active']);
        $rang->update(['status' => 'active']);

        return redirect()->route('moderator.rangs.index')
            ->with('success', 'Rangs aktivēts!');
    }

    public function restoreRang(int $id)
    {
        $rang = Rang::withTrashed()->findOrFail($id);
        ActivityLogService::log('update', 'rang', $rang->id, $rang->toArray(), ['status' => 'active']); 
        $rang->restore();

        return back()->with('success', 'Rangs atjaunots!');
    }
}
