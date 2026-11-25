<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prijava - IS knjižnica</title>
</head>
<body>
    
    <h1>Prijava - IS knjižnica</h1>

    @if(session('uspjeh'))
    <p>{{session('uspjeh')}}</p>
    @endif

    <form action="{{route('login.store')}}" method="POST">
        @csrf
        <label>Email</label>
        <input type="email" name="email" value="{{old('email')}}" required autofocus>
        <br>
        <label>Lozinka</label>
        <input type="password" name="password" required>
        <br>
        @if($errors->any()) 
        <ul>
            @foreach($errors->all() as $greska)
            <li>{{$greska}}</li>
            @endforeach
        </ul>
        @endif
        <button type="submit">Prijavi se</button>
    </form>

      <p>
        Nemate korisnički račun?
            <a href="{{route('register')}}">Registrirajte se</a>
    </p>

</body>
</html>