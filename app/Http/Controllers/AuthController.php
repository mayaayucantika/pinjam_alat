<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogger;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            ActivityLogger::logAction('login', 'User login: ' . Auth::user()->name);
            
            if (Auth::user()->isAdmin()) {
                return redirect()->route('dashboard');
            }
            
            if (Auth::user()->isPetugas()) {
                return redirect()->route('transactions.index');
            }
            
            return redirect()->route('tools.index');
        }

        return back()->withErrors([
            'email' => 'Email atau password tidak sesuai.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'peminjam',
            'status' => 'active',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        ActivityLogger::logAction('register', 'User register: ' . $user->name . ' (Peminjam)');

        return redirect()->route('tools.index')
            ->with('success', 'Registrasi berhasil! Selamat datang, Anda dapat meminjam alat.');
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            ActivityLogger::logAction('logout', 'User logout: ' . Auth::user()->name);
        }
        
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
