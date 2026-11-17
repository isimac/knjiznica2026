<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Knjiga;
use App\Models\Primjerak;
use Illuminate\Validation\Rule;

class PrimjerakController extends Controller
{
    public function create(Knjiga $knjiga) {
        return view('primjerci.create', compact('knjiga'));
    }

    public function store(Request $request) {
        $podaci=$request->validate([
            'inventarniBroj'=>['required', 'string', 'max:255', Rule::unique('primjerak', 'inventarniBroj')],
            'knjiga_id'=>['string']
        ]);

        Primjerak::create($podaci);

        return redirect()->route('knjige.index')->with('uspjeh', 'Primjerak je uspjesno nadodan');
    }

    public function edit(Primjerak $primjerak) {
        return view('primjerci/edit', compact('primjerak'));
    }

    public function update(Request $request, Primjerak $primjerak) {
        $podaci=$request->validate([
            'inventarniBroj'=>['required', 'string', 'max:255', Rule::unique('primjerak', 'inventarniBroj')]
            ]);
        
        $primjerak->update($podaci);
        return redirect()->route('knjige.index')->with('uspjeh', 'Primjerak je uspjesno azuriran');
    }

    public function destroy(Primjerak $primjerak) {
        $primjerak->delete();
        return redirect()->route('knjige.index')->with('uspjeh', 'Primjerak je uspjesno izbrisan');
    }
}
