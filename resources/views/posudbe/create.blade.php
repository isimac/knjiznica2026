<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova posudba</title>
</head>
<body>
    <h1>Nova posudba</h1>
    <form action="{{route('posudbe.store')}}" method="POST">
        @csrf
    <label>Odaberite člana</label>
        <select name="clan_id" required>
            <option value="">Odaberite člana</option>
            @foreach($clanovi as $clan)
                <option value="{{$clan->id}}" @selected(old('clan_id')==$clan->id)>
                    {{$clan->prezime}}
                    {{$clan->ime}}
                    {{$clan->clanskiBroj}}
                </option>
            @endforeach
        </select>
        <br>

        @error('clan_id')
            <p>{{$message}}</p>
        @enderror
        <br>

        <label>Odaberite dostupni primjerak</label>
        <select name="primjerak_id" required>
            <option value="">Odaberite primjerak</option>
            @foreach($primjerci as $primjerak)
                <option value="{{$primjerak->id}}" @selected(old('primjerak_id')==$primjerak->id)>
                    {{$primjerak->knjiga->naslov}}
                    {{$primjerak->inventarniBroj}}
                    
                </option>
            @endforeach
        </select>
        <br>
        
        @error('primjerak_id')
            <p>{{$message}}</p>
        @enderror
        <br>

        <button type="submit">Spremi posudbu</button>
    </form>

    <a href="{{route('posudbe.index')}}">Povratak na posudbe</a>

</body>
</html>