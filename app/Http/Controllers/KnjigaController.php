<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Knjiga;          //moramo staviti i controller u kojem jesmo (ne mora se staviti) - to je da knjiga dolazi iz models, da se ne mora pisati uvijek
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;




class KnjigaController extends Controller
{
    public function index(): View       //ako se makne view sve radi jednako, a view je samo radi čitljivosti (nije obavezan, samo je dobra praksa)    
    {
        $knjige=Knjiga::orderBy('naslov')->get();       //sortiramo prema naslovu   get izvrši, ako stavimo desc, onda ide descending, ako ga nema onda ide uzlazno $knjige=Knjiga::orderBy('naslov', 'desc')->get();
        //SELECT * FROM knjiga ORDER BY naslov ASC;

        $knjige=Knjiga::withCount('primjerak')->orderBy('naslov')->get();

        return view('knjige.index', ['knjige'=>$knjige]);           //knjige.index je naziv predloška koji će kasnije doći
        //resources/views/knjige/index.blade.php
    }

    public function create(): View
    {
        return view('knjige.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $podaci=$request->validate([
            'naslov'=>['required', 'string', 'max:255'],
            'autor'=>['required', 'string', 'max:255'],
            'isbn'=>['nullable', 'digits:13', Rule::unique('knjiga', 'isbn')],
            'godinaIzdanja'=>['required', 'integer', 'between:1900,'.date('Y')]
        ]);
        $podaci['isbn']=$podaci['isbn'] ?? null;
        Knjiga::create($podaci);

        return redirect()->route('knjige.index')->with('uspjeh', 'Knjiga je uspješno nadodana');
    }

    public function update(Request $request, Knjiga $knjiga): RedirectResponse
    {
        $podaci=$request->validate([
            'naslov'=>['required', 'string', 'max:255'],
            'autor'=>['required', 'string', 'max:255'],
            'isbn'=>['nullable', 'digits:13', Rule::unique('knjiga', 'isbn')->ignore($knjiga->id)],
            'godinaIzdanja'=>['required', 'integer', 'between:1900, '.date('Y')]
          
        ]);
        $podaci['isbn']=$podaci['isbn'] ?? null;
        $knjiga->update($podaci);

        return redirect()->route('knjige.index')->with('uspjeh', 'Podaci o knjizi uspješno izmjenjeni');
    }

    public function destroy(Knjiga $knjiga): RedirectResponse
    {
        //ukoliko knjiga ima primjerke, tada ne smijemo brisati
        if ($knjiga->primjerak()->exists())
            {
                return redirect()->route('knjige.index')->with ('greška', 'Knjiga ne može biti obrisana jer ima evidentirane primjerke');
            }
        $knjiga->delete();
        return redirect()->route('knjige.index')->with ('uspjeh', 'Knjiga je uspješno izbrisana');

    }

    public function edit(Knjiga $knjiga)
    {
        return view('knjige.edit', compact('knjiga'));
        //return view('knjige.edit', ['knjiga' => $knjiga]);
    }

    public function show(Knjiga $knjiga): View
    {
        $knjiga->load(['primjerci'=>function ($upit)
        {
            //$knjiga->load('primjerak');
            $upit->orderBy('inventarniBroj');
        }]);

        return view('knjige.show',['knjiga'=>$knjiga]);
    }

}
