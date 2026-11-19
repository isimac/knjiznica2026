<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Knjiznica - posudbe</title>
</head>
<body>
    <h1>Upravljanje posudbama</h1>

     @if(session('uspjeh'))
    {{session('uspjeh')}}
    @endif

    @if(session('greska'))
    {{session('greska')}}
    @endif

    <h3><strong>Aktivne posudbe</h3>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Clan</th>
                    <th>Primjerak</th>
                    <th>Datum posudbe</th>
                    <th>Datum povrata</th>
                    <th>Broj dana kasnjenja</th>
                    <th>Zakasnina placena?</th>
                    <th>Akcije</th>
                </tr>
            </thead>
            <tbody>
                @forelse($posudbe as $posudba)
                <tr>
                    <td>{{$posudba->id}}</td>
                    <td>{{$posudba->clan_id}}</td>
                    <td>{{$posudba->primjerak_id}}</td>
                    <td>{{$posudba->datumPosudbe}}</td>
                    <td>{{$posudba->datumPovrata}}</td>
                    <td>{{$posudba->brojDanaKasnjenja}}</td>
                    <td>{{$posudba->zakasninaPlacena}}</td>
                    <td>
                        <form action="{{route('posudba.destroy', $posudba)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Obrisi</button>
                        </form>
                    </td>
                </tr>
                @empty 
                    <p>Trenutno nema aktivnih posudbi</p>

                @endforelse
            </tbody>
        </table>

    <p>Povratak na <a href="{{route('knjige.index')}}">popis knjiga</a></p>
    
</body>
</html>