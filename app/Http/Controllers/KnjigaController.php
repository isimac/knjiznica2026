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

    public function edit(Knjiga $knjiga) {
        return view('knjige.edit', compact('knjiga')); 
    }

    public function update(Request $request, Knjiga $knjiga) {
        $podaci=$request->validate([
            //validiran ono sto ce doci za ovaj model u $fillable 
            'naslov'=>['required', 'string', 'max:255'],
            'autor'=>['required', 'string', 'max:255'],
            'isbn'=>['nullable', 'digits:13', Rule::unique('knjiga', 'isbn')->ignore($knjiga->id)],
            //ovaj ignore od gori ostaje jer postoji slucaj da editamo ostale podatke a isbn ostaje isti 
            //bez ovog ignore, Rule::unique bi blokira sve ovo
            //ovo prakticno znaci mora biti unique s obzirom na ostatak unosa u bazi, ali ovo sto sad editam pusti na miru 
            'godinaIzdanja'=>['required', 'integer']
        ]);

        $podaci['isbn']=$podaci['isbn'] ?? null;

        //u storeu san poziva po klasi Knjiga::update($podaci); jer nismo imali klasu u metodi
        //Tu imamo klasu Knjiga u metodi, pa samo pozovemo ovako
        $knjiga->update($podaci);
        //Oboje radi istu stvar, samo eto more se i ovako

        return redirect()->route('knjige.index')->with('uspjeh', 'Knjiga je uspjesno azurirana');
    }

    public function destroy(Knjiga $knjiga) {
        //Ukoliko knjiga ima primjerke, ne smimo je brisati 
        //problem integriteta, vanjskih kljuceva u bazi 
        //Tek ako ne postoji nijedan primjerak te knjige mozemo brisati knjigu

        //OVAKO SE RADI TA PROVJERA
        if ($knjiga->primjerak()->exists()) {
            return redirect()->route('knjige.index')->with('greska', 'Knjiga ne moze biti obrisana jer postoje evidentirani primjerci');
        }

        $knjiga->delete();

        return redirect()->route('knjige.index')->with('uspjeh', 'Knjiga je uspjesno izbrisana');
    }

    public function show(Knjiga $knjiga) {
        //Zasto ode anonimna funkcija?
        //Jer zelimo da na klik na naslov triggera rutu koja triggera ovu metodu
        //Anonimna funkcija u njoj poziva model sa sljedecom funkcijom:

        //LOAD - ucitaj povezane "primjerke" s vec dohvacenim modelom knjiga
        //Pod povezane misli se naravno na povezano relacijama iz modela
        $knjiga->load(['primjerak'=> function ($upit) {
            $upit->orderBy('inventarniBroj');
        }]);

        return view('knjige.show', ['knjiga'=>$knjiga]);
    }
}
