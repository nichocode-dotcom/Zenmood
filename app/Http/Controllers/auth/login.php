<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class login extends Controller
{
    public function index()
    {
        // If user is already logged in, redirect to habit-log
        if (Auth::check()) {
            return redirect()->route('habit-log');
        }
        
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Check if username is email or actual username
        $field = filter_var($credentials['username'], FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        
        $user = \App\Models\User::where($field, $credentials['username'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user, $request->filled('remember'));
            $request->session()->regenerate();
            
            return redirect()->intended(route('habit-log'));
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }
}
