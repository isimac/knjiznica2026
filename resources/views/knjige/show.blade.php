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
<br>
<h5>{{$knjiga->autor}}</h5>
<br>
<h5>{{$knjiga->isbn ?? 'Nije unesen'}}</h5>
<br>
<h5>{{$knjiga->godinaIzdanja}}</h5>
<br>
<p>Broj primjeraka</p>
<h5>{{$knjiga->primjerak->count()}}</h5>
<hr>
<h1>Fizički primjerci</h1>

    <a href="{{route('primjerak.create', $knjiga)}}">Dodaj primjerak</a>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Inventarni broj</th>
            <th>Akcije</th>
        </tr>
    </thead>
    <tbody>
        @forelse($knjiga->primjerak as $primjerak)
    <tr>
        <td>{{ $primjerak->id }}</td>
        <td>{{ $primjerak->inventarniBroj }}</td>

        <td>
            <a href="{{ route('primjerci.edit', $primjerak) }}">
                Uredi
            </a>

            <form action="{{ route('primjerci.destroy', $primjerak) }}"
                  method="POST"
                  style="display:inline;">

                @csrf
                @method('DELETE')

                <button type="submit">Obriši</button>
            </form>
        </td>
    </tr>

        @empty
          <tr>
             <td>Ova knjiga nema evidentiranih primjeraka.
             </td>
             </tr>
    @endforelse
</tbody>
</table>
<p>
    <a href="{{route('knjige.index')}}">Povratak na popis knjiga</a>
</p>

</body>
</html>