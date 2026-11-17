<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clan;
use Illuminate\Validation\Rule;

class ClanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clanovi=Clan::orderBy('id')->get();

        return view('clanovi.index', ['clanovi'=>$clanovi]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('clanovi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $podaci=$request->validate([
            'ime'=> ['required'],
            'prezime'=> ['required'],
            'brojMobitela'=> ['required'],
            'email'=> ['required', Rule::unique('clan', 'clanskiBroj')],
            'clanskiBroj'=> ['required', Rule::unique('clan', 'clanskiBroj')],
        ]);

        Clan::create($podaci);

        return redirect()->route('clan.index')->with('uspjeh', 'Clan je uspjesno nadodan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Clan $clan)
    {
        return view('clanovi.show', ['clan'=>$clan]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Clan $clan)
    {
        return view('clanovi.edit', ['clan'=>$clan]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Clan $clan)
    {
        $podaci=$request->validate([
            'ime'=> ['required'],
            'prezime'=> ['required'],
            'brojMobitela'=> ['required'],
            'email'=> ['required', Rule::unique('clan', 'clanskiBroj')->ignore($clan->id)],
            'clanskiBroj'=> ['required', Rule::unique('clan', 'clanskiBroj')->ignore($clan->id)],
        ]);

        $clan->update($podaci);

        return redirect()->route('clan.index')->with('uspjeh', 'Clan je uspjesno azuriran');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Clan $clan)
    {
        $clan->delete();

        return redirect()->route('clan.index')->with('uspjeh', 'Clan je uspjesno izbrisan');



    }
}
