<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uređivanje člana</title>
</head>
<body>
    <h1>Uređivanje člana</h1>
    <form action="{{route('clanovi.update', $clan)}}" method="post">
        @csrf
        @method('PUT')
        Ime: <input type="text" name="ime" required maxlength="255" value="{{old('ime') ?? $clan->ime}}">
        <br>
        Prezime: <input type="text" name="prezime" required maxlength="255" value="{{old('prezime') ?? $clan->prezime}}">
        <br>
        Broj mobitela: <input type="text" name="brojMobitela" required maxlength="255" value="{{old('brojMobitela') ?? $clan->brojMobitela}}">
        <br>
        Email: <input type="email" name="email" value="{{old('email') ?? $clan->email}}">
        <br>
        Članski broj: <input type="text" name="clanskiBroj" required maxlength="255" value="{{old('clanskiBroj') ?? $clan->clanskiBroj}}">
        <br>
        <button type="submit">Uredi člana</button>
    </form>
<p><a href="{{route('clanovi.index')}}">Vratite se na popis članova</a></p>
</body>
</html>
