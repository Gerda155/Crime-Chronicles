<?php

namespace App\Http\Controllers\Case;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\CaseModel;
use App\Models\UserProgress;
use App\Models\Achievement;

class CasePlayController extends Controller
{
    /**
     * Atver lietas izmeklēšanas lapu
     */
    public function play(CaseModel $case)
    {
        // Iegūst pierādījumus konkrētajai lietai
        $evidence = $case->evidence()->get([
            'id',
            'description',
            'type',
            'image_path',
            'key_object_area'
        ]);

        // Iegūst aizdomās turamos
        $suspects = $case->suspects()->get();

        // Iegūst jautājumus nopratināšanai
        $questions = $case->questions()->get();

        // Izveido lietotāja progresu, ja tas vēl nepastāv
        $progress = UserProgress::firstOrCreate([
            'user_id' => Auth::id(),
            'case_id' => $case->id
        ]);

        // Iegūst atvērto pierādījumu un izmantoto jautājumu skaitu
        $openedEvidence = $progress->opened_evidence ?? 0;
        $usedQuestions = $progress->questions_used ?? 0;

        // Aprēķina kopējo izmeklēšanas elementu skaitu
        $totalItems = $case->evidence()->count()
            + $case->questions()->count();

        // Aprēķina pabeigto darbību skaitu
        $completedItems = $openedEvidence + $usedQuestions;

        // Aprēķina izmeklēšanas progresu procentos
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

    /**
     * Apstrādā lietotāja izvēlēto aizdomās turamo
     */
    public function submit(Request $request, CaseModel $case)
    {
        // Iegūst apskatīto pierādījumu skaitu
        $openedEvidence = $request->input('opened_evidence_count', 0);

        // Pārbauda, vai lietotājs ir apskatījis vismaz vienu pierādījumu
        if ($openedEvidence < 1) {
            return redirect()->back()
                ->with('status', 'Vispirms apskati pierādījumus!')
                ->with('can_submit', false);
        }

        // Validē ievadītos datus
        $request->validate([
            'suspect_id' => 'required|exists:suspects,id',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Pārbauda, vai lieta jau ir veiksmīgi pabeigta
        $alreadyCompleted = $user->attempts()
            ->where('case_id', $case->id)
            ->where('is_correct', true)
            ->exists();

        if ($alreadyCompleted) {
            return redirect()
                ->route('cases.play', $case->id)
                ->with('status', 'Tu jau atradi īsto aizdomās turamo šajā lietā!')
                ->with('last_attempt_correct', true)
                ->with('can_submit', false)
                ->with('explanation', $case->solution_explanation);
        }

        // Iegūst iepriekšējo mēģinājumu skaitu
        $attemptCount = $user->attempts()
            ->where('case_id', $case->id)
            ->count();

        // Pārbauda, vai izvēlētā atbilde ir pareiza
        $isCorrect = $request->suspect_id == $case->answer_id;

        // Saglabā lietotāja mēģinājumu datubāzē
        $user->attempts()->create([
            'case_id' => $case->id,
            'suspect_id' => $request->suspect_id,
            'is_correct' => $isCorrect,
        ]);

        // Sasnieguma mainīgais
        $achievement = null;

        // Pārbauda sasniegumus tikai pareizas atbildes gadījumā
        if ($isCorrect) {
            $achievement = $this->checkAchievements($user);
        }

        // Izveido statusa ziņojumu
        $status = $isCorrect
            ? 'Pareizi! Tu atradi īsto aizdomās turamo pēc '
            . ($attemptCount + 1)
            . ' mēģinājumiem.'
            : 'Nepareizi. Tas bija '
            . ($attemptCount + 1)
            . '. mēģinājums. Mēģini vēlreiz.';

        // Saglabā vai atjaunina lietotāja progresu
        UserProgress::updateOrCreate(
            [
                'user_id' => $user->id,
                'case_id' => $case->id
            ],
            [
                'score' => $request->score,
                'opened_evidence' => $openedEvidence,
                'completed' => $isCorrect
            ]
        );

        // Izveido pāradresācijas atbildi
        $redirect = redirect()
            ->route('cases.play', $case->id)
            ->with('status', $status)
            ->with('explanation', $case->solution_explanation)
            ->with('can_submit', true)
            ->with('last_attempt_correct', $isCorrect);

        // Pievieno sasnieguma informāciju sesijai
        if ($achievement) {
            $redirect->with('achievement', [
                'title' => $achievement->title,
                'description' => $achievement->description,
                'icon' => $achievement->icon
            ]);
        }

        return $redirect;
    }

    /**
     * Atjaunina lietotāja progresu izmeklēšanas laikā
     */
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

        // Atgriež JSON atbildi
        return response()->json([
            'status' => 'ok'
        ]);
    }

    /**
     * Pārbauda un piešķir lietotāja sasniegumus
     */
    public function checkAchievements($user)
    {
        // Iegūst pabeigto lietu skaitu
        $completedCases = $user->completedCases()->count();

        // Iegūst pieejamos sasniegumus
        $achievements = Achievement::where(
            'required_cases',
            '<=',
            $completedCases
        )->get();

        // Pārbauda, vai sasniegums jau nav piešķirts
        foreach ($achievements as $achievement) {
            if (!$user->achievements->contains($achievement->id)) {

                // Piešķir sasniegumu lietotājam
                $user->achievements()->attach($achievement->id);

                return $achievement;
            }
        }

        return null;
    }

    public function tutorial()
    {
        $tutorialCase = CaseModel::where('is_tutorial', true)->first();

        if (!$tutorialCase) {
            abort(404, 'Tutorial case not found.');
        }

        return redirect()->route('cases.play', $tutorialCase->id);
    }
}
