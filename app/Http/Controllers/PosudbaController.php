<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Primjerak;
use App\Models\Clan;
use App\Models\Posudba;
use App\Models\Knjiga;
use Carbon\Carbon;

class PosudbaController extends Controller
{
    public function index() {

    $clanovi=Clan::get();
    $knjige=Knjiga::get();

    $posudbe = DB::table('posudba')
    ->leftJoin('clan', 'clan.id', '=', 'posudba.clan_id')
    ->leftJoin('primjerak', 'primjerak.id', '=', 'posudba.primjerak_id')
    ->leftJoin('knjiga', 'knjiga.id', '=', 'primjerak.knjiga_id')
    ->select(
        'posudba.id as posudba_id',
        'primjerak.id as primjerak_id',
        'clan.ime as clan_ime', 
        'clan.prezime as clan_prezime', 
        'clan.clanskiBroj as clan_clanskiBroj', 
        'knjiga.naslov as knjiga_naslov', 
        'knjiga.autor as knjiga_autor', 
        'posudba.datumPosudbe as posudba_datumPosudbe', 
        'posudba.datumPovrata as posudba_datumPovrata',
        'posudba.brojDanaKasnjenja as posudba_brojDanaKasnjenja'
        )
    ->get();

    //izracunavanje razlike u danima 
    foreach($posudbe as $posudba) {
    $rokPovrata = Carbon::parse($posudba->posudba_datumPovrata);
    $trenutniDatum = Carbon::now();

    if ($trenutniDatum->greaterThan($rokPovrata)) {
        $posudba->posudba_brojDanaKasnjenja = (int) $rokPovrata->diffInDays($trenutniDatum);
        Posudba::where('id', $posudba->posudba_id)->update(['brojDanaKasnjenja' => $posudba->posudba_brojDanaKasnjenja, 'zakasninaPlacena' => 1]);
    } else {
        $posudba->posudba_brojDanaKasnjenja = 0;
        Posudba::where('id', $posudba->posudba_id)->update(['brojDanaKasnjenja' => 0, 'zakasninaPlacena' => 0]);
        }
    }

    return view('posudbe.index', [
        'posudbe'=>$posudbe,
        'clanovi'=>$clanovi,
        'knjige'=>$knjige
        ]);
    }

    public function indexFilter(Request $request) {

    $clanovi=Clan::get();
    $knjige=Knjiga::get();


    if($request->knjiga_id=="empty" && $request->clan_id!="empty") {
     $posudbe = DB::table('posudba')
    ->leftJoin('clan', 'clan.id', '=', 'posudba.clan_id')
    ->leftJoin('primjerak', 'primjerak.id', '=', 'posudba.primjerak_id')
    ->leftJoin('knjiga', 'knjiga.id', '=', 'primjerak.knjiga_id')
    ->select(
        'posudba.id as posudba_id',
        'primjerak.id as primjerak_id',
        'clan.ime as clan_ime', 
        'clan.prezime as clan_prezime', 
        'clan.clanskiBroj as clan_clanskiBroj', 
        'knjiga.naslov as knjiga_naslov', 
        'knjiga.autor as knjiga_autor', 
        'posudba.datumPosudbe as posudba_datumPosudbe', 
        'posudba.datumPovrata as posudba_datumPovrata',
        'posudba.brojDanaKasnjenja as posudba_brojDanaKasnjenja'
        )
    ->where('posudba.clan_id', $request->clan_id)
    ->get();

    return view('posudbe.index', [
        'posudbe'=>$posudbe,
        'clanovi'=>$clanovi,
        'knjige'=>$knjige
        ]);
    } elseif ($request->clan_id=="empty" && $request->knjiga_id!="empty") {
        $posudbe = DB::table('posudba')
    ->leftJoin('clan', 'clan.id', '=', 'posudba.clan_id')
    ->leftJoin('primjerak', 'primjerak.id', '=', 'posudba.primjerak_id')
    ->leftJoin('knjiga', 'knjiga.id', '=', 'primjerak.knjiga_id')
    ->select(
        'posudba.id as posudba_id',
        'primjerak.id as primjerak_id',
        'clan.ime as clan_ime', 
        'clan.prezime as clan_prezime', 
        'clan.clanskiBroj as clan_clanskiBroj', 
        'knjiga.naslov as knjiga_naslov', 
        'knjiga.autor as knjiga_autor', 
        'posudba.datumPosudbe as posudba_datumPosudbe', 
        'posudba.datumPovrata as posudba_datumPovrata',
        'posudba.brojDanaKasnjenja as posudba_brojDanaKasnjenja'
        )
    ->where('knjiga.id', $request->knjiga_id)
    ->get();

    return view('posudbe.index', [
        'posudbe'=>$posudbe,
        'clanovi'=>$clanovi,
        'knjige'=>$knjige
        ]);
    } elseif ($request->clan_id!="empty" && $request->knjiga_id!="empty") {
        $posudbe = DB::table('posudba')
    ->leftJoin('clan', 'clan.id', '=', 'posudba.clan_id')
    ->leftJoin('primjerak', 'primjerak.id', '=', 'posudba.primjerak_id')
    ->leftJoin('knjiga', 'knjiga.id', '=', 'primjerak.knjiga_id')
    ->select(
        'posudba.id as posudba_id',
        'primjerak.id as primjerak_id',
        'clan.ime as clan_ime', 
        'clan.prezime as clan_prezime', 
        'clan.clanskiBroj as clan_clanskiBroj', 
        'knjiga.naslov as knjiga_naslov', 
        'knjiga.autor as knjiga_autor', 
        'posudba.datumPosudbe as posudba_datumPosudbe', 
        'posudba.datumPovrata as posudba_datumPovrata',
        'posudba.brojDanaKasnjenja as posudba_brojDanaKasnjenja'
        )
    ->where('knjiga.id', $request->knjiga_id)
    ->where('posudba.clan_id', $request->clan_id)
    ->get();

    return view('posudbe.index', [
        'posudbe'=>$posudbe,
        'clanovi'=>$clanovi,
        'knjige'=>$knjige
        ]);
    } elseif($request->clan_id=="empty" && $request->knjiga_id=="empty") {
        return redirect()->route('posudba.index');
    }

    }//kraj indexFilter metode

