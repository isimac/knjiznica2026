<?php

namespace App\Http\Controllers;

use App\Models\Clan;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ClanController extends Controller
{
    // Prikaz svih članova
    public function index(): View
    {
        $clanovi = Clan::withCount('posudba')->orderBy('prezime')->orderBy('ime')->get();

        return view('clanovi.index', ['clanovi' => $clanovi]);
    }

    // Obrazac za unos novog člana
    public function create(): View
    {
        return view('clanovi.create');
    }

    // Spremanje novog člana
    public function store(Request $request): RedirectResponse
    {
        $podaci = $request->validate([
            'ime' => ['required', 'string', 'max:255'],
            'prezime' => ['required', 'string', 'max:255'],
            'brojMobitela' => ['required', 'string', 'max:30'],
            'clanskiBroj' => ['required', 'string', 'max:255', Rule::unique('clan', 'clanskiBroj')],
            'email' => ['nullable', 'email', 'max:255'],
        ]);

        Clan::create($podaci);

        return redirect()->route('clanovi.index')->with('uspjeh', 'Novi član uspješno je evidentiran.');
    }

    // Prikaz detalja člana
    public function show(Clan $clan): View
    {
        $clan->load(['posudba' => function ($upit) {
            $upit->orderByDesc('datumPosudbe');
        }]);

        return view('clanovi.show', ['clan' => $clan]);
    }

    // Obrazac za uređivanje člana
    public function edit(Clan $clan): View
    {
        return view('clanovi.edit', ['clan' => $clan]);
    }

    // Spremanje izmjena člana
    public function update(Request $request, Clan $clan): RedirectResponse
    {
        $podaci = $request->validate([
            'ime' => ['required', 'string', 'max:255'],
            'prezime' => ['required', 'string', 'max:255'],
            'brojMobitela' => ['required', 'string', 'max:30'],
            'clanskiBroj' => ['required', 'string', 'max:255', Rule::unique('clan', 'clanskiBroj')->ignore($clan->id)],
            'email' => ['nullable', 'email', 'max:255'],
        ]);

        $podaci['email'] = $podaci['email'] ?? null;

        $clan->update($podaci);

        return redirect()->route('clanovi.index')->with('uspjeh', 'Podaci o članu uspješno su izmijenjeni.');
    }

    // Brisanje člana
    public function destroy(Clan $clan): RedirectResponse
    {
        if ($clan->posudba()->exists()) {
            return redirect()->route('clanovi.index')->with('greska', 'Člana nije moguće obrisati jer ima evidentiranu povijest posudbi.');
        }

        $clan->delete();

        return redirect()->route('clanovi.index')->with('uspjeh', 'Član je uspješno obrisan.');
    }
}
