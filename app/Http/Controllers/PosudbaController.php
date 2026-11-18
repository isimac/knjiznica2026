<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Primjerak;
use App\Models\Clan;
use App\Models\Posudba;

class PosudbaController extends Controller
{
    public function index() {

        $posudbe=Posudba::get();
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


        Posudba::create($podaci);
        Primjerak::where('id', $podaci['primjerak_id'])->update(['posuden'=>'1']);
        return redirect()->route('knjige.index')->with('uspjeh', 'Posudba je uspjesno kreirana');
    }
}
