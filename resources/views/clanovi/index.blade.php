<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Clanovi</title>
</head>
<body>
    <h1>Upravljanje clanovima</h1>

    @if(session('uspjeh'))
    {{session('uspjeh')}}
    @endif

    @if(session('greska'))
    {{session('greska')}}
    @endif

    <h3><strong>Popis Clanova</h3>

    <h4><a href="{{route('clan.create')}}">Dodaj clana</a></h4>
    
    @if($clanovi->isEmpty()) 
        <p>Trenutno nema registriranih clanova</p>
    @else
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ime</th>
                    <th>Prezime</th>
                    <th>Mobitel</th>
                    <th>email</th>
                    <th>Clanski broj</th>
                    <th>Akcije</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clanovi as $clan)
                <tr>
                    <td>{{$clan->id}}</td>
                    <td><a href="{{route('clan.show', $clan)}}">{{$clan->ime}}</a></td>
                    <td>{{$clan->prezime}}</td>
                    <td>{{$clan->brojMobitela ?? 'nema podatka'}}</td>
                    <td>{{$clan->email}}</td>
                    <td>{{$clan->clanskiBroj}}</td>
                    <td>
                        <a href="{{route('clan.edit', $clan)}}">Uredi</a>
                        <form action="{{route('clan.destroy', $clan)}}" method="post" onsubmit="return confirm('Zelite li obrisati clana')">
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

       <p>Povratak na <a href="{{route('knjige.index')}}">popis knjiga</a></p>

    
</body>
</html>