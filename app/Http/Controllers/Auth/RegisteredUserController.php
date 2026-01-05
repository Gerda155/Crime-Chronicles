<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Auth\RegisterRequest;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */

    public function store(RegisterRequest $request)
    {
        $data = $request->validated();

        if ($request->filled('avatar_cropped')) {
            $avatarData = $request->input('avatar_cropped');
            $avatarData = str_replace('data:image/jpeg;base64,', '', $avatarData);
            $avatarData = str_replace(' ', '+', $avatarData);
            $avatarName = uniqid() . '.jpg';
            Storage::disk('public')->put('avatars/' . $avatarName, base64_decode($avatarData));
            $data['avatar'] = 'avatars/' . $avatarName;
        }

        elseif ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $path;
        }

        $user = User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'bio' => $data['bio'] ?? null,
            'avatar' => $data['avatar'] ?? null,
        ]);

        Auth::login($user);

        return redirect()->intended('/');
    }
}
