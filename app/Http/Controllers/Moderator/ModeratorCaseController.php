<?php

namespace App\Http\Controllers\Moderator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CaseModel;
use App\Models\Genre;
use App\Models\Notification;
use App\Services\ActivityLogService;

class ModeratorCaseController extends Controller
{
    public function casesIndex(Request $request)
    {
        $query = CaseModel::whereIn('status', ['pending', 'approved', 'rejected', 'active', 'inactive']);

        if ($request->search) {
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

            case 'alphabet':
                $query->orderBy('title', 'asc');
                break;

            case 'alphabet_desc':
                $query->orderBy('title', 'desc');
                break;

            case 'tutorials':
                $query->where('is_tutorial', 1)
                    ->orderBy('created_at', 'desc');
                break;

            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
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

        ActivityLogService::log('create', 'case', null, null, $data);

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

        ActivityLogService::log('update', 'case', $case->id, $case->toArray(), $data);
        $case->update($data);

        return redirect()->route('moderator.cases.index')->with('success', 'Lieta atjaunināta');
    }

    public function deactivateCase(CaseModel $case)
    {
        ActivityLogService::log('update', 'case', $case->id, $case->toArray(), ['status' => 'inactive']);
        $case->update(['status' => 'inactive']);
        return redirect()->route('moderator.cases.index')->with('success', 'Lieta deaktivēta');
    }

    public function destroyCase(CaseModel $case)
    {
        ActivityLogService::log('delete', 'case', $case->id, $case->toArray(), null);
        $case->delete();
        return redirect()->route('moderator.cases.index')->with('success', 'Lieta dzēsta!');
    }

    public function restoreCase(int $id)
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
        ActivityLogService::log('update', 'case', $case->id, $case->toArray(), ['is_tutorial' => 1]);
        $case->save();

        return back()->with('success', 'Tutorial veiksmīgi atjaunināts!');
    }

    public function rejectCase(Request $request, CaseModel $case)
    {
        if ($case->status !== 'pending') {
            return back()->with('error', 'Nepareizs lietas statuss');
        }

        $request->validate([
            'reason' => 'required|string|max:500'
        ]);

        ActivityLogService::log('update', 'case', $case->id, $case->toArray(), ['status' => 'rejected']);
        $case->update([
            'status' => 'rejected'
        ]);

        Notification::create([
            'user_id' => $case->user_id,
            'title' => 'Lieta noraidīta',
            'type' => 'case_rejected',
            'message' => 'Tava lieta "' . $case->title . '" tika noraidīta. Iemesls: ' . $request->reason,
        ]);

        return back()->with('success', 'Lieta noraidīta');
    }

    public function approveCase(CaseModel $case)
    {
        if ($case->status !== 'pending') {
            return back()->with('error', 'Nepareizs lietas statuss');
        }

        ActivityLogService::log('update', 'case', $case->id, $case->toArray(), ['status' => 'approved']);
        $case->update([
            'status' => 'approved'
        ]);

        Notification::create([
            'user_id' => $case->user_id,
            'title' => 'Lieta apstiprināta',
            'type' => 'case_approved',
            'message' => 'Tava lieta "' . $case->title . '" tika apstiprināta!',
        ]);

        return back()->with('success', 'Lieta apstiprināta');
    }

    public function resetToPending(CaseModel $case)
    {
        ActivityLogService::log('update', 'case', $case->id, $case->toArray(), ['status' => 'pending']);
        $case->update(['status' => 'pending']);

        Notification::create([
            'user_id' => $case->user_id,
            'title' => 'Lieta atgriezta uz gaidīšanu',
            'type' => 'case_reset',
            'message' => 'Tava lieta "' . $case->title . '" tika atgriezta uz gaidīšanu.',
        ]);

        return back()->with('success', 'Lieta atgriezta uz gaidīšanu');
    }

    public function activateCase(CaseModel $case)
    {
        ActivityLogService::log('update','case',$case->id,$case->toArray(),['status' => 'active']);

        $case->update([
            'status' => 'active'
        ]);

        return redirect()
            ->route('moderator.cases.index')
            ->with('success', 'Lieta aktivēta');
    }
}
