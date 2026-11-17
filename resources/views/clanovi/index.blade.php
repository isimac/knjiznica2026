
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Članovi knjižnice</title>
</head>
<body>

<h1>Članovi knjižnice</h1>

<a href="{{ route('clanovi.create') }}">Dodaj novog člana</a>

@if(session('uspjeh'))
    <p>{{ session('uspjeh') }}</p>
@endif

@if(session('greska'))
    <p>{{ session('greska') }}</p>
@endif

<br><br>

<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Članski broj</th>
            <th>Ime</th>
            <th>Prezime</th>
            <th>E-mail</th>
            <th>Broj mobitela</th>
            <th>Broj posudbi</th>
            <th>Akcije</th>
        </tr>
    </thead>

    <tbody>
        @forelse($clanovi as $clan)
            <tr>
                <td>{{ $clan->id }}</td>
                <td>{{ $clan->clanskiBroj }}</td>
                <td>{{ $clan->ime }}</td>
                <td>{{ $clan->prezime }}</td>
                <td>{{ $clan->email ?? '-' }}</td>
                <td>{{ $clan->brojMobitela }}</td>
                <td>{{ $clan->posudba_count }}</td>

                <td>
                    <a href="{{ route('clanovi.show', $clan) }}">Detalji</a>
                    <a href="{{ route('clanovi.edit', $clan) }}">Uredi</a>

                    <form action="{{ route('clanovi.destroy', $clan) }}" method="POST" style="display:inline;" onsubmit="return confirm('Želite li obrisati člana?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Obriši</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8">Nema evidentiranih članova.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<p>
    <a href="{{ route('knjige.index') }}">Povratak na knjige</a>
</p>

</body>
</html>
