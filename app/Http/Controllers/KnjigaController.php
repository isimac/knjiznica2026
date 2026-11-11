<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use App\Models\Knjiga;


class KnjigaController extends Controller
{
    public function index():View 
    {
        $knjige=Knjiga::withCount('primjerak')->orderBy('naslov')->get();
        return view('knjige.index', ['knjige'=>$knjige]);
    }

    public function create():View
    {
        return view('knjige.create');
    }

    public function store(Request $request):RedirectResponse
    {
        $podaci=$request->validate([
            //validiran ono sto ce doci za ovaj model u $fillable 
            'naslov'=>['required', 'string', 'max:255'],
            'autor'=>['required', 'string', 'max:255'],
            'isbn'=>['nullable', 'digits:13', Rule::unique('knjiga', 'isbn')],
            'godinaIzdanja'=>['required', 'integer']
        ]);

        //moramo specificirati za ovo polje sto ako ne dode nista iako je nullable u bazi
        $podaci['isbn']=$podaci['isbn'] ?? null; 

        Knjiga::create($podaci);

        return redirect()->route('knjige.index')->with('uspjeh', 'Knjiga je uspjesno nadodana');
    }
}
