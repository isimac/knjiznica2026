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
}