    public function create(Primjerak $primjerak, Clan $clan) {

        $clanovi=Clan::get();
        return view('posudbe.create', ['primjerak'=>$primjerak, 'clanovi'=>$clanovi]);
    }

    public function store(Request $request) {
        $podaci=$request->validate([
            'clan_id'=>['required'],
            'primjerak_id'=>['required']
        ]);

        $podaci['datumPosudbe']=date("Y/m/d");
        $podaci['datumPovrata']=date('Y/m/d', strtotime('+30 days'));
        $podaci['brojDanaKasnjenja']=0;
        $podaci['zakasninaPlacena']=0;

        //Provjera ima li taj clan vec 3 posudene knjige
        $brojAktivnihPosudbi=Posudba::where('clan_id', $podaci['clan_id'])->count();
        if ($brojAktivnihPosudbi>2) {
            return redirect()->route('posudba.index')->with('greska', 'Clan vec ima maksimalan broj posudenih knjiga');
        }

        //ako clan nema posudene 3 knjige, posudba je dozvoljena
        Posudba::create($podaci);
        Primjerak::where('id', $podaci['primjerak_id'])->update(['posuden'=>'1']);
        return redirect()->route('knjige.index')->with('uspjeh', 'Posudba je uspjesno kreirana');
    }

    public function edit($posudba) {
        $trazenaPosudba = Posudba::findOrFail($posudba);
        return view('posudbe/edit', ['trazenaPosudba'=>$trazenaPosudba]);
    }

    public function update(Request $request, $trazenaPosudba) {

        if ($request->filled('datumPovrata'))  {
            Posudba::where('id', $trazenaPosudba)
                ->update(['datumPovrata' => $request->datumPovrata]);
        }


        if ($request->zakasninaPlacena=="2") {
            Posudba::where('id', $trazenaPosudba)
                ->update(['zakasninaPlacena' => '2' , 'datumPovrata'=>date('Y/m/d', strtotime('+100000 days'))]);
            return redirect()->route('posudba.index')->with('uspjeh', 'Placanje je evidentirano, brisanje posudbe moguce');
            }
            elseif ($request->zakasninaPlacena=="1") {
                Posudba::where('id', $trazenaPosudba)
                ->update(['zakasninaPlacena' => '1']);
                return redirect()->route('posudba.index');
            } else {
                return redirect()->route('posudba.index');
            }
    }

    public function destroy($posudba_id, $primjerak_id) {

        $posudba = Posudba::where('id', $posudba_id)->firstOrFail();
        $potvrdaPlacanja = $posudba->zakasninaPlacena;

        //0 - nema zakasnine
        //1 - ima zakasnine, neplacena
        //2 - bilo je zakasnine, placena 
        if ($potvrdaPlacanja==0 || $potvrdaPlacanja==2) {

            Posudba::where('id', $posudba_id)->delete();
            Primjerak::where('id', $primjerak_id)->update(['posuden'=>'0']);

            return redirect()->route('posudba.index')->with('uspjeh', 'Posudba je uspjesno izbrisana');
        } else {
            return redirect()->route('posudba.index')->with('greska', 'Posudba ne moze biti izbrisana jer ima neplacenu zakasninu');
        }
    }
}
