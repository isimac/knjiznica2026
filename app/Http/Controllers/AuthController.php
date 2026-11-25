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
    //showLogin->prikaz obrasca za prijavu
    public function showLogin(): View
    {
        return view('auth.login');
    }

    //login->provjera podataka i prijava
    public function login(Request $request): RedirectResponse
    {
        $podaci = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if(Auth::attempt($podaci))#Laravel pokušava pronaći usera koji ima taj email i lozinku
            {#ako su podaci pronađeni
                $request->session()->regenerate();#radi se regenerate da nemamo cijelo vrijeme isti session id
                return redirect()->intended(route('posudbe.index'));#intended->ciljana stranica, nakon logina da nas se baci na posudbe.index
            }
        return back()->withErrors([
            'email'=>'Neispravan email ili lozinka.'
        ])->onlyInput('email');#back->vrati na prethodnu stranicu, onlyInput-da se upamti email koji je korisnik napisao ali ne i lozinka (kao u bladeu old())
    }

    //logout->odjava
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();#izbrisali sve podatke iz sesije
        $request->session()->regenerateToken();#stvoren novi csrf token
        return redirect()->route('login');
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $podaci = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|confirmed'#confirmed znači da ćemo u formi imati unos lozinke i ponvoljene lozinka
        ]);

        User::create([
            'name' => $podaci['name'],
            'email' => $podaci['email'],
            'password' => Hash::make($podaci['password'])
        ]);

        return redirect()->route('login')->with('uspjeh', 'Registracija je uspješna');
    }
}
