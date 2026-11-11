<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Knjiga;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;

class KnjigaController extends Controller
{
    public function index(): View
    {
        //$knjige=Knjiga::orderBy('naslov')->get();
        //SELECT * FROM knjiga ORDER BY naslov ASC;

        $knjige=Knjiga::withCount('primjerak')->orderBy('naslov')->get();
        //stvorit će se dodatni atribut (ne u bazi) koji se zove primjerak_count

        return view('knjige.index', ['knjige'=>$knjige]);
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
}
