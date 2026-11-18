<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Kreiranje nove posudbe</h2>

    <h4>Trenutno odabrana knjiga: {{$primjerak->knjiga->naslov}}</h4>
    <h4>Inventarni broj navedene knjige: {{$primjerak->inventarniBroj}}</h4>

    <form action="{{route('posudba.store')}}" method="post">
        @csrf

    <label for="clan_id">Izaberite clana</label>
    <select name="clan_id" id="clan_id">
        @foreach($clanovi as $clan)
        <option value="{{$clan->id}}">{{$clan->ime}} {{$clan->prezime}} (ID: {{$clan->id}})</option>
        @endforeach
    </select>
    <br>

    <input type="hidden" value="{{$primjerak->id}}" name="primjerak_id">

    <button type="submit">Kreiraj</button>
    </form>
    
</body>
</html>