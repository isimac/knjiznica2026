<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prijava - IS Knjiznica</title>
</head>
<body>
    <h1>Prijava - IS Knjiznica</h1>

    @if(session('uspjeh'))
    <p>{{session('uspjeh')}}</p>
    @endif

    <form action="{{route('login')}}" method="post">
    @csrf
        <label>Unesite email</label>
        <input type="email" name="email" value="{{old('email')}}" required autofocus></input>
        <br>
        <label>Unesite lozinku</label>
        <input type="password" name="password" required></input>
        <br>
        @if($errors->any())
        <ul>
            @foreach($errors->all() as $error)
            <li>{{$error}}</li>
            @endforeach
        </ul>
        @endif
        <button type=""submit">Logiraj me!</button>
    </form>

    <p>Nemate racun? <a href="{{route('register')}}">Registrirajte se</a></p>
</body>
</html>
