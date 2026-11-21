<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Knjiznica - posudbe</title>
</head>
<body>
    <h1>Upravljanje posudbama</h1>

     @if(session('uspjeh'))
    {{session('uspjeh')}}
    @endif

    @if(session('greska'))
    {{session('greska')}}
    @endif

    <h5>Filtritaj posudbe<h5>
        <br>
    <h5><a href="{{route('posudba.index')}}">Resetiraj filtere</a></h5>
    <br>
    <form action="{{route('posudba.index.filter')}}" method="post">
        @csrf
        <label for="clan_id">Izaberite clana: </label>
        <select name="clan_id" id="clan_id">
        <option value="empty">Svi clanovi</option>
        @foreach($clanovi as $clan)
        <option value="{{$clan->id}}">{{$clan->ime}} {{$clan->prezime}} (ID: {{$clan->id}})</option>
        @endforeach
        </select>

        
        <select name="knjiga_id" id="knjiga_id">
        <label for="knjiga_id">Izaberite knjigu</label>
        <option value="empty">Sve knjige</option>
        @foreach($knjige as $knjiga)
        <option value="{{$knjiga->id}}">{{$knjiga->naslov}}</option>
        @endforeach
        </select>

        <button type="submit">Filtriraj</button>
    </form>


    
    

    <h3><strong>Aktivne posudbe</h3>
        <table border="1">
            <thead>
                <tr>
                    <th>Ime clana</th>
                    <th>Prezime clana</th>
                    <th>Clanski broj</th>
                    <th>Naslov knjige</th>
                    <th>Autor knjige</th>
                    <th>Datum posudbe</th>
                    <th>Datum povrata</th>
                    <th>Broj dana kasnjenja</th>
                    <th>Akcije</th>
                </tr>
            </thead>
            <tbody>
                @forelse($posudbe as $posudba)
                <tr>
                    <td>{{$posudba->clan_ime}}</td>
                    <td>{{$posudba->clan_prezime}}</td>
                    <td>{{$posudba->clan_clanskiBroj}}</td>
                    <td>{{$posudba->knjiga_naslov}}</td>
                    <td>{{$posudba->knjiga_autor}}</td>
                    <td>{{$posudba->posudba_datumPosudbe}}</td>
                    <td>{{$posudba->posudba_datumPovrata}}</td>
                    <td>{{$posudba->posudba_brojDanaKasnjenja}}</td>
                    <td>
                        <a href="{{route('posudba.edit', $posudba->posudba_id)}}">Uredi</a>
                        <form action="{{route('posudba.destroy', [$posudba->posudba_id, $posudba->primjerak_id])}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Obrisi</button>
                        </form>
                    </td>
                </tr>
                @empty 
                    <p>Trenutno nema aktivnih posudbi</p>

                @endforelse
            </tbody>
        </table>

    <p>Povratak na <a href="{{route('knjige.index')}}">popis knjiga</a></p>
    
</body>
</html>