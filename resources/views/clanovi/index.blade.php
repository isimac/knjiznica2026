<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Popis članova</title>
    <style>
        td {
        text-align: center;
    }
    </style>
</head>
<body>
    <h1>Popis članova knjižnice</h1>
     @if(session('uspjeh'))
        <p>{{session('uspjeh')}}</p>
    @endif
    <p><a href="{{route('knjige.index')}}">Popis knjiga</a></p>
    <p><a href="{{route('clanovi.create')}}">Dodaj novog člana</a></p>
    <table border="1">
        <thead>
            <tr>
              <th>ID</th>
              <th>Ime</th>
              <th>Prezime</th>
              <th>Broj mobitela</th>
              <th>Email</th>
              <th>Članski broj</th>
              <th>Akcije</th>
            </tr>
        </thead>
        <tbody>
            @forelse($clanovi as $clan)
            <tr>
                <td>{{$clan->id}}</td>
                <td>{{$clan->ime}}</td>
                <td>{{$clan->prezime}}</td>
                <td>{{$clan->brojMobitela}}</td>
                <td>{{$clan->email  ?? 'Nema'}}</td>
                <td>{{$clan->clanskiBroj}}</td>
                <td>
                    <a href="{{route('clanovi.edit', $clan)}}">Uredi</a>
                    <form action="{{route('clanovi.destroy', $clan)}}" method="post" onsubmit="return confirm('Želite li obrisati člana?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Obriši</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" >Zasada nema članova</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>