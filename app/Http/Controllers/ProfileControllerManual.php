<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\User;
use App\Models\Achievement;

class ProfileControllerManual extends Controller
{
    // Редактирование профиля
    public function edit()
    {
        // Загружаем пользователя с его достижениями
        $user = User::with('achievements')->find(Auth::id());

        return view('profile.edit', compact('user'));
    }

    // Обновление профиля
    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|max:255',
            'password' => ['nullable', Password::min(8)->mixedCase()->numbers()->symbols()],
            'password_confirmation' => 'same:password',
            'bio' => 'nullable|string|max:300',
            'avatar' => 'nullable|image|max:5120',
        ]);

        $user->username = $validated['username'];
        $user->email = $validated['email'];
        $user->bio = $validated['bio'] ?? $user->bio;

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        if ($request->hasFile('avatar')) {
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profils veiksmīgi atjaunināts!');
    }

    // Удаление профиля
    public function destroy(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'password' => 'required|string',
        ]);

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Parole nav pareiza']);
        }

        // Удаляем достижения пользователя
        $user->achievements()->delete();

        // Удаляем пользователя
        $user->delete();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Profils dzēsts veiksmīgi!');
    }
}
