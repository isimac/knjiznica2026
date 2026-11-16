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

     $knjige=Knjiga::withCount('primjerak')->orderBy('naslov')->get();

    return view('knjige.index', ['knjige'=>$knjige]);
   }
   public function create(): View
   {
    return view('knjige.create');
   }
   
   public function store(Request $request): RedirectResponse
   {
    $podaci=$request->validate([
               'naslov'=>['required','string','max:255'],
               'autor'=>['required','string', 'max:255'],
               'isbn'=>['nullable','digits:13', Rule::unique('knjiga','isbn')],
               'godinaIzdanja'=>['required','integer','between:1900,'.date('Y')]

    ]);
    $podaci['isbn']=$podaci['isbn'] ?? null;
    Knjiga::create($podaci);
    return redirect()->route('knjige.index')->with('Uspjeh','Knjiga je uspješno nadodana');


}
}
