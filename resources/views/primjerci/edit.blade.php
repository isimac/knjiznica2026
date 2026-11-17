<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uređivanje primjerka</title>
</head>
<body>
    <h1>Uređivanje primjerka</h1>
    <form action="{{route('primjerci.update', $primjerak->id)}}" method="post">
        @csrf
        @method('PUT')
        Inventarni Broj: <input type="text" name="inventarniBroj" required value="{{old('inventarniBroj') ?? $primjerak->inventarniBroj}}">
        <input type="hidden" name="knjiga_id" value='{{$primjerak->knjiga_id}}'>
        <button type="submit">Uredite primjerak knjige</button>
    </form>
    <p><a href="{{route('knjige.show', $primjerak->knjiga_id)}}">Povratak na popis primjeraka</a></p>
</body>
</html>