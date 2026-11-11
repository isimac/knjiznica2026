<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Knjiznica - dodavanje nove knjige</title>
</head>
<body>
    <h1>Dodavanje nove knjige</h1>
    <form action="{{route('knjige.store')}}" method="post">
        @csrf
        <label>Naslov</label>
        <input type="text" name="naslov" required maxlength="255" value="{{old('naslov')}}"></input>
        <label>Autor</label>
        <input type="text" name="autor" required maxlength="255" value="{{old('autor')}}"></input>
        <label>ISBN</label>
        <input type="text" name="isbn" maxlength="13" value="{{old('isbn')}}"></input>
        @error ('isbn')
        <p>{{$message}}</p>
        @enderror
        <label>Godina izdanja</label>
        <input type="number" name="godinaIzdanja" required value="{{old('godinaIzdanja')}}"></input>
        <button type="submit">Spremi!</button>
    </form>
</body>
</html>