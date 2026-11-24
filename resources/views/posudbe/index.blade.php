<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aktivne posudbe</title>
</head>
<body>
    <h1>Aktivne posudbe</h1>
    <br>
    <a href="{{route('posudbe.create')}}">Kreiraj novu posudbu</a>
    <br>
    @if(session('uspjeh')) {{session('uspjeh')}}
    @endif
    <br>
    @if(session('greska')) {{session('greska')}}
    @endif
    <br>

    <br>
    <a href="{{route('knjige.index')}}">Povratak na popis knjiga</a>
   <br>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Clan</th>
            <th>Knjiga</th>
            <th>Inventarni broj</th>
            <th>Datum posudbe</th>
            <th>Datum povrata</th>
            <th>Status</th>
            <th>Akcije</th>
        </tr>
    
    @forelse($posudbe as $posudba)
        <tr>
            <td>{{$posudba->id}}</td>
            <td>{{$posudba->clan->ime}} {{$posudba->clan->prezime}}</td>
            <td>{{$posudba->primjerak->knjiga->naslov}}</td>
            <td>{{$posudba->primjerak->inventarniBroj}}</td>
            <td>{{$posudba->datumPosudbe->format('d.m.Y')}}</td>
            <td>{{$posudba->datumPovrata?->format('d.m.Y') ?? 'Knjiga jos nije vracena'}}</td>
            <td>
                @if($posudba->datumPosudbe->copy()->addDays(30)<today())
                    <strong style="color:red;">Kasni <strong>
                @else
                    <strong style="color:green;">Ne kasni <strong>
                @endif
            </td>
            <td>
                <form   action="{{route('posudbe.povrat', $posudba)}}" 
                        method="post" 
                        onsubmit="return confirm('Zelite li vratiti knjigu?')"
                        >
                @csrf
                @method('PATCH')
                    <button type="submit">Povrat knjige</button>
                </form>
            </td>
        </tr>
    
    @empty
        <tr>
            <td colspan="7">Trenutno nema aktivnih posudbi<td>
        </tr>
    @endforelse
    </table>
    

</body>
</html>