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
                    <th>Ime clana</th>
                    <th>Prezime clana</th>
                    <th>Clanski broj</th>
                    <th>Naslov knjige</th>
                    <th>Autor knjige</th>
                    <th>Datum posudbe</th>
                    <th>Datum povrata</th>
                    <th>Broj dana kasnjenja</th>
                    <th>Akcije</th>
                </tr>
            </thead>
            <tbody>
                @forelse($posudbe as $posudba)
                <tr>
                    <td>{{$posudba->clan_ime}}</td>
                    <td>{{$posudba->clan_prezime}}</td>
                    <td>{{$posudba->clan_clanskiBroj}}</td>
                    <td>{{$posudba->knjiga_naslov}}</td>
                    <td>{{$posudba->knjiga_autor}}</td>
                    <td>{{$posudba->posudba_datumPosudbe}}</td>
                    <td>{{$posudba->posudba_datumPovrata}}</td>
                    <td>{{$posudba->posudba_brojDanaKasnjenja}}</td>
                    <td>
                        <form action="{{route('posudba.destroy', [$posudba->posudba_id, $posudba->primjerak_id])}}" method="post">
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