<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aktivne posudbe</title>
</head>
<body>
    <h1>Aktivne posudbe</h1>
    @auth
        <p>Prijavljen korisnik: <strong>{{auth()->user()->name}}</strong></p><!-- user() je metoda koja vraća objekt logiranog korisnika-->
    @endauth
    <form action="{{route('logout')}}" method="post">
        @csrf
        <button type="submit">Odjava</button>
    </form>
    <a href="{{route('posudbe.create')}}">Unos nove posudbe</a>
    <br>
    @if(session('uspjeh'))
        <p>{{session('uspjeh')}}</p>
    @endif

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Član</th>
                <th>Knjiga</th>
                <th>Inventarni Broj</th>
                <th>Datum posudbe</th>
                <th>Datum povrata</th>
                <th>Status</th>
                <th>Akcije</th>
            </tr>
        </thead>
        <tbody>
            @forelse($posudbe as $posudba)
            <tr>
                <td>{{$posudba->id}}</td>
                <td>{{$posudba->clan->ime}} {{$posudba->clan->prezime}}</td> <!--može se tako raditi zbog eloquent orm-a, pošto posudba u sebi ima id clana, može se tako dohvatiti ime i prezime člana -->
                <td>{{$posudba->primjerak->knjiga->naslov}}</td>
                <td>{{$posudba->primjerak->inventarniBroj}}</td>
                <td>{{$posudba->datumPosudbe->format('d.m.Y.')}}</td>
                <td>{{$posudba->datumPovrata?->format('d.m.Y.') ?? 'Knjiga nije vraćena'}}</td><!--Upitnik kod datumPovrata spriječava da se uopće metoda izvede ako je datumPovrata null -->
                <td>
                    @if ($posudba->datumPosudbe->copy()->addDays(30)<today())
                        <strong style="color:red;">Kašnjenje</strong>
                    @else
                        <strong style="color:green;">Sve je u redu</strong>
                    @endif
                </td>
                <td><form action="{{route('posudbe.povrat', $posudba)}}" method="post" onsubmit="return confirm('Želite li vratiti knjigu?')">
                    @csrf
                    @method('PATCH')
                    <button type="submit">Povrat knjige</button>
                </form></td>
            </tr>
            @empty
            <tr>
                <td colspan="7">Nema posudbi</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <br>
    <a href="{{route('knjige.index')}}">Povratak na popis knjiga</a>
</body>
</html>