<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Knjižnica - popis knjiga</title>
    <style>
        td
        {
            text-align:center;
            background-color:aqua;
        }
    </style>
</head>
<body>
    <h1>Informacijski sustav knjižnice</h1>
    <a href="{{route('knjige.create')}}">Dodaj novu knjigu</a>
    <br>
    @if(session('uspjeh'))
        {{session('uspjeh')}}
    @endif

    <h3><strong>Popis knjiga</strong></h3>

    @if($knjige->isEmpty())
        <p>U knjižnici nema knjiga</p>
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
                        <td><a href="{{route('knjige.edit', $knjiga)}}">Uredi
                            <form action="{{route('knjige.destroy', $knjiga)}}" method="POST" onsubmit="return confirm('Želite li obrisati knjigu?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Obriši</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
        @endif
    
</body>
</html>