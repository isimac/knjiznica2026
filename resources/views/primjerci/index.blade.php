
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Popis primjeraka</title>
</head>
<body>

<h1>Fizički primjerci knjiga</h1>

@if(session('uspjeh'))
    <p>{{ session('uspjeh') }}</p>
@endif

@if(session('greska'))
    <p>{{ session('greska') }}</p>
@endif

<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Inventarni broj</th>
            <th>Knjiga</th>
            <th>Akcije</th>
        </tr>
    </thead>

    <tbody>
        @forelse($primjerci as $primjerak)
            <tr>
                <td>{{ $primjerak->id }}</td>

                <td>{{ $primjerak->inventarniBroj }}</td>

                <td>{{ $primjerak->knjiga->naslov }}</td>

                <td>
                    <a href="{{ route('primjerci.show', $primjerak) }}">
                        Detalji
                    </a>

                    <a href="{{ route('primjerci.edit', $primjerak) }}">
                        Uredi
                    </a>

                    <form
                        action="{{ route('primjerci.destroy', $primjerak) }}" method="POST"
                        onsubmit="return confirm('Obrisati primjerak?')">
                        @csrf
                        @method('DELETE')

                        <button type="submit">Obriši</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td>Nema evidentiranih primjeraka.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<p>
    <a href="{{ route('knjige.index') }}">
        Povratak na knjige
    </a>
</p>

</body>
</html>
