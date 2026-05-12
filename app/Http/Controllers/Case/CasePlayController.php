<?php

namespace App\Http\Controllers\Case;

use Illuminate\Http\Request;
use App\Models\CaseModel;
use Illuminate\Support\Facades\Auth;
use App\Models\Achievement;
use App\Models\UserProgress;
use App\Http\Controllers\Controller;

class CasePlayController extends Controller
{
    public function tutorial()
    {
        $case = CaseModel::where('is_tutorial', true)->firstOrFail();

        $evidence = $case->evidence()->get(['id', 'description', 'type', 'image_path', 'key_object_area']);
        $suspects = $case->suspects()->latest()->get();
        $questions = $case->questions()->get();

        $progress = UserProgress::firstOrCreate([
            'user_id' => Auth::id(),
            'case_id' => $case->id
        ]);

        return view('cases.play', [
            'case' => $case,
            'evidence' => $evidence,
            'suspects' => $suspects,
            'questions' => $questions,
            'progress' => $progress,
            'progressPercent' => 0,
            'isTutorial' => true
        ]);
    }

    public function play(CaseModel $case)
    {
        $evidence = $case->evidence()->get(['id', 'description', 'type', 'image_path', 'key_object_area']);
        $suspects = $case->suspects()->get();
        $questions = $case->questions()->get();
        $totalEvidence = $case->evidence()->count();
        $totalQuestions = $case->questions()->count();

        $progress = UserProgress::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'case_id' => $case->id
            ]
        );

        $openedEvidence = $progress->opened_evidence ?? 0;
        $usedQuestions = $progress->questions_used ?? 0;

        $totalItems = $case->evidence()->count() + $case->questions()->count();

        $completedItems = $openedEvidence + $usedQuestions;

        $progressPercent = $totalItems > 0
            ? ($completedItems / $totalItems) * 100
            : 0;

        return view('cases.play', compact(
            'case',
            'evidence',
            'suspects',
            'questions',
            'progress',
            'progressPercent'
        ))->with('isTutorial', $case->is_tutorial);
    }

    public function submit(Request $request, CaseModel $case)
    {
        $opened = $request->input('opened_evidence_count', 0);

        if ($opened < 1) {
            return redirect()->back()
                ->with('status', 'Vispirms apskati pierādījumus!')
                ->with('can_submit', false);
        }

        $request->validate([
            'suspect_id' => 'required|exists:suspects,id',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $alreadyCompleted = $user->attempts()
            ->where('case_id', $case->id)
            ->where('is_correct', 1)
            ->exists();

        if ($alreadyCompleted) {
            return redirect()->route('cases.play', $case->id)
                ->with('status', 'Tu jau atradi īsto aizdomās turamo šajā lietā!')
                ->with('last_attempt_correct', true)
                ->with('can_submit', false)
                ->with('explanation', $case->solution_explanation);
        }

        $attemptCount = $user->attempts()
            ->where('case_id', $case->id)
            ->count();

        $isCorrect = $request->suspect_id == $case->answer_id;

        $user->attempts()->create([
            'case_id' => $case->id,
            'suspect_id' => $request->suspect_id,
            'is_correct' => $isCorrect,
        ]);

        $achievement = null;
        if ($isCorrect) {
            $achievement = $this->checkAchievements($user);
        }

        $status = $isCorrect
            ? "Pareizi! Tu atradi īsto aizdomās turamo pēc " . ($attemptCount + 1) . " mēģinājumiem."
            : "Nepareizi. Tas bija " . ($attemptCount + 1) . " mēģinājums. Mēģini vēlreiz.";

        $redirect = redirect()->route('cases.play', $case->id)
            ->with('status', $status)
            ->with('explanation', $case->solution_explanation)
            ->with('can_submit', true)
            ->with('last_attempt_correct', $isCorrect);

        if ($achievement) {
            $redirect->with('achievement', [
                'title' => $achievement->title,
                'description' => $achievement->description,
                'icon' => $achievement->icon
            ]);
        }

        UserProgress::updateOrCreate(
            [
                'user_id' => $user->id,
                'case_id' => $case->id
            ],
            [
                'score' => $request->score,
                'opened_evidence' => $opened,
                'completed' => $isCorrect
            ]
        );

        return $redirect;
    }

    public function updateProgress(Request $request)
    {
        UserProgress::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'case_id' => $request->case_id
            ],
            [
                'opened_evidence' => $request->opened_evidence,
                'questions_used' => $request->questions_used,
                'score' => $request->score
            ]
        );

        return response()->json(['status' => 'ok']);
    }

    public function checkAchievements($user)
    {
        $completed = $user->completedCases()->count();

        $achievements = Achievement::where('required_cases', '<=', $completed)->get();

        foreach ($achievements as $achievement) {
            if (!$user->achievements->contains($achievement->id)) {
                $user->achievements()->attach($achievement->id);
                return $achievement;
            }
        }

        return null;
    }
}
