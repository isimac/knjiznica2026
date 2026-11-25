<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registracija - IS Knjiznica</title>
</head>
<body>
    <h1>Registracija - IS Knjiznica</h1>

    <form action="{{route('register.store')}}" method="post">
        @csrf
        <label>Korisnicko ime: </label>
        <input type="text" name="name" value="{{old('name')}}" required autofocus></input>
        <br>
        <label>email: </label>
        <input type="email" name="email" required></input>
        <br>
        <label>Lozinka: </label>
        <input type="password" name="password" required></input>
        <br>
        <label>Ponovljena lozinka: </label>
        <input type="password" name="password_confirmation" required></input>
        <br>
        @if($errors->any())
        <ul>
            @foreach($errors->all() as $error)
            <li>{{$error}}</li>
            @endforeach
        </ul>
        @endif
        <button type="submit">Registriraj me</button>
    </form>

    <p>Imate racun? <a href="{{route('login')}}">Prijavite se</a></p>
    
</body>
</html>