<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clan;
use App\Models\Primjerak;
use App\Models\Posudba;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;



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
        $primjerci=Primjerak::with('knjiga')->whereDoesntHave('posudba', function($upit)
        {
            $upit->whereNull('datumPovrata');
        })->orderBy('inventarniBroj')->get();

        return view('posudbe.create', ['clanovi'=>$clanovi, 'primjerci'=>$primjerci]);
    }

    public function store(Request $request): RedirectResponse
    {
        $podaci=$request->validate([
            'clan_id'=>['required', 'integer', 'exists:clan, id'],
            'primjerak_id'=>['required', 'integer', 'exists:primjerak, id']
        ]);

        DB::transaction(function () use ($podaci)
        {
            $primjerak=Primjerak::whereKey(
                $podaci['primjerak_id'])->lockForUpdate()->firstOrFail();
               
            $vecPosuden=$primjerak->posudba()->whereNull('datumPovrata')->exists();

            if ($vecPosuden)
                {
                    throw ValidationException::withMessages(['primjerak_id'=>'Odabrani primjerak je već posuđen']);
                }
            
                $datumPosudbe=today();

               Posudba::create([
                'clan_id'=>$podaci['clan_id'],
                'primjerak_id'=>$podaci['primjerak_id'],
                'datumPosudbe'=>$datumPosudbe->toDateString(),
                'datumPovrata'=>$datumPosudbe->copy()->addDay(30)->toDateString(),
                'brojDanaKasnjenja'=>null,
                'zakasninaPlacena'=>false
               ]); 
        },3);

        return redirect()->route('posudbe.index')
                            ->with('uspjeh', 'Posudba je evidentirana');
    }
}
