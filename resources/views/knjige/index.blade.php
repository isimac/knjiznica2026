<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Knjižnica - popis knjiga</title>
    <style>
        td {
        text-align: center;
    }
    </style>
    
</head>
<body>
    <h1>Informacijski sustav knjižnice</h1>
    <p><a href="{{route('knjige.create')}}">Dodaj novu knjigu</a></p>

    @if(session('uspjeh'))<!-- da nam se ispiše poruka kada je nova knjiga spremljena-->
        <p>{{session('uspjeh')}}</p>
    @endif
    <h3><strong>Popis knjiga</strong></h3>
    @if($knjige->isEmpty())
        <p>U knjižnici nema knjiga</p>
    @else
        <table border='1'>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Naslov</th>
                    <th>Autor</th>
                    <th>ISBN</th>
                    <th>Godina Izdanja</th>
                    <th>Broj primjeraka</th>
                </tr>
            </thead>
            <tbody>
                @foreach($knjige as $knjiga)
                <tr>
                    <td>{{$knjiga->id}}</td>
                    <td>{{$knjiga->naslov}}</td>
                    <td>{{$knjiga->autor}}</td>
                    <td>{{$knjiga->isbn ?? '-'}}</td><!-- ako nema vrijednost (null) ispisati će se - -->
                    <td>{{$knjiga->godinaIzdanja}}</td>
                    <td>{{$knjiga->primjerak_count}}</td><!-- da se prikaže broj primjeraka -->
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>