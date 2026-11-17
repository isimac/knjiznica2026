<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Knjiznica - detalji knjige</title>
</head>
<body>
    <h1>Detalji knjige</h1>
    <br>

    <p>Dodaj 
    <a href="{{route('primjerci.create', $knjiga)}}"> primjerak </a>
    </p>

    <h3>{{$knjiga->naslov}}</h3>
    <br>
    <h5>{{$knjiga->autor}}</h5>
    <br>
    <h5>{{$knjiga->isbn ?? 'Nije unesen'}}</h5>
    <br>
    <h5>{{$knjiga->godinaIzdanja}}</h5>
    <br>
    <p>Broj primjeraka: </p>
    <h5>{{$knjiga->primjerak->count()}}</h5>
    <br>
    <hr>
    <br>

    <h1>Fizicki primjerci</h1>
    <br>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Inventarni broj</th>
            </tr>
        </thead>

        <tbody>
            @forelse($knjiga->primjerak as $primjerak)
            <tr>
                <td>{{$primjerak->id}}</td>
                <td>{{$primjerak->inventarniBroj}}</td>
                <td><a href="{{route('primjerci.edit', $primjerak)}}">Uredi</a></td>
                <td>
                <form action="{{route('primjerci.destroy', $primjerak)}}" method="post" onsubmit="return confirm('Zelite li obrisati primjerak?')">
                    @csrf
                    @method('DELETE')
                    <button>Obrisi</button>
                </form>
                </td>
            </tr>
        

        @empty
        <tr>
            <td>Knjiga nema evidentiranih primjeraka.</td>
        </tr>
        @endforelse 

        </tbody>
    </table>

    <p>
        Povratak na <a href="{{route('knjige.index')}}">popis knjiga</a>
    </p>



</body>
</html>