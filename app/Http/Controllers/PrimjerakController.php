<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Primjerak;
use App\Models\Knjiga;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;

class PrimjerakController extends Controller
{
    public function create(Knjiga $knjiga): View
    {   
        return view('primjerci.create', ['knjiga' => $knjiga]);
    }

    public function store(Request $request, Knjiga $knjiga): RedirectResponse
    {
        $podaci = $request->validate([
            'inventarniBroj' => ['required', 'string','max:13', Rule::unique('primjerak', 'inventarniBroj')],
            'knjiga_id' => ['required']
        ]);

        Primjerak::create($podaci);

        return redirect()->route('knjige.show', $knjiga);
    }

    public function edit(Primjerak $primjerak): View
    {
        return view('primjerci.edit', ['primjerak' => $primjerak]);
    }

    public function update(Request $request, Primjerak $primjerak): RedirectResponse
    {
        $podaci = $request->validate([
            'inventarniBroj' => ['required', 'string','max:255', Rule::unique('primjerak', 'inventarniBroj')->ignore($primjerak->id)],
            'knjiga_id' => ['required']
        ]);

        $primjerak->update($podaci);

        return redirect()->route('knjige.show', $podaci['knjiga_id']);
        
    }

    public function destroy(Primjerak $primjerak): RedirectResponse
    {
        if($primjerak->posudba()->exists())
            {
                return redirect()->route('knjige.show', $primjerak->knjiga_id);
            }
        $primjerak->delete();
        return redirect()->route('knjige.show', $primjerak->knjiga_id)->with('obrisan','Primjerak je uspješno obrisan');
    }

}
