<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use App\Services\ActivityLogService;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        ActivityLogService::log('logout', 'user', Auth::id(), null, ['message' => 'User logged out']);

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function store(LoginRequest $request)
    {
        $login = $request->input('login');
        $password = $request->input('password');

        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $user = User::where($fieldType, $login)->first();

        if ($user && $user->status !== 'active') {
            ActivityLogService::log('failed_login','user',null,null,['login' => $login]);

            throw ValidationException::withMessages([
                'login' => 'Tavs konts ir deaktivēts. Sazinieties ar mums, lai to aktivizētu.',
            ]);
        }

        if (Auth::attempt([
            $fieldType => $login,
            'password' => $password,
            'status' => 'active',
        ], $request->filled('remember'))) {

            $request->session()->regenerate();

            ActivityLogService::log('login','user',Auth::id(),null,['message' => 'User logged in']);

            return redirect()->intended('/');
        }

        throw ValidationException::withMessages([
            'login' => 'Nepareizs lietotājvārds / e-pasts vai parole.',
        ]);
    }
}
