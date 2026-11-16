<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Dodavanje primjerka</title>
</head>
<body>

<h1>Dodavanje primjerka</h1>

<p>
    Knjiga: <strong>{{ $knjiga->naslov }}</strong>
</p>

<form
    action="{{ route('primjerci.store', $knjiga) }}" method="POST">
    @csrf

    <label>Inventarni broj:</label>

    <input type="text" name="inventarniBroj" value="{{ old('inventarniBroj') }}" required
    >

    @error('inventarniBroj')
        <p>{{ $message }}</p>
    @enderror

    <button type="submit">Dodaj primjerak</button>
</form>

<p>
    <a href="{{ route('knjige.show', $knjiga) }}"> Povratak na knjigu
    </a>
</p>

</body>
</html>