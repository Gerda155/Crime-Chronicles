<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CaseModel;
use App\Models\Genre;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Achievement;
use App\Models\PlayerAttempt;


class CaseController extends Controller
{

    public function index(Request $request)
    {
        $query = CaseModel::with('genre')
            ->where('statuss', 'aktīvs');

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

    public function play(CaseModel $case)
    {
        $evidence = $case->evidence()->get();
        $suspects = $case->suspects()->get();

        return view('cases.play', compact('case', 'evidence', 'suspects'));
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

        // Проверяем, завершал ли пользователь это дело
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

        // Сохраняем попытку
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

        return $redirect;
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
