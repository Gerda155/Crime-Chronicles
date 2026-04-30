<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\PlayerAttempt;
use App\Models\CaseModel;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        /* 🎯 завершённые дела (уникальные успешные кейсы) */
        $completedCount = PlayerAttempt::where('user_id', $user->id)
            ->where('is_correct', 1)
            ->distinct('case_id')
            ->count('case_id');

        /* ⭐ очки */
        $totalScore = DB::table('user_progress')
            ->where('user_id', $user->id)
            ->sum('score');

        /* 📊 всего кейсов, где участвовал */
        $totalCases = PlayerAttempt::where('user_id', $user->id)
            ->distinct('case_id')
            ->count('case_id');

        /* 🧠 успешные кейсы */
        $successfulCases = PlayerAttempt::where('user_id', $user->id)
            ->where('is_correct', 1)
            ->distinct('case_id')
            ->count('case_id');

        /* 📈 процент успеха */
        $successRate = $totalCases > 0
            ? round(($successfulCases / $totalCases) * 100, 1)
            : 0;

        /* ❌ ошибки */
        $errorCount = PlayerAttempt::where('user_id', $user->id)
            ->where('is_correct', 0)
            ->count();

        /* 🧩 созданные кейсы */
        $createdCases = CaseModel::where('user_id', $user->id)->count();

        return view('profile.edit', compact(
            'user',
            'completedCount',
            'totalScore',
            'successRate',
            'errorCount',
            'createdCases'
        ));
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();


        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|max:255',
            'password' => ['nullable', Password::min(8)->mixedCase()->numbers()->symbols()],
            'password_confirmation' => 'same:password',
            'bio' => 'nullable|string|max:300',
            'avatar' => 'nullable|image|max:5120',
        ]);

        $user->name = $validated['name'];
        $user->username = $validated['username'];
        $user->email = $validated['email'];
        $user->bio = $validated['bio'] ?? $user->bio;

        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        if ($request->filled('avatar_cropped')) {
            $imageData = str_replace(
                'data:image/jpeg;base64,',
                '',
                $request->input('avatar_cropped')
            );
            $imageData = str_replace(' ', '+', $imageData);

            $imageName = 'avatar_' . $user->id . '_' . time() . '.jpg';

            Storage::disk('public')->put(
                'avatars/' . $imageName,
                base64_decode($imageData)
            );

            $user->avatar = 'avatars/' . $imageName;
        }

        $user->save();

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Profils veiksmīgi atjaunināts!');
    }

    public function destroy(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();


        $request->validate([
            'password' => 'required|string',
        ]);

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'Parole nav pareiza'
            ]);
        }

        $user->achievements()->detach();
        $user->delete();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')
            ->with('success', 'Profils dzēsts veiksmīgi!');
    }
}
