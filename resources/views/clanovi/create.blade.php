<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj novog člana</title>
</head>
<body>
    <form action="{{route('clanovi.store')}}" method="post">
        @csrf
        Ime: <input type="text" name="ime" required maxlength="255" value="{{old('ime')}}">
        <br>
        Prezime: <input type="text" name="prezime" required maxlength="255" value="{{old('prezime')}}">
        <br>
        Broj mobitela: <input type="text" name="brojMobitela" required maxlength="255" value="{{old('brojMobitela')}}">
        <br>
        Email: <input type="email" name="email" value="{{old('email')}}">
        <br>
        Članski broj: <input type="text" name="clanskiBroj" required maxlength="255" value="{{old('clanskiBroj')}}">
        <br>
        <button type="submit">Dodaj novog člana</button>
    </form>
<p><a href="{{route('clanovi.index')}}">Vratite se na popis članova</a></p>
</body>
</html>