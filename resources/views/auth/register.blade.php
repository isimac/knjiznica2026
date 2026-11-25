<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registracija - IS knjižnica</title>
</head>
<body>
    <h1>Registracija - IS knjižnica</h1>
    <form action="{{route('register.store')}}" method="post">
        @csrf
        <label>Ime i prezime</label>
        <input type="text" name="name" required value="{{old('name')}}" autofocus>
        <br>
        <label>Email</label>
        <input type="email" name="email" required value="{{old('email')}}">
        <br>
        <label>Lozinka</label>
        <input type="password" name="password" required>
        <br>
        <label>Ponovite lozinku</label>
        <input type="password" name="password_confirmation" required>
        <br>
         @if($errors->any())
            <ul>
                @foreach($errors->all() as $greska)
                    <li>{{$greska}}</li>
                @endforeach
            </ul>
        @endif
        <button type="submit">Registiraj se</button>
        
    </form>
    <p>Imate korisnički račun?
    <a href="{{route('login')}}">Prijavite se!</a>
    </p>
</body>
</html>