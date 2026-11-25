<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use App\Models\User;

class AuthController extends Controller
{
    //showLogin
    public function showLogin():View
    {
        return view ('/auth/login');
    }

    //login
    public function login(Request $request):RedirectResponse
    {
        //Validacija klasicna
        $podaci=$request->validate([
            'email'=>['required', 'email'],
            'password'=>['required', 'string'],
        ]);

        //klasa Auth proba spajanje sa validiranim podacima od gori
        if (Auth::attempt($podaci)) 
            {
                //ako prode, regenerira sesiju i salje na posudbe.index
                $request->session()->regenerate();
                return redirect()->intended(route('posudbe.index'));
            } else {
                //ako ne prode, vrati ovo
                return back()->withErrors([
                    'email'=>'Neispravan email ili lozinka'
                ])->onlyInput('email'); //ovo je ono da ako fula, doceka ga opet mail koji je upisa, ali samo mail a nikako i lozinka
            }
    }

    //logout
    public function logout(Request $request) {  //neki button ce odlogirati, dakle forma, dakle post, dakle $request
        Auth::logout;   //ovo je cili login
        $request->session()->invalidate();      //jos pobrisi za svaki slucaj sve zivo 
        $request->session()->regenerateToken();
        return redirect()->route('login');      //redirectaj na login, to je neki standard, al moze i bilo di drugo naravno
    }

    public function showRegister() {
        return view('/auth/register');
    }

    public function register(Request $request) {
        $podaci=$request->validate([
            'name'=>['string', 'required', 'max:255'],
            'email'=>['email', 'required', 'max:255', 'unique:users,email'],
            'password'=>['required', 'string', 'confirmed'],
        ]);

        User::create([
            'name'=>$podaci['name'],
            'email'=>$podaci['email'],
            'password'=>Hash::make($podaci['password']) //OBAVEZNO
        ]);

        return redirect()->route('login')->with('uspjeh', 'registracija je uspjesna');
    }
}
