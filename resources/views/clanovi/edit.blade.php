
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Uređivanje člana</title>
</head>
<body>

<h1>Uređivanje člana</h1>

<form action="{{ route('clanovi.update', $clan) }}" method="POST">
    @csrf
    @method('PUT')

    <label for="ime">Ime</label>
    <input type="text" id="ime" name="ime" value="{{ old('ime', $clan->ime) }}" required>
    @error('ime') 
    <p>{{ $message }}</p> @enderror

    <br><br>

    <label for="prezime">Prezime</label>
    <input type="text" id="prezime" name="prezime" value="{{ old('prezime', $clan->prezime) }}" required>
    @error('prezime') 
    <p>{{ $message }}</p> @enderror

    <br><br>

    <label for="clanskiBroj">Članski broj</label>
    <input type="text" id="clanskiBroj" name="clanskiBroj" value="{{ old('clanskiBroj', $clan->clanskiBroj) }}" required>
    @error('clanskiBroj') 
    <p>{{ $message }}</p> @enderror

    <br><br>

    <label for="email">E-mail adresa</label>
    <input type="email" id="email" name="email" value="{{ old('email', $clan->email) }}">
    @error('email') <p>{{ $message }}</p> @enderror

    <br><br>

    <label for="brojMobitela">Broj mobitela</label>
    <input type="text" id="brojMobitela" name="brojMobitela" value="{{ old('brojMobitela', $clan->brojMobitela) }}">
    @error('brojMobitela') 
    <p>{{ $message }}</p> @enderror

    <br>

    <button type="submit">Spremi izmjene</button>
</form>

<p>
    <a href="{{ route('clanovi.index') }}">Povratak na popis članova</a>
</p>

</body>
</html>
