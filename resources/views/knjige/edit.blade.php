<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Knjižnica - uređivanje knjige</title>
</head>
<body>
    <h1>Knjižnica - uređivanje knjige</h1>
<p>Uređujete knjigu: <strong>{{ $knjiga->naslov }}</strong></p>
    <form action="{{route('knjige.update', $knjiga)}}" method="POST">
        @csrf
        @method('PUT')
        <label>Naslov</label>
        <input type="text" name="naslov" value="{{old('naslov', $knjiga->naslov)}}" maxlength="255" required>
        <label>Autor</label>
        <input type="text" name="autor" value="{{old('autor', $knjiga->autor)}}" maxlength="255" required>
        <label>ISBN</label>
        <input type="text" name="isbn" value="{{old('isbn', $knjiga->isbn)}}" maxlength="13">
        <label>Godina Izdanja</label>
        <input type="number" name="godinaIzdanja" value="{{old('godinaIzdanja', $knjiga->godinaIzdanja)}}" min="1900" max="{{date('Y')}}" required>

        <button type="submit">Spremi izmjene</button>
</form>
<p>
        <a href="{{route('knjige.index')}}">>Nešto.</a>
</p>


    </form>
    
</body>
</html>