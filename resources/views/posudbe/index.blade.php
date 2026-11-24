<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Knjižnica - posudbe</title>
</head>
<body>
    <h1>Aktivne posudbe</h1>


    @if(session('uspjeh'))
        <p style="color:green">{{ session('uspjeh') }}</p>
    @endif

    <p><a href="{{ route('posudbe.create') }}">Nova posudba</a></p>

    @if($posudbe->isEmpty())
        <p>Trenutačno nema aktivnih posudbi.</p>
    @else
        <table border="1" cellpadding="6">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Član</th>
                    <th>Knjiga</th>
                    <th>Inventarni broj</th>
                    <th>Datum posudbe</th>
                    <th>Datum povrata</th>
                    <th>Status</th>
                    <th>Akcije</th>

                </tr>
            </thead>
            <tbody>
                @forelse($posudbe as $posudba)
                
                    <tr>
                        <td>{{$posudba->id}}</td>

                        <td>{{$posudba->clan->ime}} {{$posudba->clan->prezime}}</td>
                        <br>
                        <td>{{$posudba->primjerak->knjiga->naslov}}</td>
                        <br>
                        <td>{{$posudba->primjerak->inventarniBroj}}</td>
                        <br>
                        <td>{{$posudba->datumPosudbe->format('d.m.Y.')}}</td>
                        <br>
                        <td>{{$posudba->datumPovrata?->format('d.m.Y.') ?? 'Knjiga nije vraćena'}}</td>
                        <br>
                        <td>
                            @if ($posudba->datumPosudbe->copy()->addDays(30)<today())
                            <strong style="color:red";>Kašnjenje</strong>
                            @else
                                Sve u redu
                            @endif
                        </td>
                        <td>
                            <form action="{{route('posudbe.povrat', $posudba)}}" method="POST" onsubmit="return confirm('Želite li vratiti knjigu?');">
                            @csrf
                            @method('PATCH')
                            <button type="submit">Povrat knjige</button>
                            </form>

                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td>Nema posudbi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endif

    <p><a href="{{route('knjige.index')}}">Povratak na popis knjiga</a></p>
</body>
</html>

