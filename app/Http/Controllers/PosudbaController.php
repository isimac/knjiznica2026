<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Primjerak;
use App\Models\Clan;
use App\Models\Posudba;

class PosudbaController extends Controller
{
    public function index() {

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

    return view('posudbe.index', ['posudbe'=>$posudbe]);
    }

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

    public function destroy($posudba_id, $primjerak_id) {

        Posudba::where('id', $posudba_id)->delete();

        Primjerak::where('id', $primjerak_id)->update(['posuden'=>'0']);

        return redirect()->route('posudba.index')->with('uspjeh', 'Posudba je uspjesno izbrisana');
    }
}
