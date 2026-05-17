<?php

namespace App\Http\Controllers\Case;

use App\Http\Controllers\Controller;
use App\Models\CaseModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CaseSolutionController extends Controller
{
    public function index(CaseModel $case)
    {
        if ($case->user_id != Auth::id()) abort(403);

        $case->load([
            'suspect',
            'evidence',
            'questions'
        ]);

        return view('cases.wizard.solution', [
            'case' => $case
        ]);
    }

    public function save(Request $request, CaseModel $case)
    {
        if ($case->user_id != Auth::id()) abort(403);

        $request->validate([
            'solution_explanation' => 'required|string|min:10'
        ]);

        $case->update([
            'solution_explanation' => $request->solution_explanation
        ]);

        if ($case->status !== 'draft') {
            $case->update([
                'status' => 'pending'
            ]);
        }

        return back()->with(
            'status',
            'Risinājuma paskaidrojums saglabāts!'
        );
    }
}