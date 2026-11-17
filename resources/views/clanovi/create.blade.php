<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upravljanje clanovima - Dodaj clana</title>
</head>
<body>
    <h1>Dodavanje novog clana</h1>

    <form action="{{route('clan.store')}}" method="post">
        @csrf
        <label>Ime: </label>
        <input type="text" required name="ime">
        <br>
        <label>Prezime: </label>
        <input type="text" required name="prezime">
        <br>
        <label>Broj mobitela: </label>
        <input type="text" required name="brojMobitela">
        <br>
        <label>email: </label>
        <input type="email" required name="email">
        <br>
        <label>Clanski broj: </label>
        <input type="text" required name="clanskiBroj">
        <br>

        <button type="submit">Posalji</button>
    </form>

    <p>Povratak na <a href="{{route('clan.index')}}">popis clanova</a></p>
    
</body>
</html>