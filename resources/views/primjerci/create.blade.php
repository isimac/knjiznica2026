<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primjerci - Dodaj primjerak</title>
</head>
<body>
    <h1>Dodaj novi primjerak</h1>

    <form action="{{route('primjerci.store')}}" method="post">
        @csrf
        <label>Unesite inventarni broj</label>
        <input type="text" name="inventarniBroj" maxlength="255" required>
        <br>
        <input type="hidden" value="{{$knjiga->id}}" name="knjiga_id">
        <input type="hidden" value="{{0}}" name="posuden">
        <button type="submit">Dodaj</button>
    </form>
</body>
</html>