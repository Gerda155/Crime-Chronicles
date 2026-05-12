<?php

namespace App\Http\Controllers\Case;

use Illuminate\Http\Request;
use App\Models\CaseModel;
use App\Http\Controllers\Controller;

class CaseQuestionController extends Controller
{
    public function questions(CaseModel $case)
    {
        $questions = $case->questions()->with('suspect')->get();
        $suspects = $case->suspects;

        return view('cases.wizard.questions', compact('case', 'questions', 'suspects'));
    }

    public function storeQuestion(Request $request, CaseModel $case)
    {
        $request->validate([
            'suspect_id' => 'required|exists:suspects,id',
            'question_text' => 'required|string',
            'answer_text' => 'nullable|string',
        ]);

        $case->questions()->create([
            'suspect_id' => $request->suspect_id,
            'question_text' => $request->question_text,
            'answer_text' => $request->answer_text,
        ]);

        return redirect()->route('cases.questions', $case->id);
    }
}
