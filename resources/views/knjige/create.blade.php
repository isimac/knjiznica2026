<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Knjižnica - dodavanje knjige</title>
</head>
<body>
    <h1>Dodavanje nove knjige</h1>
    <form action="{{route('knjige.store')}}" method="post"><!-- zato što smo koristili r('knjige store') dali smo mu naziv rute da zna koju rutu želimo koristiti-->
        @csrf
        <label>Naslov</label>
        <input type="text" name="naslov" required maxlength="255" value="{{old('naslov')}}">
        <br>
        <label>Autor</label>
        <input type="text" name="autor" required maxlength="255" value="{{old('autor')}}">
        <br>
        <label>ISBN</label>
        <input type="text" name="isbn" maxlength="13">
            @error('isbn') <!-- iz kontrolera nam vraća taj error -->
                <p>{{$message}}</p>
            @enderror
        <br>
        <label>Godina izdanja</label>
        <input type="number" name="godinaIzdanja" required value="{{old('godinaIzdanja')}}" min="1900" max="{{date('Y')}}">
        <br>
        <button type="submit">Spremi knjigu</button>
    </form>
    <p><a href="{{route('knjige.index')}}">Povratak na popis knjiga</a></p>
</body>
</html>