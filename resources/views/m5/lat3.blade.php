<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Minggu 05: Latihan 01</title>
</head>

<body>
    <h1>Minggu 05: Latihan 03</h1>
    <p>Halo, nama saya <b>{{ $nama }}</b>, skor saya <b>{{ $skor }}</b>
    @if ($skor <= 20)
        (<b>grade E</b>)
    @elseif ($skor <= 40 )
        (<b>Grade D</b>)
    @elseif ($skor <= 60)
        (<b>Grade B</b>)
    @else
        (<b>Grade A</b>)
    @endif
    </p>
        
</body>
</html>