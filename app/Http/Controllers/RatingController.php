<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use App\Models\User;
use App\Models\CaseModel;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'case_id' => 'required|exists:cases,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string'
        ]);

        /** @var User $user */
        $user = Auth::user();

        $completed = $user->attempts()
            ->where('case_id', $request->case_id)
            ->where('is_correct', 1)
            ->exists();

        if (!$completed) {
            return back()->with('error', 'Tu neesi pabeidzis šo lietu');
        }

        Rating::updateOrCreate(
            [
                'user_id' => $user->id,
                'case_id' => $request->case_id
            ],
            [
                'rating' => $request->rating,
                'comment' => $request->comment
            ]
        );

        $case = CaseModel::find($request->case_id);
        $case->rating = Rating::where('case_id', $case->id)->avg('rating');
        $case->save();

        return back()->with('success', 'Paldies par vērtējumu!');
    }

    public function index()
    {
        $ratings = Rating::with('case')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('ratings.index', compact('ratings'));
    }

    public function edit(int $id)
    {
        $rating = Rating::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        return view('ratings.edit', compact('rating'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string'
        ]);

        $rating = Rating::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $rating->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('ratings.index')->with('status', 'Atjaunots!');
    }

    public function destroy(int $id)
    {
        $rating = Rating::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $rating->delete();

        return back()->with('status', 'Izdzēsts!');
    }
}