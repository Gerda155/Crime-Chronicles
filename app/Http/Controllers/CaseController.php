<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CaseModel;
use App\Models\Genre;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Achievement;
use App\Models\PlayerAttempt;
use App\Models\UserProgress;


class CaseController extends Controller
{

    public function index(Request $request)
    {
        $query = CaseModel::with('genre')
            ->where('status', 'active');

        if ($request->filled('search')) {
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
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            case 'genre':
                $query->join('genres', 'cases.genre_id', '=', 'genres.id')
                    ->orderBy('genres.name', 'asc')
                    ->select('cases.*');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
        }

        $cases = $query->paginate(9)->withQueryString();
        return view('cases.index', compact('cases'));
    }

    public function myCases(Request $request)
    {
        $user = Auth::user();
        $user = $user instanceof User ? $user : null;

        $query = CaseModel::with('genre')
            ->where('user_id', $user->id);

        if ($request->filled('search')) {
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
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            case 'genre':
                $query->join('genres', 'cases.genre_id', '=', 'genres.id')
                    ->orderBy('genres.name', 'asc')
                    ->select('cases.*');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $cases = $query->paginate(10)->withQueryString();

        return view('cases.my-cases', compact('cases'));
    }

    public function edit($id)
    {
        $case = CaseModel::findOrFail($id);
        if ($case->user_id != Auth::id()) abort(403);
        return view('cases.edit', compact('case'));
    }

    public function update(Request $request, $id)
    {
        $case = CaseModel::findOrFail($id);
        if ($case->user_id != Auth::id()) abort(403);

        $case->update($request->all());
        return redirect()->route('cases.my-cases');
    }

    public function destroy($id)
    {
        $case = CaseModel::findOrFail($id);
        if ($case->user_id != Auth::id()) abort(403);

        $case->delete();
        return redirect()->route('cases.my-cases');
    }

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

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'genre_id' => 'required|exists:genres,id',
        ]);

        $case = CaseModel::create([
            'title' => $request->title,
            'description' => $request->description,
            'genre_id' => $request->genre_id,
            'user_id' => Auth::id(),
            'status' => 'draft',
            'rating' => 0,
            'is_tutorial' => false,
        ]);

        return redirect()->route('cases.suspects', $case->id);
    }

    public function create()
    {
        $genres = Genre::all();

        return view('cases.wizard.create', compact('genres'));
    }

    public function suspects(CaseModel $case)
    {
        $suspects = $case->suspects()->get();

        return view('cases.wizard.suspects', compact('case', 'suspects'));
    }

    public function storeSuspect(Request $request, CaseModel $case)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {

            $path = $request->file('image')->store('cases/suspects', 'public');

            $imagePath = 'storage/' . $path;
        }

        $case->suspects()->create([
            'name' => $request->name,
            'description' => $request->description,
            'image_path' => $imagePath,
        ]);

        return redirect()
            ->route('cases.suspects', $case->id)
            ->with('status', 'Aizdomās turamais pievienots!');
    }

    public function setAnswer(Request $request, CaseModel $case)
    {
        $request->validate([
            'answer_id' => 'required|exists:suspects,id',
        ]);

        $case->update([
            'answer_id' => $request->answer_id,
        ]);

        return redirect()->route('cases.evidence', $case->id);
    }

    public function evidence(CaseModel $case)
    {
        $evidence = $case->evidence()->get();

        return view('cases.wizard.evidence', compact('case', 'evidence'));
    }

    public function storeEvidence(Request $request, CaseModel $case)
    {
        $request->validate([
            'description' => 'required|string',
            'type' => 'nullable|string',
            'file' => 'nullable|file|max:10240|mimes:jpg,jpeg,png,pdf,doc,docx',
            'key_object_area' => 'nullable|json',
        ]);

        $filePath = null;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('cases/evidence', 'public');
            $filePath = 'storage/' . $path;
        }

        $case->evidence()->create([
            'description' => $request->description,
            'type' => $request->type ?? 'image',
            'image_path' => $filePath,
            'key_object_area' => $request->key_object_area,
        ]);

        return redirect()->route('cases.evidence', $case->id);
    }

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

    public function submitFinal(CaseModel $case)
    {
        if ($case->status !== 'draft') {
            return redirect()->route('cases.my-cases')
                ->with('status', 'Šī lieta jau ir iesniegta.');
        }

        $case->update([
            'status' => 'pending'
        ]);

        return redirect()->route('cases.my-cases')
            ->with('status', 'Lieta nosūtīta uz moderāciju. Drīz tā parādīsies vietnē!');
    }
}
