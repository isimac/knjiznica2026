<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
     <h5>Placanje zakasnine<h5>

     <form action="{{route('posudba.update', $trazenaPosudba)}}" method="post">
        @csrf
        @method('PUT')

        <input type="radio" id="placanjeDa" name="zakasninaPlacena" value="1">
        <label for="placanjeDa">DA</label><br>
        <input type="radio" id="placanjeNe" name="zakasninaPlacena" value="0">
        <label for="placanjeNe">NE</label><br>

        <button type="submit">Posalji</button>
     </form>

     <p>Povratak na <a href="{{route('posudba.index')}}">popis posudbi</a></p>
</body>
</html>