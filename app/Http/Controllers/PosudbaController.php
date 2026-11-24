<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clan;
use App\Models\Primjerak;
use App\Models\Posudba;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PosudbaController extends Controller
{
    public function index(): View
    {
        $posudbe=Posudba::with(['clan', 'primjerak.knjiga'])
            ->whereNull('datumPovrata')
            ->orderByDesc('datumPosudbe')
            ->get();

            return view('posudbe.index', ['posudbe' =>$posudbe]);
    }

    public function create(): View
    {
        $clanovi=Clan::orderBy('prezime')->orderBy('ime')->get();

        //Povuci primjerke + njima odgovarajuce knjige -> koji nemaju posudbu povezanu (primjerci koji nisu posudeni) -> primjerci koji nemaju datum povrata upisan
        $primjerci=Primjerak::with('knjiga')->whereDoesntHave('posudba', function($upit)
        {
            $upit->whereNull('datumPovrata');
        })->orderBy('inventarniBroj')->get();

        return view('posudbe.create', ['clanovi'=>$clanovi, 'primjerci'=>$primjerci]);
    }

    public function store(Request $request): RedirectResponse
    {
        $podaci=$request->validate([
            'clan_id'=>['required', 'integer', 'exists:clan,id'],
            'primjerak_id'=>['required', 'integer', 'exists:primjerak,id']
        ]);

        //TRANSAKCIJA U LARAVELU 

        //Mi ode koristimo transakciju da risimo slucaj da se isti primjerak posuduje u isto vrime od dva korisnika 
        //To radi ovaj lockForUpdate
        DB::transaction(function () use ($podaci)
        {
            $primjerak=Primjerak::whereKey(
                $podaci['primjerak_id'])->lockForUpdate()->firstOrFail();
               
            //Provjera jel ovaj primjerak vec posuden
            $vecPosuden=$primjerak->posudba()->whereNull('datumPovrata')->exists();

            if ($vecPosuden)
                {
                    throw ValidationException::withMessages(['primjerak_id'=>'Odabrani primjerak je već posuđen']);
                }

            //Ako nije vec posuden, krecemo u kreiranje posudbe

                $datumPosudbe=today();

               Posudba::create([
                'clan_id'=>$podaci['clan_id'],
                'primjerak_id'=>$podaci['primjerak_id'],
                'datumPosudbe'=>$datumPosudbe->toDateString(),
                'datumPovrata'=>null,  //STARO:  $datumPosudbe->copy()->addDay(30)->toDateString(),
                'brojDanaKasnjenja'=>null,
                'zakasninaPlacena'=>false
               ]); 
        },3);   //Ovaj 3 na kraju znaci da ce Laravel ovu transakciju probat 3 puta prije odustajanja 

        //KRAJ TRANSAKCIJE 

        return redirect()->route('posudbe.index')
                            ->with('uspjeh', 'Posudba je evidentirana');
    }

    public function povrat(Posudba $posudba):RedirectResponse 
    {
        //Ovo je trasnakcija radi vjezbe, moglo se ovo i bez 
        //Posudba nan u argument metode dolazi iz rute
        DB::transaction (function () use ($posudba) {

            $primjerak=Primjerak::whereKey($posudba->primjerak_id)
            ->lockForUpdate()
            ->firstOrFail();

            //Iako ovu posudbu dobijamo iz rute i imamo gori u metodi, moramo je opet pozvati nanovo radi transakcije 
            //Teoretski je moguce da je doslo do promjene u vrimenu izmedu poziva metode i pocetka transakcije u metodi
            //Ako aplikacija ima masu korisnika to je sasvim moguce, zato se triba odma zastititi
            $posudba=Posudba::whereKey($posudba->id)
            ->lockForUpdate()
            ->firstOrFail();

            if($posudba->datumPovrata!==null) {
                throw ValidationException::withMessages([
                    'povrat'=>'Povrat je vec evidentiran'
                ]);
            }

            $datumPovrata=today();
            $datumPosudbe=$posudba->datumPosudbe;
            $brojDanaKasnjenja=$datumPosudbe->diffInDays($datumPovrata);

            if ($brojDanaKasnjenja>30) {
                $brojDanaKasnjenja-=30;
            } else {
                $brojDanaKasnjenja=0;
            }

            $posudba->update([
                'datumPovrata'=>$datumPovrata->toDateString(),
                'brojDanaKasnjenja'=>$brojDanaKasnjenja,
            ]);
            
        }, 3);  //opet trojka na kraju transakcije

        //Ako je sve uspilo
        return redirect()->route('posudbe.index')->with('uspjeh', 'Povrat je evidentiran');
    }

    public function zakasnjele() {
        $posudbe=Posudba::with(['clan', 'primjerak.knjiga'])
            ->whereNull('datumPovrata')
            //ZASTO ODE NIJE: whereNotNull('brojDanaKasnjenja')
            //Zato sto je taj podatak u bazi null sve do momenta kada mi stisnemo button i rucno unesemo povrat, pa metoda izracuna dane 
            //Mi zelimo bez unosa u bazu izlistati sve koje trenutno kasne, bez da nuzno upisujemo povrat za sve od njih
            //Dakle moramo racunat dinamicki, na sljedeci nacin:
            ->where('datumPosudbe', '<', today()->subDays(30))
            ->orderByDesc('datumPosudbe')
            ->get();

            return view('posudbe.zakasnjele', ['posudbe' =>$posudbe]);
    }


}
