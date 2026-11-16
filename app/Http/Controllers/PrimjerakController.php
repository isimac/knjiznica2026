<?php

namespace App\Http\Controllers;

use App\Models\Knjiga;
use App\Models\Primjerak;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PrimjerakController extends Controller
{
    
    public function index(): View
    {
        $primjerci = Primjerak::with('knjiga')->orderBy('inventarniBroj')->get();

        return view('primjerci.index', compact('primjerci'));
    }

    
    public function create(Knjiga $knjiga): View
    {
        return view('primjerci.create', compact('knjiga'));
    }

    
    public function store(Request $request, Knjiga $knjiga): RedirectResponse
{
    $podaci = $request->validate([
        'inventarniBroj' => ['required','string','max:100', Rule::unique('primjerak', 'inventarniBroj')
        ]
    ]);

    $knjiga->primjerak()->create($podaci);

    return redirect()->route('knjige.show', $knjiga)->with('uspjeh', 'Primjerak je uspješno dodan.');
}


    public function show(Primjerak $primjerak): View
    {
         $primjerak->load('knjiga');

         return view('primjerci.show', compact('primjerak'));
    }

   
    public function edit(Primjerak $primjerak): View
    {
        $primjerak->load('knjiga');

        return view('primjerci.edit', compact('primjerak'));
    }

   
    public function update(Request $request, Primjerak $primjerak): RedirectResponse
    {
        $podaci = $request->validate([
            'inventarniBroj' => ['required','string','max:100', Rule::unique('primjerak', 'inventarniBroj')->ignore($primjerak->id),
            ]
        ]);

        $primjerak->update($podaci);

        return redirect()->route('primjerci.show', $primjerak)->with('uspjeh', 'Primjerak je uspješno ažuriran.');
    }

   
    public function destroy(Primjerak $primjerak): RedirectResponse
    {
       //ovo je priprema za kasnije; posudbe još nemamo;
        if ($primjerak->posudbe()->exists()) {
            return back()->with('greska','Primjerak nije moguće obrisati jer ima evidentirane posudbe.'
            );
        }

        $primjerak->delete();

        return redirect()
            ->route('primjerci.index')->with('uspjeh', 'Primjerak je uspješno obrisan.');
    }
}