<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clan;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;

class ClanController extends Controller
{
    public function index(): View
    {
        $clanovi = Clan::orderBy('id')->get();
        return view('clanovi.index', ['clanovi' => $clanovi]);
    }

    public function create(): View
    {
        return view('clanovi.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $podaci = $request->validate([
            'ime'=> 'required|string|max:255',
            'prezime' => 'required|string|max:255',
            'brojMobitela' =>'required|string|max:255',
            'email' =>'nullable|email|max:255',
            'clanskiBroj' =>['required', 'string', 'max:255', Rule::unique('clan', 'clanskiBroj')]
        ]);
        $podaci['email'] = $podaci['email'] ?? null;

        Clan::create($podaci);

        return redirect()->route('clanovi.index')->with('uspjeh', 'Član je uspješno nadodan');
    }

    public function update(Request $request, Clan $clan): RedirectResponse
    {
        $podaci = $request->validate([
            'ime'=> 'required|string|max:255',
            'prezime' => 'required|string|max:255',
            'brojMobitela' =>'required|string|max:255',
            'email' =>'nullable|email|max:255',
            'clanskiBroj' =>['required', 'string', 'max:255', Rule::unique('clan', 'clanskiBroj')->ignore($clan->id)]
        ]);
        $podaci['email'] = $podaci['email'] ?? null;

        $clan->update($podaci);
        return redirect()->route('clanovi.index')->with('uspjeh','Podaci uspješno izmjenjeni!');
    }

    public function edit(Clan $clan):View
    {
        return view('clanovi.edit', ['clan'=>$clan]);
    }

     public function destroy(Clan $clan): RedirectResponse
    {
        $clan->delete();
        return redirect()->route('clanovi.index')->with('uspjeh','Član je uspješno obrisan');
    }
}
