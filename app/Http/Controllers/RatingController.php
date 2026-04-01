<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
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

        /** @var \App\Models\User $user */
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
}
