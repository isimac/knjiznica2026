
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Detalji člana</title>
</head>
<body>

<h1>{{ $clan->ime }} {{ $clan->prezime }}</h1>

<p><strong>Članski broj:</strong> {{ $clan->clanskiBroj }}</p>
<p><strong>E-mail:</strong> {{ $clan->email ?? 'Nije unesena' }}</p>
<p><strong>Broj mobitela:</strong> {{ $clan->brojMobitela }}</p>

<h2>Povijest posudbi</h2>

<p>Ukupan broj evidentiranih posudbi: {{ $clan->posudbe->count() }}</p>

<table border="1">
    <thead>
        <tr>
            <th>ID posudbe</th>
            <th>Datum posudbe</th>
            <th>Datum povrata</th>
        </tr>
    </thead>

    <tbody>
        @forelse($clan->posudbe as $posudba)
            <tr>
                <td>{{ $posudba->id }}</td>
                <td>{{ $posudba->datumPosudbe }}</td>
                <td>{{ $posudba->datumPovrata ?? 'Nije vraćeno' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="3">Član još nema evidentiranih posudbi.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<p>
    <a href="{{ route('clanovi.index') }}">Povratak na popis članova</a>
</p>

</body>
</html>
