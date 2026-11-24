<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clan;
use App\Models\Primjerak;
use App\Models\Posudba;#uzimamo model čiji kontroler radimo i modele s kojima smo u vezi
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;#da možemo koristiti transakcije
use Illuminate\Validation\ValidationException;

class PosudbaController extends Controller
{
    public function index(): View
    {
        $posudbe = Posudba::with(['clan', 'primjerak.knjiga'])
            ->whereNull('datumPovrata')
            ->orderByDesc('datumPosudbe')
            ->get();#with->eager loading (željno učitavanje), automatski uz člana pozovi i primjerak knjige, ide primjerak.knjiga jer mi prvo dolazimo do primjerka a preko njega do knjige, zato tako i zapisujemo, prvo posudba pa . knjiga
            #where null -> da se prikazuju samo posudbe koje nisu gotove, gdje datumPovrata nije unesen, samo aktivni
            #sortiramo od najnovije posudbe do najstarije
        return view('posudbe.index', ['posudbe'=>$posudbe]);
    }

    public function create(): View
    {#moramo dohvatiti članove i primjerke koji su dostupni
        $clanovi = Clan::orderBy('prezime')->orderBy('ime')->get();#dohvatiti člana
        $primjerci = Primjerak::with('knjiga')->whereDoesntHave('posudba', function($upit)
        {#primjerak koji nije u vezi s praznim datumom povratka
            $upit->whereNull('datumPovrata');#prazni datum povratka -> primjerak nije vračen
        })->orderBy('inventarniBroj')->get();#where doesnt have ima 2 arguemnta, tablica posuba i anonima funckija preko koje mi ddajemo uvjete
        return view('posudbe.create',['clanovi'=>$clanovi, 'primjerci'=>$primjerci]);
    }

    public function store(Request $request): RedirectResponse
    {
        $podaci = $request->validate([
            'clan_id' => ['required', 'integer', 'exists:clan,id'],#ne smije biti razmak u exists!!!
            'primjerak_id' => ['required', 'integer', 'exists:primjerak,id']
        ]);#exists-> provjeravamo postoji li taj clan_id u tablici clan na mjestu id
        DB::transaction(function () use ($podaci)#koristimo use jer anonimna funkcija nema pristup podacima koji su stvoreni izvan nje; use koristimo da ona može koristiti te podatke (kao da su stvoreni unutar nje)
        {
            $primjerak = Primjerak::whereKey(
                $podaci['primjerak_id'])->lockForUpdate()->firstOrFail();#whereKey traži primjerak gdje je id taj iz podataka; ako je pronađen -> lockForUpdate (da se baza zaključa (taj primjerak) dok se ne provede transakcija)
                #firstorfail -> dohvati taj primjerak, ako ne postoji, vratiti će grešku da ne postoji

            $vecPosuden = $primjerak->posudba()->whereNull('datumPovrata')->exists();#provjeri da li je taj primjerak posuđen ili nije (whereNull), exists vraća samo true ili false

            if($vecPosuden)
                {
                    throw ValidationException::withMessages(['primjerak_id'=>'Odabrani primjerak je već posuđen!']);
                }
            $datumPosudbe = today();#now()->startOfDay();#now->ispisuje današnji datum i trenutni vrijeme, startofday->stavlja na 00:00:00, endOfDay bi stavio na 23:59:59
            
            Posudba::create([
                'clan_id' => $podaci['clan_id'],
                'primjerak_id' => $podaci['primjerak_id'],
                'datumPosudbe' => $datumPosudbe->toDateString(),#lakše je tako pospremiti podatke
                'datumPovrata' => null,# NE MOŽEMO IMATI OVO $datumPosudbe->copy()->addDay(30)->toDateString() zato što ona nema posudbe koja u datum povrata ima null,#izrađujemo kopiju (vrijednosti)onoga što piše u datumPosudbe i dodajemo 30 dana na tu vrijednost
                'brojDanaKasnjenja' => null,
                'zakasninaPlacena' => false
            ]);
        }, 3);#3 označava maksimalni broj pokušaja u slučaju da se baza deadlocka, ako transakcija ne prođe 3 puta, onda će laravel izbaciti exception, da nismo ništa stavili onda bi se samo 1 pokušala, 3-5 se stavlja
        return redirect()->route('posudbe.index')
                            ->with('uspjeh', 'Posudba je evidentirana!');
    }

    public function povrat(Posudba $posudba):RedirectResponse
    {
        DB::transaction( function () use ($posudba)
        {
            /*$primjerak = \App\Models\Primjerak::whereKey($posudba->primjerak_id)
                            ->lockForUpdate()
                            ->firstOrFail();*/
            $primjerak = Primjerak::whereKey($posudba->primjerak_id)#tražimo primjerak koji je u toj posudbi
                            ->lockForUpdate()#zaključavamo ga
                            ->firstOrFail();
            $posudba = Posudba::whereKey($posudba->id)#poziva se ponovno posudba jer se neko stanje već moglo izmijeniti prije početka transakcije
                            ->lockForUpdate()
                            ->firstOrFail();
            if($posudba->datumPovrata !== null)#znači da je povrat već obavljen, druga kontrola prije prčkanja po bazi podataka
                {
                    throw ValidationException::withMessages(['povrat'=>'Povrat je već evidentiran!']);
                }

            $datumPovrata=today();
            $datumPosudbe = $posudba->datumPosudbe;
            #$brojDanaKasnjenja = $datumPovrata - $datumPosudbe
            $brojDanaKasnjenja = $datumPosudbe->diffInDays($datumPovrata)-30;#carbonova funckija za izračun razlike, stavljamo s kojim datumom oduzimamo, daje apsolutnu vrijednost pa je svejedno s kojim datumom se oduzima
                                        #oduzimamo s 30 da dobijemo stvarne dane kašnjenja je max osoba smije držati 30 dana knjigu kod sebe
            if($brojDanaKasnjenja < 0)
                {
                    $brojDanaKasnjenja = 0;
                }
        
                $posudba->update([
                    'datumPovrata' => $datumPovrata->toDateString(),
                    'brojDanaKasnjenja' => $brojDanaKasnjenja
                ]);
        },3);
        return redirect()->route('posudbe.index')->with('uspjeh', 'Povrat je uspješno evidentiran');
    }
    
    public function zakasnjele():View
    {
        $posudbe = Posudba::with(['clan', 'primjerak.knjiga'])
                            ->whereNull('datumPovrata')
                            ->where('datumPosudbe', '<', today()->subDays(30))#od današnjeg dana oduzmi 30, ako je taj broj manji od datuma posudbe, ta osoba kasni s povratom
                            ->orderBy('datumPosudbe')
                            ->get();
        
        return view('posudbe.zakasnjele', ['posudbe' => $posudbe]);
    }
}
