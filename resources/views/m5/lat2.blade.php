<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Minggu 05: Latihan 01</title>
</head>

<body>
    <h1>Minggu 05: Latihan 01</h1>
    <p>Halo, nama saya <b>{{ $nama }}</b>, nilai saya <b>{{ $nilai }}</b>
    @if ($nilai >= 60)
        (<b>Lulus</b>)
    @else
        (<b>Ulang</b>)
    @endif
    </p>
        
</body>
</html>