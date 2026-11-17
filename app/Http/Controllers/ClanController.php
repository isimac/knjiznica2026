<?php

namespace App\Http\Controllers;

use App\Models\Clan;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ClanController extends Controller
{
    public function index(): View
    {
        $clanovi = Clan::withCount('posudbe')->orderBy('prezime')->orderBy('ime')->get();

        return view('clanovi.index', ['clanovi' => $clanovi,]);
    }

    public function create(): View
    {
        return view('clanovi.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $podaci = $request->validate([
            'ime' => ['required', 'string', 'max:255'],
            'prezime' => ['required', 'string', 'max:255'],
            'brojMobitela'=> ['required', 'string', 'max:30'],
            'clanski_broj' => [
                'required',
                'string',
                'max:255',
                Rule::unique('clanovi', 'clanski_broj'),
            ],
            'email' => ['nullable','email', 'max:255',
            ],
        ]);

        $podaci['email'] = $podaci['email'] ?? null;

        Clan::create($podaci);

        return redirect()
            ->route('clanovi.index')
            ->with(
                'uspjeh',
                'Novi član uspješno je evidentiran.'
            );
    }

    public function show(Clan $clan): View
    {
        $clan->load([
            'posudbe' => function ($upit) {
                $upit->orderByDesc('datum_posudbe');
            },
        ]);

        return view('clanovi.show', [
            'clan' => $clan,
        ]);
    }

    public function edit(Clan $clan): View
    {
        return view('clanovi.edit', [
            'clan' => $clan,
        ]);
    }

    public function update(Request $request, Clan $clan): RedirectResponse
    {
        $podaci = $request->validate([
            'ime' => ['required', 'string', 'max:255'],
            'prezime' => ['required', 'string', 'max:255'],
            'brojMobitela'=> ['required', 'string', 'max:30'],
            'clanski_broj' => [
                'required',
                'string',
                'max:255',
                Rule::unique('clanovi', 'clanski_broj')
                    ->ignore($clan->id),
            ],
            'email' => ['nullable','email','max:255',
            ],
        ]);

        $podaci['email'] = $podaci['email'] ?? null;

        $clan->update($podaci);

        return redirect()
            ->route('clanovi.index')
            ->with(
                'uspjeh',
                'Podaci o članu uspješno su izmijenjeni.'
            );
    }

    public function destroy(Clan $clan): RedirectResponse
    {
        if ($clan->posudbe()->exists()) {
            return redirect()
                ->route('clanovi.index')
                ->with('greska','Člana nije moguće obrisati jer ima evidentiranu povijest posudbi.'
                );
        }

        $clan->delete();

        return redirect()
            ->route('clanovi.index')
            ->with('uspjeh','Član je uspješno obrisan.'
            );
    }
}