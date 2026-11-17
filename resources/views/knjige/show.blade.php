<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalji knjige</title>
</head>
<body>
    <h1>Detalji knjige</h1>

    <h3>{{$knjiga->naslov}}</h3>
    <h5>{{$knjiga->autor}}</h5>
    <h5>{{$knjiga->isbn ?? 'Nije unesen'}}</h5>
    <h5>{{$knjiga->godinaIzdanja}}</h5>
    Broj primjeraka: <h5>{{$knjiga->primjerak->count()}}</h5>
    <hr>
    <h1>Fizički primjerci</h1>
    <a href="{{route('primjerci.create', $knjiga)}}">Dodaj primjerak</a>
    @if(session('obrisan'))
        <p>{{session('obrisan')}}</p>
    @endif
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Inventarni Broj</th>
                <th>Akcije</th>
            </tr>
        </thead>
        <tbody>
            @forelse($knjiga->primjerak as $primjerak)
            <tr>
                <td>{{$primjerak->id}}</td>
                <td>{{$primjerak->inventarniBroj}}</td>
                <td><a href="{{route('primjerci.edit', $primjerak)}}">Uredi</a></td>
                <td>
                    <form action="{{route('primjerci.destroy', $primjerak)}}" method="post" onsubmit="return confirm('Želite li obrisati primjerak?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Obriši</button>
                    </form>
                </td>
            </tr>

            @empty
            <tr>
                <td colspan="2">Ova knjiga nema evidentiranih primjeraka</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <p><a href="{{route('knjige.index')}}">Povratak na popis knjiga</a></p>
</body>
</html>