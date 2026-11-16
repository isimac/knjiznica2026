<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Knjižnica-popis knjiga</title>
</head>
<body>
    <h1>Informacijski sustav knjižnice</h1>
    <a href
        <h3><strong>Popis knjiga</strong></h3>

        @if($knjige->isEmpty())
        <p>U knjižnici nema knjiga</p>
        @else
        <table>
            <theas>
                <tr>
                    <th>ID</th>
                    <th>Naslov</th>
                    <th>Autor</th>
                     <th>ISBN</th>
                      <th>Godina izdanaj</th>
                   </tr>
            </thead>

               <tbody>
                @foreach($knjige as $knjiga)
                 <tr>
                    <td>{{$knjiga->id}}</td>
                     <td>{{$knjiga->naslov}}</td>
                      <td>{{$knjiga->autor}}</td>
                       <td>{{$knjiga->isbn?? 'nema podatka'}}</td>
                         <td>{{$knjiga->godinaIzdanja}}</td>
</tr>
                @endforeach
</tbody>
</table>
@endif

</body>
</html>