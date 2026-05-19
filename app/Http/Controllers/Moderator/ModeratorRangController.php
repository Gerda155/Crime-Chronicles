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

        $query->when($request->sort, function ($q, $sort) {

            match ($sort) {

                'oldest' => $q->orderBy('created_at', 'asc'),

                'name_asc' => $q->orderBy('name', 'asc'),
                'name_desc' => $q->orderBy('name', 'desc'),

                'low_score' => $q->orderBy('min_score', 'asc'),
                'high_score' => $q->orderBy('min_score', 'desc'),

                'active' => $q->where('status', 'active')->orderBy('min_score', 'asc'),
                'inactive' => $q->where('status', 'inactive')->orderBy('min_score', 'asc'),

                default => $q->orderBy('created_at', 'desc'),
            };
        });

        $rangs = $query->paginate(10)->withQueryString();

        return view('moderator.rangs.index', compact('rangs'));
    }

    public function storeRang(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:rangs,name',
            'min_score' => 'required|integer|min:0',
            'max_score' => 'nullable|integer',
        ]);

        if ($this->isInvalidRange($data['min_score'], $data['max_score'] ?? null)) {
            return back()
                ->withErrors([
                    'min_score' => 'Šis punktu diapazons pārklājas ar esošu rangu!'
                ])
                ->withInput();
        }

        ActivityLogService::log('create', 'rang', null, null, $data);

        Rang::create($data);

        return redirect()
            ->route('moderator.rangs.index')
            ->with('success', 'Rangs izveidots!');
    }

    public function updateRang(Request $request, int $id)
    {
        $rang = Rang::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255|unique:rangs,name,' . $id,
            'min_score' => 'required|integer|min:0',
            'max_score' => 'nullable|integer',
        ]);

        if ($this->isInvalidRange($data['min_score'], $data['max_score'] ?? null, $id)) {
            return back()
                ->withErrors([
                    'min_score' => 'Šis punktu diapazons pārklājas ar esošu rangu!'
                ])
                ->withInput();
        }

        ActivityLogService::log('update', 'rang', $rang->id, $rang->toArray(), $data);

        $rang->update($data);

        return redirect()
            ->route('moderator.rangs.index')
            ->with('success', 'Rangs atjaunināts!');
    }

    public function destroyRang(int $id)
    {
        $rang = Rang::findOrFail($id);

        ActivityLogService::log('delete', 'rang', $rang->id, $rang->toArray(), null);

        $rang->delete();

        return redirect()
            ->route('moderator.rangs.index')
            ->with('success', 'Rangs dzēsts!');
    }

    public function deactivateRang(int $id)
    {
        $this->setStatus($id, 'inactive', 'Rangs deaktivēts!');
    }

    public function activateRang(int $id)
    {
        $this->setStatus($id, 'active', 'Rangs aktivēts!');
    }

    public function restoreRang(int $id)
    {
        $rang = Rang::withTrashed()->findOrFail($id);

        $rang->restore();
        $rang->update(['status' => 'active']);

        ActivityLogService::log(
            'update',
            'rang',
            $rang->id,
            $rang->toArray(),
            ['status' => 'active']
        );

        return redirect()
            ->route('moderator.rangs.index')
            ->with('success', 'Rangs atjaunots!');
    }

    /* ---------------------------
        HELPERS (clean logic)
    ----------------------------*/

    private function setStatus(int $id, string $status, string $message)
    {
        $rang = Rang::findOrFail($id);

        ActivityLogService::log(
            'update',
            'rang',
            $rang->id,
            $rang->toArray(),
            ['status' => $status]
        );

        $rang->update(['status' => $status]);

        return redirect()
            ->route('moderator.rangs.index')
            ->with('success', $message);
    }

    private function isInvalidRange(int $min, ?int $max, ?int $ignoreId = null): bool
    {
        return Rang::hasOverlap($min, $max, $ignoreId);
    }
}