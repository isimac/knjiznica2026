<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //showLogin
    public function showLogin(): View
    {
        return view('auth.login');
    }

    //login
    public function login(Request $request): RedirectResponse
    {
        $podaci=$request->validate([
            'email'=>['required', 'email'],
            'password'=>['required', 'string']
        ]);

        if (Auth::attempt($podaci))
            {
                $request->session()->regenerate();
                return redirect()->intended(route('posudbe.index'));
            }
        return back()->withErrors([
            'email'=>'Neispravan email ili lozinka.'
        ])->onlyInput('email');
    }

    //logout
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $podaci=$request->validate([
            'name'=>['required', 'string', 'max:255'],
            'email'=>['required', 'email', 'max:255', 'unique:users,email'],
            'password'=>['required', 'string', 'confirmed']
        ]);

        User::create([
            'name'=>$podaci['name'],
            'email'=>$podaci['email'],
            'password'=>Hash::make($podaci['password'])
        ]);

        return redirect()->route('login')->with('uspjeh', 'Registracija uspješna!');
    }
}
