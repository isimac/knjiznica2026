<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Knjižnica - dodavanje knjige</title>
</head>
<body>
    <h1>Dodavanje nove knjige</h1>

    <form action="{{route('knjige.store')}}" method="POST">
    @csrf
    <label>Naslov</label>
    <input type="text" name="naslov" required maxlength="255" value="{{old('naslov')}}">
    <label>Autor</label>
    <input type="text" name="autor" required maxlength="255" value="{{old('autor')}}">
    <label>ISBN</label>
    <input type="text" name="isbn" required maxlength="13" value="{{old('isbn')}}">

    @error('isbn')
    <p>{{$message}}</p>
    @enderror

    <label>Godina izdanja</label>
    <input type="number" name="godinaIzdanja" required min="1900" max="{{date('Y')}}" value="{{old('godinaIzdanja')}}">
    <button type="submit">Spremi knjigu</button>
    </form>

    <p>
        <a href="{{route('knjige.index')}}">Povratak na popis knjiga</a>
    </p>
</body>
</html>