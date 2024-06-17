<?php

namespace App\Http\Controllers\UI;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UI\RegisterWebRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AuthWebController extends Controller
{
    public function register(RegisterWebRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $user->markEmailAsVerified();
        $user->givePermissionTo('dashboard');
        Auth::login($user);

        return redirect()->route('login')->with('success', 'Registration successful. Please log in.');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if (!$user->canAccessDashboard()) {
                Auth::logout();
                return redirect()->route('login')->withErrors(['message' => 'You do not have access to the dashboard.']);
            }

            return redirect()->intended('dashboard');
        }

        return redirect()->route('login')->withErrors(['message' => 'The provided credentials do not match our records.']);
    }


    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
