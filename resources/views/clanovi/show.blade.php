<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upravljanje clanovima - prikaz clana</title>
</head>
<body>
    <h1>Detalji clana {{$clan->ime}}</h1>
    <br>
    <h3>{{$clan->ime}}</h3>
    <br>
    <h5>{{$clan->prezime}}</h5>
    <br>
    <h5>{{$clan->brojMobitela ?? 'Nije unesen'}}</h5>
    <br>
    <h5>{{$clan->email}}</h5>
    <br>
    <h5>{{$clan->clanskiBroj}}</h5>
    <br>
    

    <p>
        Povratak na <a href="{{route('clan.index')}}">popis clanova</a>
    </p>

</body>
</html>