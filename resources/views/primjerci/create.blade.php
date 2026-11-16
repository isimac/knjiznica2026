<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unos novog primjerka</title>
</head>
<body>
    <h1>Unos novog primjerka</h1>
    <form action="{{route('primjerci.store', $knjiga)}}" method="post">
        @csrf
        Inventarni Broj: <input type="text" name="inventarniBroj" required maxlength="13">
        <input type="hidden" name="knjiga_id" value="{{$knjiga->id}}">
        <br>
        <button type="submit">Unesite novi primjerak</button>
    </form>
    <p><a href="{{route('knjige.show', $knjiga)}}">Povratak na popis primjeraka knjige {{$knjiga->naslov}}</a></p>
</body>
</html>