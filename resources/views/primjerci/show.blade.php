
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Detalji primjerka</title>
</head>
<body>

<h1>Detalji primjerka</h1>

@if(session('uspjeh'))
    <p>{{ session('uspjeh') }}</p>
@endif

<p>
    <strong>ID primjerka:</strong>
    {{ $primjerak->id }}
</p>

<p>
    <strong>Inventarni broj:</strong>
    {{ $primjerak->inventarniBroj }}
</p>

<p>
    <strong>Knjiga:</strong>
    {{ $primjerak->knjiga->naslov }}
</p>

<p>
    <strong>Autor:</strong>
    {{ $primjerak->knjiga->autor }}
</p>

<p>
    <a href="{{ route('primjerci.edit', $primjerak) }}">
        Uredi primjerak
    </a>
</p>

<p>
    <a href="{{ route('primjerci.index') }}">
        Povratak na popis primjeraka
    </a>
</p>

</body>
</html>
