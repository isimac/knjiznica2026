<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primjerak - uredi</title>
</head>
<body>
    <h1>Uredi primjerak</h1>

    <form action="{{route('primjerci.update', $primjerak)}}" method="post">
        @csrf
        @method('PUT')

    <label>Inventarni broj:</label>
    <input type="text" name="inventarniBroj" value="{{old('inventarniBroj', $primjerak->inventarniBroj)}}" maxlength="255" required>
    <input type="hidden" name="posuden" value="0">
    <button>Posalji</button>
    </form>
</body>
</html>