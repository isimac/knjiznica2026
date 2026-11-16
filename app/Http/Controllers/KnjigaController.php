<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Knjiga; # s kojim modelom radimo, "uvezemo" ga
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;

class KnjigaController extends Controller
{
    public function index(): View
    {
        #$knjige = Knjiga::orderBy('naslov')->get();#da želimo descending napisali bi orderBy('naslov', 'desc')
        #da nismo stavili use App\Models\Knjiga morali bi raditi $knjige = App\Models\Knjiga::orderBy....
        $knjige = Knjiga::withCount('primjerak')->orderBy('naslov')->get();#izvlačimo i broj primjeraka; withCount stvara dodatni atribut (ne u bazi već lokalno) koji se zove primjerak_count
        return view('knjige.index', ['knjige' => $knjige]);#resources/views/knjige/index.blade.php; laravel koristi točkastu notaciju
    }

    public function create(): View
    {
        return view('knjige.create');
    }

    public function store(Request $request): RedirectResponse# metoda mora imati povrat redirekcije
    {
        $podaci = $request->validate([
            'naslov' => ['required', 'string', 'max:255'],
            'autor' => ['required', 'string', 'max:255'],
            'isbn' => ['nullable', 'digits:13', Rule::unique('knjiga', 'isbn')],#mora biti 13 znamenki, imamo i pravilo, provjerava da li je isbn već postojeći u tablici koja se zove knjiga, polje isbn, ako je postojeći javiti će grešku
            'godinaIzdanja' => ['required', 'integer', 'between:1900,'.date('Y')]#broj koji prihvaćamo mora biti između 1900 i današnje godine, bilo bi 'between:1900,2026'
        ]);

        $podaci['isbn'] = $podaci['isbn'] ?? null;#zato što je nullable moramo naglasiti šta će biti ako je isbn prazan

        Knjiga::create($podaci);

        return redirect()->route('knjige.index')->with('uspjeh', 'Knjiga je uspješno nadodana');#redirectaj me na rutu i s porukom 'knjiga je uspješno nadodana'
    }

    public function update(Request $request, Knjiga $knjiga): RedirectResponse
    {
        $podaci = $request->validate([
            'naslov' => ['required', 'string', 'max:255'],
            'autor' => ['required', 'string', 'max:255'],
            'isbn' => ['nullable', 'digits:13', Rule::unique('knjiga', 'isbn')->ignore($knjiga->id)],#ako se dogodit da ne želimo izmijeniti isbn, javljati će da taj isbn već postoji pa nećemo moći spremiti, zato stavljamo taj ignore->provjeri jedinstvenost isbn-a ali zanemari taj koji sada uređujemo
            'godinaIzdanja' => ['required', 'integer', 'between:1900,'.date('Y')]
        ]);

        $podaci['isbn'] = $podaci['isbn'] ?? null;
        $knjiga->update($podaci);#da nismo kao argument stavili $knjiga, tu bismo sada morali raditi Knjiga::update($podaci)

        return redirect()->route('knjige.index')->with('uspjeh','Podaci o knjizi uspješno izmjenjeni!');
    }

    public function destroy(Knjiga $knjiga): RedirectResponse
    {
        #ukoliko knjiga ima primjerke, tada ne smijemo brisati
        if($knjiga->primjerak()->exists())#ako postoji primjerak koji je u vezi s knjigom
            {
                return redirect()->route('knjige.index')->with('greska', 'Knjiga ne može biti obrisana jer ima evidentirane primjerke!');
            }
        $knjiga->delete();
        return redirect()->route('knjige.index')->with('uspjeh','Knjiga je uspješno obrisana');
    }

    public function edit(Knjiga $knjiga): View
    {
        return view('knjige.edit', compact('knjiga'));#compact stvara asocijativni niz
        #bez compacta bi bilo view('knjige.edit', ['knjiga' => $knjiga])
    }

    public function show(Knjiga $knjiga): View
    {   #ako ne želimo sortirati ide samo $knjiga->load('primjerak');
        $knjiga->load(['primjerak' => function ($upit){#da se učitaju primjerci za dohvaćeni model, želimo da kontroler pripremi sve podatke za prikaz; prikaži ono što je povezano s knjigom
            #ide primjerak jer se metoda u modelu knjiga zove primjerak
            #load-> kada si povukao iz baze(get u index), nađi sve što je povezano s modelom koji si povukao
            $upit->orderBy('inventarniBroj');#ovaj $upit je kao na foru $this; parametar anonimne funkcije, taj $upit se poziva kada se poziva funkcija load, laravel to automatski stvara
        }]);

        return view('knjige.show', ['knjiga' => $knjiga]);
    }
}
