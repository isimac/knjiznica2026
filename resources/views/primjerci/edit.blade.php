<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Uređivanje primjerka</title>
</head>
<body>

<h1>Uređivanje primjerka</h1>

<p>
    Knjiga: <strong>{{ $primjerak->knjiga->naslov }}</strong>
</p>

<form
    action="{{ route('primjerci.update', $primjerak) }}" method="POST">
        @csrf
    @method('PUT')

    <label> Inventarni broj:>/label>

    <input type="text" name="inventarniBroj" value="{{ old('inventarniBroj', $primjerak->inventarniBroj) }}" required>

    @error('inventarniBroj')
        <p>{{ $message }}</p>
    @enderror

    <button type="submit">Spremi izmjene</button>
</form>

<p>
    <a href="{{ route('primjerci.show', $primjerak) }}">
        Povratak na primjerak
    </a>
</p>

</body>
</html>