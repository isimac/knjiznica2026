<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Knjiznica - popis knjiga </title>
</head>
<body>
    <h1>Informacijski sustav knjiznice</h1>

    <a href="{{route('knjige.create')}}">Dodaj novu knjigu</a>

    @if(session('uspjeh'))
    {{session('uspjeh')}}
    @endif

    <h3><strong>Popis knjiga</h3>
    
    @if($knjige->isEmpty()) 
        <p>U knjiznici nema knjiga</p>
    @else
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Naslov</th>
                    <th>Autor</th>
                    <th>ISBN</th>
                    <th>Godina izdanja</th>
                    <th>Broj primjeraka</th>
                    <th>Akcije</th>
                </tr>
            </thead>
            <tbody>
                @foreach($knjige as $knjiga)
                <tr>
                    <td>{{$knjiga->id}}</td>
                    <td>{{$knjiga->naslov}}</td>
                    <td>{{$knjiga->autor}}</td>
                    <td>{{$knjiga->isbn ?? 'nema podatka'}}</td>
                    <td>{{$knjiga->godinaIzdanja}}</td>
                    <td>{{$knjiga->primjerak_count}}</td>
                    <td>
                        <a href="{{route('knjige.edit', $knjiga)}}">Uredi</a>
                        <form action="{{route('knjige.destroy', $knjiga)}}" method="post" onsubmit="return confirm('Zelite li obrisati knjigu)">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Obrisi</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>