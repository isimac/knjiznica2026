<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Knjiznica - posudbe</title>
</head>
<body>
    <h1>Upravljanje posudbama</h1>

    <h3><strong>Aktivne posudbe</h3>
    
    @if($posudbe->isEmpty()) 
        <p>Trenutno nema aktivnih posudbi</p>
    @else
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Clan</th>
                    <th>Primjerak</th>
                    <th>Datum posudbe</th>
                    <th>Datum povrata</th>
                    <th>Broj dana kasnjenja</th>
                    <th>Zakasnina placena?</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posudbe as $posudba)
                <tr>
                    <td>{{$posudba->id}}</td>
                    <td>{{$posudba->clan_id}}</td>
                    <td>{{$posudba->primjerak_id}}</td>
                    <td>{{$posudba->datumPosudbe}}</td>
                    <td>{{$posudba->datumPovrata}}</td>
                    <td>{{$posudba->brojDanaKasnjenja}}</td>
                    <td>{{$posudba->zakasninaPlacena}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    
</body>
</html>