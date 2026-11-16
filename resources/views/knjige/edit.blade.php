<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Knjižnica - uređivanje knjige</title>
</head>
<body>
    <h1>Knjižnica - uređivanje knjige</h1>
    <p>Uređujete knjigu: <strong>{{$knjiga->naslov}}</strong></p>

    <form action="{{route('knjige.update', $knjiga)}}" method="post">
        @csrf
        @method('PUT')
        Naslov:<input type="text" name="naslov" value="{{old('naslov')}}" maxlength="255" required>
        <br>
        Autor: <input type="text" name="autor" value="{{old('autor')}}" maxlength="255" required>
        <br>
        ISBN: <input type="text" name="isbn" value="{{old('isbn')}}" maxlength="13">
        <br>
        Godinja izdanja: <input type="number" name="godinaIzdanja" value="{{old('godinaIzdanja')}}" min="1900" max="{{date('Y')}}" required>
        <br>
        <button type="submit">Spremi izmjene</button>
    </form>
    <p><a href="{{route('knjige.index')}}">Povrat na popis knjiga</a></p>
</body>
</html>