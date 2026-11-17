<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upravljanje clanovima - Uredi clana</title>
</head>
<body>
     <h1>Uredivanje clana {{$clan->ime}}</h1>

    <form action="{{route('clan.update', $clan)}}" method="post">
        @csrf
        @method('PUT')
        <label>Ime: </label>
        <input type="text" required name="ime" value="{{old('ime', $clan->ime)}}">
        <br>
        <label>Prezime: </label>
        <input type="text" required name="prezime" value="{{old('prezime', $clan->prezime)}}">
        <br>
        <label>Broj mobitela: </label>
        <input type="text" required name="brojMobitela" value="{{old('brojMobitela', $clan->brojMobitela)}}">
        <br>
        <label>email: </label>
        <input type="email" required name="email" value="{{old('email', $clan->email)}}">
        <br>
        <label>Clanski broj: </label>
        <input type="text" required name="clanskiBroj" value="{{old('clanskiBroj', $clan->clanskiBroj)}}">
        <br>

        <button type="submit">Posalji</button>
    </form>

    <p>Povratak na <a href="{{route('clan.index')}}">popis clanova</a></p>
    
    
</body>
</html>