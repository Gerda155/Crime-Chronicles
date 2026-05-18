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

        $completedCount = PlayerAttempt::where('user_id', $user->id)
            ->where('is_correct', 1)
            ->distinct('case_id')
            ->count('case_id');

        $totalScore = DB::table('user_progress')
            ->where('user_id', $user->id)
            ->sum('score');

        $totalCases = PlayerAttempt::where('user_id', $user->id)
            ->distinct('case_id')
            ->count('case_id');

        $successfulCases = PlayerAttempt::where('user_id', $user->id)
            ->where('is_correct', 1)
            ->distinct('case_id')
            ->count('case_id');

        $successRate = $totalCases > 0
            ? round(($successfulCases / $totalCases) * 100, 1)
            : 0;

        $errorCount = PlayerAttempt::where('user_id', $user->id)
            ->where('is_correct', 0)
            ->count();

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

            'username' => [
                'required',
                'string',
                'max:255',
                'unique:users,username,' . $user->id
            ],

            'email' => 'required|email|max:255',

            'bio' => 'nullable|string|max:300',

            'password' => [
                'nullable',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],

            'avatar_cropped' => 'nullable|string',

        ], [

            'name.required' => 'Ievadiet pilno vārdu.',

            'username.required' => 'Ievadiet lietotājvārdu.',
            'username.unique' => 'Šis lietotājvārds jau tiek izmantots.',

            'email.required' => 'Ievadiet e-pastu.',
            'email.email' => 'Nepareizs e-pasta formāts.',

            'bio.max' => 'Apraksts nedrīkst pārsniegt 300 simbolus.',

            'password.confirmed' => 'Paroles nesakrīt.',
            'password.min' => 'Parolei jābūt vismaz 8 simboliem.',

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
